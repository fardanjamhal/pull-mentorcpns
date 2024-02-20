<?php

namespace App\Http\Controllers\User\TryOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\Lesson\LessonCategoryRepository;
use App\Repositories\Exam\ExamGroupRepository;
use App\Models\Exam\ExamGroupUser;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\Grade;
use App\Models\UserMemberCategory;
use Illuminate\Support\Facades\Storage;
use App\Models\Lesson\Question;
use App\Models\Lesson\{DetailValueCategory, ValueCategory};
use App\Models\Transaction\Transaction;
use App\Services\CalculateGradeService;
use App\Models\Setting;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use File;
use DB;

class ExamGroupController extends Controller
{
    protected $examGroupRepository;

    public function __construct(ExamGroupRepository $examGroupRepository)
    {
        $this->examGroupRepository = $examGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first() ?? [];
        
        $transactionCategoryIds = Transaction::where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'ASC')
        ->groupBy('category_id')
        ->pluck('category_id')
        ->toArray();
        
        $categories = (new CategoryRepository())->getAllProduction();

        return inertia('User/TryOut/ExamGroup/Index', [
            'categories' => $categories,
            'setting' => $setting
        ]);
    }

    public function examGroupDetail($categoryId)
    {
        if(!(new CategoryRepository())->find($categoryId)) return abort('404', 'uppss....');

        return inertia('User/TryOut/ExamGroup/LessonCategory', [
            'lessonCategories' => (new LessonCategoryRepository())->getAllByCategory($categoryId)
        ]);
    }

    public function examGroupList($categoryId, $lessonCategoryId)
    {
        return inertia('User/TryOut/ExamGroup/Exam', [
            'examGroups' => $this->examGroupRepository->getByLessonCategory($lessonCategoryId, 8),
            'lessonCategory' => (new LessonCategoryRepository())->find($lessonCategoryId),
            'userMemberCategories' => UserMemberCategory::where('category_id', $categoryId)->where('user_id', Auth::user()->id)->where('expired_date', '>', Carbon::now())->get()
        ]);
    }

    public function examGroupShow($categoryId, $lessonCategoryId, $examGroupId)
    {
        return inertia('User/TryOut/ExamGroup/Show', [
            'examGroup' => $this->examGroupRepository->find($examGroupId),
            'lessonCategory' => (new LessonCategoryRepository())->find($lessonCategoryId),
            'examGroupUser' => ExamGroupUser::where(['user_id' => auth()->user()->id, 'exam_group_id' => $examGroupId])->first()
        ]);
    }

    public function examGroupHistory()
    {
        $histories =  ExamGroupUser::with([
            'examGroup',
            'examGroup.lessonCategory',
            'examGroup.category',
        ])
        ->where(['user_id' => Auth::user()->id])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);


        return inertia('User/TryOut/ExamGroup/History', [
            'histories' => $histories
        ]);
    }

    public function examGroupHistoryDetail($id)
    {   
        $historyUpdate = ExamGroupUser::with([
            'examGroup.grade' => function ($query) {
                $query->where('user_id', Auth::user()->id)->where('is_finished', 1);
            }
        ])
        ->findOrFail($id);

        foreach($historyUpdate->examGroup->grade as $grade) {
            if($grade->grade_calculate == 0) {
                (new CalculateGradeService())->calculateGradeCategory($grade->id);
            }
        }

        $history = ExamGroupUser::with([
            'examGroup.lessonCategory',
            'examGroup.category',
            'examGroup.grade' => function ($query) {
                $query->orderBy('created_at', 'asc');
                $query->where('user_id', Auth::user()->id)
                    ->with([
                        'lesson',
                        'exam.questionTitle',
                    ]);
            },
        ])
        ->find($id);

        return inertia('User/TryOut/ExamGroup/HistoryDetail', [
            'history' => $history,
        ]);
    }

    function checkMemberCategories($data, $categories) 
    {
        if($categories) {
            foreach ($data as $entry) {
                if (count(array_intersect($entry['member_categories'], $categories)) > 0) {
                    return true;
                }
            }
            return false;
        } else {
            return true;
        }
    }

    public function examStart($id, Request $request)
    { 
        DB::beginTransaction();

        try {
            $setting = Setting::first();

            $examGroup = ExamGroup::with(['exam' => function ($query) {
                $query->orderBy('created_at', 'ASC');
            }])->find($id);

            if(Auth::user()->member_type == 2) {

                $checkAcess = false;

                $checkMemberCategories = $this->checkMemberCategories(UserMemberCategory::where(['category_id' => $examGroup->category_id, 'user_id' => Auth::user()->id])->where('expired_date', '>', Carbon::now())->get(), $examGroup->member_categories);

                if($setting->purchase_type == 1 && count($examGroup->transaction) > 0) {
                    $checkAcess = true;
                }

                if($setting->purchase_type == 2 && $checkMemberCategories == true) {
                    $checkAcess = true;
                }

                if($setting->purchase_type == 3 && (count($examGroup->transaction) > 0 || $checkMemberCategories == true)) {
                    $checkAcess = true;
                }

                if($checkAcess === false) {
                    session()->flash('failed', 'Anda tidak memiliki akses pada try out ini. Silakan lakukan transaksi terlebih dahulu.');
                    return redirect()->back();
                }
            }
            
            $this->removeOldFiles();

            $examGroupUser = ExamGroupUser::where('exam_group_id', $examGroup->id)->where('user_id', auth()->user()->id);

            if($request->repeat == 1) {
                $examGroupUser->delete();
                Grade::where('exam_group_id', $examGroup->id)->where('user_id', auth()->user()->id)->delete();
            }
            
            $examGroupUser = $examGroupUser->first();

            if(!$examGroupUser) {
                $examGroupUser = new ExamGroupUser();
                $examGroupUser->user_id = auth()->user()->id;
                $examGroupUser->exam_group_id = $examGroup->id;

                $examGroupUser->duration = $examGroup->duration;
                $examGroupUser->section = 1;
                $examGroupUser->total_section = 1;
                $examGroupUser->start_time = Carbon::now();
                $examGroupUser->end_time = Carbon::now()->addMinutes($examGroup->duration)->addSeconds(1);
                $examGroupUser->total_correct = 0;

                $examGroupUser->total_tolerance = $examGroup->total_tolerance;
                $examGroupUser->is_blocked = 0;
                $examGroupUser->grade = 0;
                $examGroupUser->is_finished = 0;    
                $examGroupUser->save();
                $examGroupUser->refresh();
            }

            $examGroupUser->grade = 0;
            $examGroupUser->is_finished = 0;    
            $examGroupUser->save();
            $examGroupUser->refresh();

            foreach($examGroup->exam as $index => $exam) {
                $grade = Grade::where('exam_id', $exam->id)->where('user_id', auth()->user()->id)->first();
                $totalSection = $exam->questionTitle->total_section;

                if(!$grade) {
                    $answerInsert = [];
                    $grade = new Grade();
                    $grade->category_id = $exam->category_id;
                    $grade->lesson_category_id = $exam->lesson_category_id;
                    $grade->lesson_id = $exam->lesson_id;
                    $grade->exam_id = $exam->id;
                    $grade->exam_group_id = $exam->exam_group_id;
                    $grade->user_id = auth()->user()->id;
                    $grade->section = 1;
                    $grade->exam_group_id = $exam->exam_group_id;
                    $grade->total_correct = 0;
                    $grade->total_section = $totalSection;
                    $grade->grade = 0;
                    $grade->is_finished = 0;    
                    $grade->answers = [];
                    $grade->created_at = Carbon::now()->addMinutes($index);
                    $grade->updated_at = Carbon::now()->addMinutes($index);
                    $grade->save();
                    $grade->refresh();
                }
            }

            if($examGroup->random_question || $examGroup->random_answer) {
                $path = 'json/user-id-'.Auth::user()->id.'-exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
            } else {
                $path = 'json/exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
            }

            if(!Storage::exists($path)) {

                if($examGroup->random_question == 1 || $examGroup->random_answer == 1) {
                    $files = glob(Storage::path('json/') . 'user-id-'.Auth::user()->id.'-exam-group-'.$examGroup->id. '-*.json');
                } else {
                    $files = glob(Storage::path('json/') . 'exam-group-'.$examGroup->id. '-*.json');
                }
            
                foreach($files as $file) {
                    File::delete($file);
                }

                $question_order = 1;
                $questionInserts = [];
                
                $navigation_order = 0;

                foreach($examGroup->exam as $exam) {
                    for($i = 1; $i <= $totalSection; $i++) {
                        if($examGroup->random_question == 1) {
                            $questions = Question::where('section', $i)->where('question_title_id', $exam->question_title_id)->inRandomOrder()->get();
                        } else {
                            $questions = Question::where('section', $i)->where('question_title_id', $exam->question_title_id)->orderBy('created_at', 'ASC')->get();
                        }

                        foreach ($questions as $question) {
                            $navigation_order++;
                            
                            $options = [];
                            if($question->option_1 != null) $options[] = 1;
                            if($question->option_2 != null) $options[] = 2;
                            if($question->option_3 != null) $options[] = 3;
                            if($question->option_4 != null) $options[] = 4;
                            if($question->option_5 != null) $options[] = 5;
            
                            if($examGroup->random_answer == 1) {
                                shuffle($options);
                            }
            
                            $questionInserts[] = [
                                'question_title_id' => $question->question_title_id,
                                'question_id' => $question->id,
                                'navigation_order' => $navigation_order,
                                'value_category_id' => $question->value_category_id,
                                'question_order' => $question_order,
                                'question' => $question->question,
                                'question_answer' => $question->answer,
                                'option_1' => $question->option_1,
                                'option_2' => $question->option_2,
                                'option_3' => $question->option_3,
                                'option_4' => $question->option_4,
                                'option_5' => $question->option_5,
                                'point_1' => $question->point_1,
                                'point_2' => $question->point_2,
                                'point_3' => $question->point_3,
                                'point_4' => $question->point_4,
                                'point_5' => $question->point_5,
                                'wrong_point' => $question->wrong_point,
                                'correct_point' => $question->correct_point,
                                'section' => $question->section,
                                'answer_order' => implode(",", $options),
                                'answer' => 0,
                                'is_correct' => 'N'
            
                            ];
            
                            $question_order++;
                        }    
                    }
                }

                Storage::put($path, json_encode($questionInserts));    
            }

            DB::commit();

            return redirect()->route('user.exam-groups.exam-show-questions', [$examGroup->id, $examGroupUser->section]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }

    public function examShowQuestion($id, $section, Request $request)
    {
        $examGroup = ExamGroup::find($id);

        if($examGroup->random_question || $examGroup->random_answer) {
            $path = 'json/user-id-'.Auth::user()->id.'-exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
        } else {
            $path = 'json/exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
        }

        if (!Storage::exists($path)) {
            return redirect()->route('user.exam-groups.exam-start', $examGroup->id);
        }

        $examGroupUser = ExamGroupUser::where('exam_group_id', $examGroup->id)->where('user_id', auth()->user()->id)->first();

        if($examGroupUser->is_finished == 1) {
            return redirect()->route('user.exam_group.show', [$examGroup->category_id, $examGroup->lesson_category_id, $examGroup->id]);
        }

        if($section != $examGroupUser->section && empty($request->nextsection)) {
            return redirect()->route('user.exam-groups.exam-show-questions', [$grade->exam_id, 1, $grade->section]);
        }

        if($examGroupUser->section < $section) {
            $examGroupUser->section = $examGroupUser->section + 1;
            $examGroupUser->end_time = Carbon::now()->addMinutes($exam->duration)->addSeconds(1);
            $examGroupUser->update();
            $examGroupUser->refresh();
        }

        $duration = $examGroupUser->end_time > Carbon::now() || empty($examGroupUser->end_time) ? $examGroupUser->end_time->diffInMilliseconds(Carbon::now()) : 0;    

        $json = Storage::get($path);    
        $gradeAnswers = json_decode($json, true);

        $questionLists = array_filter($gradeAnswers, function ($var) use($section) {
            return ($var['section'] == $section);
        });

        $questionLists = empty($questionLists) ? [] : array_values($questionLists);

        $totalQuetions = count($questionLists);

        return inertia('User/TryOut/ExamGroup/Question', [
            'exam' => $examGroup,
            'grade' => $examGroupUser,
            'questionLists' => $questionLists,
            'duration' => $duration,
            'section' => (int) $examGroupUser->section,
            'indexPage' => 0,
            'lastSection' => (int) $examGroupUser->total_section,
        ]);
    }

    /**
     * decrementTolerance
     *
     * @param  mixed $request
     * @return void
     */
    public function decrementTolerance(Request $request)
    {
        $grade = ExamGroupUser::find($request->grade_id);
        $total_tolerance = $grade->total_tolerance > 0 ? $grade->total_tolerance - 1 : 0 ;
        $is_blocked = $total_tolerance <= 0 ? 1 : 0;
        $grade->update(['total_tolerance' => $total_tolerance, 'is_blocked' => $is_blocked]);
    }

    /**
     * endExam
     *
     * @param  mixed $request
     * @return void
     */
    public function endExam($examId, Request $request)
    {
        DB::beginTransaction();

        try {

            $examGroup = ExamGroup::with([
                'grade' => function ($query) {
                    $query->where('user_id', Auth::user()->id);
                },
                'grade.exam',
            ])->withCount(['exam', 'grade'])->find($examId);

            
            if($examGroup->random_question || $examGroup->random_answer) {
                $path = 'json/user-id-'.Auth::user()->id.'-exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
            } else {
                $path = 'json/exam-group-'.$examGroup->id.'-exam-group-updated-at-'.$examGroup->updated_at->format('Ymdhis'). '.json';
            }
            
            if (!Storage::exists($path)) {
                return redirect()->route('user.exam-groups.exam-start', $exam->id);
            }

            $json = Storage::get($path);

            $gradeAnswer = json_decode($json, true);

            foreach ($examGroup->grade as $grade) {
                $gradeAnswers = array_filter($gradeAnswer, function ($item) use ($grade) {
                    return $item['question_title_id'] === $grade->exam->question_title_id;
                });

                $gradeAnswers = array_map(function ($gradeAnswer) use ($request) {
                    $data = array_filter($request->myAnswers, function ($item) use ($gradeAnswer) {
                        return $item['question_id'] === $gradeAnswer['question_id'];
                    });

                    if (!empty($data)) {
                        $answer = (int) reset($data)['answer'];
                        $gradeAnswer['answer'] = $answer;
                        $gradeAnswer['is_correct'] = ($answer === (int) $gradeAnswer['question_answer']) ? "Y" : "N";
                    }

                    return $gradeAnswer;
                }, $gradeAnswers);

                $totalCorrectPerSection = array_reduce(range(1, $grade->exam->questionTitle->total_section), function ($carry, $i) use ($gradeAnswers) {
                    $totalCorrect = array_filter($gradeAnswers, function ($var) use ($i) {
                        return ($var['is_correct'] == "Y" && $var['section'] == $i);
                    });
                    $carry[] = count($totalCorrect);
                    return $carry;
                }, []);

                $totalCorrect = array_filter($gradeAnswers, function ($var) {
                    return ($var['is_correct'] === "Y" && $var['answer'] !== 0);
                });

                $totalAnswer = array_filter($gradeAnswers, function ($var) {
                    return ($var['answer'] !== 0);
                });

                $totalWrong = array_filter($gradeAnswers, function ($var) {
                    return ($var['is_correct'] === "N");
                });

                $totalQuestionGrade = count($gradeAnswers);
                $count_correct_answer = count($totalCorrect);

                $grade_exam = 0;

                if ($grade->exam->questionTitle->assessment_type == 3) {
                    $grade_exam = array_reduce($totalCorrect, function ($carry, $correct) {
                        return $carry + $correct['correct_point'];
                    }, 0);
                } elseif ($grade->exam->questionTitle->assessment_type == 4) {
                    $grade_exam = array_reduce($totalAnswer, function ($carry, $correct) {
                        return $carry + $correct['point_' . $correct['answer']];
                    }, 0);
                } else {
                    $grade_exam = round($count_correct_answer / $totalQuestionGrade * 100, 2);
                }

                $gradeAnswers = array_map(function ($item) {
                    unset($item['id']);
                    unset($item['audio']);
                    unset($item['section']);
                    unset($item['option_1']);
                    unset($item['option_2']);
                    unset($item['option_3']);
                    unset($item['option_4']);
                    unset($item['option_5']);
                    unset($item['question']);
                    unset($item['created_at']);
                    unset($item['deleted_at']);
                    unset($item['discussion']);
                    unset($item['deleted_at']);
                    unset($item['updated_at']);
                    unset($item['audio_input']);
                    unset($item['wrong_point']);
                    unset($item['question_order']);
                    unset($item['question_answer']);
                    unset($item['audio_answer_time']);
                    unset($item['question_title_id']);
                    unset($item['audio_played_limit']);
                    
                    return $item;
                }, $gradeAnswers);

                $updates = [
                    'end_time' => Carbon::now(),
                    'total_correct' => $count_correct_answer,
                    'grade' => $grade_exam,
                    'is_finished' => 1,
                    'answers' => serialize($gradeAnswers),
                ];

                if($grade->exam->exam_group_id && $examGroup->assessment_type == 2) {
                    $updates['percentage_grade'] = $grade->exam->percentage_grade ?? 0;
                    $updates['final_grade'] = $grade_exam * ($updates['percentage_grade'] / 100);
                } else {
                    $updates['final_grade'] = $grade_exam;
                }

                $grade->update($updates);
            }

            ExamGroupUser::where(['exam_group_id' => $examGroup->id, 'user_id' => Auth::id()])->update([
                'is_finished' => 1,
            ]);

            DB::commit();
            
            return redirect()->route('user.exam_group.show', [
                $examGroup->category_id,
                $examGroup->lesson_category_id,
                $examGroup->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e], 500);
        }
    }

    public function removeOldFiles()
    {
        $directoryPath = storage_path('app/json');
        $currentDate = Carbon::now();
        $thresholdDate = $currentDate->subDays(7);

        $oldFiles = [];
        $allFiles = File::allFiles($directoryPath);

        foreach ($allFiles as $file) {
            $fileCreationTime = Carbon::createFromTimestamp($file->getCTime());
            if ($fileCreationTime->lessThan($thresholdDate)) {
                $oldFiles[] = $file->getPathname();
            }
        }

        foreach ($oldFiles as $file) {
            File::delete($file);
        }
    }

    public function examGroupStudentExportPdf($examGroupUserId)
    {
        $examGroupUser = ExamGroupUser::find($examGroupUserId);

        if($examGroupUser->examGroup->certificate_print_user == 0) {
            return abort('404');
        }

        $history = ExamGroupUser::with([
            'examGroup.lessonCategory',
            'examGroup.category',
            'examGroup.grade' => function ($query) use($examGroupUser) {
                $query->orderBy('created_at', 'asc');
                $query->where('user_id', $examGroupUser->user_id)
                    ->with([
                        'lesson',
                        'exam.questionTitle',
                    ]);
            },
        ])
        ->find($examGroupUserId);

        $gradeCount = ExamGroup::withCount('grade')->find($history->exam_group_id);

        $pdf = Pdf::loadView('report.pdf.exam_group', [
            'setting' => Setting::first() ?? [],
            'history' => $history,
            'gradeCount' => $gradeCount->grade_count ?? 0
        ]);

        $filename = str_replace(" ", "_", $history->examGroup->lessonCategory->name.'_'.$history->user->name.'.pdf');
        return $pdf->stream($filename);
    }

    public function unblocked(Request $request, $examGroupId, $examGroupUserId)
    {
        try {

            $exam = ExamGroup::find($examGroupId);

            if($request->token == $exam->unblock_token) {
                ExamGroupUser::find($examGroupUserId)->update(['is_blocked' => 0, "total_tolerance" => $exam->total_tolerance]);
                return response()->json([ "success" => true, "message" => "Membuka Blokir Berhasil"], 200);

            } else {
                return response()->json([ "success" => false, "message" => "Kode Tidak Cocok"], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage()
            ]);
        }
    }
}
