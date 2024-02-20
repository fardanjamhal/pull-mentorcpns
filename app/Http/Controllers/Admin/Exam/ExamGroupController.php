<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Exam\ExamGroupRepository;
use App\Repositories\MasterData\CategoryRepository;
use App\Repositories\Exam\GradeRepository;
use App\Http\Requests\Exam\ExamGroupRequest;
use App\Models\MasterData\SubCategory;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\Grade;
use App\Models\Exam\ExamGroupUser;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Setting;
use Excel;
use App\Exports\ExamGroupExport;
use App\Services\CalculateGradeService;
use App\Repositories\User\MemberCategoryRepository;

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
    public function index(Request $request)
    {
        return inertia('Admin/Exam/ExamGroup/Index', [
            'examGroups' => $this->examGroupRepository->getAllPaginatedWithParams($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Exam/ExamGroup/Create')->with([
            'categories' => (new CategoryRepository())->all(),
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamGroupRequest $request)
    {
        try {
            $this->examGroupRepository->create($request);

            return redirect()->route('admin.exam-groups.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$this->examGroupRepository->find($id)) return abort('404', 'uppss....');

        $exam = $this->examGroupRepository->find($id);

        $rankingExams = (new gradeRepository())->getRankingByExam($exam->id, 10, 1);

        return inertia('Admin/Exam/ExamGroup/Show', [
            'exam' => $this->examGroupRepository->find($id),
            'rankingExams' => $rankingExams,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$this->examGroupRepository->find($id)) return abort('404', 'uppss....');

        $examGroup = ExamGroup::with(['subCategories' => function ($query) {
            $query->select('sub_categories.id', 'sub_categories.name');
        }])->find($id);

        $subCategories = $examGroup->subCategories;

        return inertia('Admin/Exam/ExamGroup/Edit', [
            'examGroup' => $this->examGroupRepository->find($id),
            'categories' => (new CategoryRepository())->all(),
            'subCategories' => $subCategories,
            'memberCategories' => (new MemberCategoryRepository())->getAllActivated()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamGroupRequest $request, $id)
    {
        try {
            if(!$this->examGroupRepository->find($id)) return abort('404', 'uppss....');

            $this->examGroupRepository->update($request, $id);

            return redirect()->route('admin.exam-groups.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->examGroupRepository->delete($id);

            return redirect()->route('admin.exam-groups.index');

        } catch(\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());

            return redirect()->back()->withInput($request->all());
        }
    }

    public function examGroupStudent($id)
    {
        $examGroupUsers = ExamGroupUser::where('exam_group_id', $id)->with(['user.student', 'user.student.province', 'user.student.city'])->orderBy('grade', 'DESC')->paginate(10);

        return inertia('Admin/Exam/ExamGroup/Student', [
            'examGroupUsers' => $examGroupUsers,
            'exam_group_id' => $id,
        ]);
    }

    public function examGroupExportPdf($id)
    {
        $examGroup = ExamGroup::with([
            'grade',
            'lessonCategory',
            'category',
            'examGroupUser' => function ($query) {
                $query->where('is_finished', 1)
                    ->with([
                        'user',
                    ])
                    ->orderBy('grade', 'desc');
            },
        ])->find($id);

        $pdf = Pdf::loadView('report.pdf.exam_group_all', [
            'examGroup' => $examGroup,
            'setting' => Setting::first() ?? [],
        ]);

        $filename = str_replace("", "_", 'Rekapitulasi Nilai '.$examGroup->title.'.pdf');
        return $pdf->stream($filename);
    }

    public function examGroupExportExcel($id)
    {
        return Excel::download(new ExamGroupExport($id), 'exam_group_report.xlsx');
    }

    public function examGroupStudentGrade($examGroupId, $examGroupUserId)
    {
        $examGroupUser = ExamGroupUser::find($examGroupUserId);

        $historyUpdate = ExamGroupUser::with([
            'examGroup.grade' => function ($query) use ($examGroupUser){
                $query->where('user_id', $examGroupUser->user_id)->where('is_finished', 1);
            }
        ])
        ->find($examGroupUserId);

        foreach($historyUpdate->examGroup->grade as $grade) {
            if($grade->grade_calculate == 0) {
                (new CalculateGradeService())->calculateGradeCategory($grade->id);
            }
        }

        $history = ExamGroupUser::with([
            'examGroup.lessonCategory',
            'examGroup.category',
            'examGroup.grade' => function ($query) use ($examGroupUser){
                $query->orderBy('created_at', 'ASC');
                $query->where('user_id', $examGroupUser->user_id)
                        ->with([
                        'lesson',
                        'exam.questionTitle',
                    ]);
            },
        ])
        ->find($examGroupUserId);

        return inertia('Admin/Exam/ExamGroup/HistoryDetail', [
            'history' => $history,
        ]);
    }

    public function regenerateScore($examGroupId, $examGroupUserId)
    {
        try {
            $examGroupUser = ExamGroupUser::find($examGroupUserId);

            $historyUpdate = ExamGroupUser::with([
                'examGroup.grade' => function ($query) use ($examGroupUser){
                    $query->where('user_id', $examGroupUser->user_id)->where('is_finished', 1);
                }
            ])
            ->find($examGroupUserId);

            foreach($historyUpdate->examGroup->grade as $grade) {
                (new CalculateGradeService())->calculateGradeCategory($grade->id);
            }

            session()->flash('success', 'Hitung Ulang Nilai Berhasil.');
            return redirect()->back();

        } catch (\Exception $e) {
            session()->flash('failed', $e->getMessage() . ' in file :'.$e->getFile() .' line: '. $e->getLine());
            return redirect()->back();
        }

    }

    public function examGroupStudentExportPdf($examGroupId, $examGroupUserId)
    {
        $examGroupUser = ExamGroupUser::find($examGroupUserId);

        $history = ExamGroupUser::with([
            'examGroup.lessonCategory',
            'examGroup.category',
            'examGroup.grade' => function ($query) use($examGroupUser) {
                $query->orderBy('created_at', 'ASC');
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

    public function examGroupUserDestroy($id)
    {
        $examGroupUser = ExamGroupUser::find($id);
        Grade::where(['exam_group_id' => $examGroupUser->exam_group_id, 'user_id' => $examGroupUser->user_id])->delete();
        ExamGroupUser::find($id)->delete();

        return redirect()->back();
    }

    public function regenerateBlockToken($id)
    {
        try {
            $this->examGroupRepository->regenerateToken($id);

            return redirect()->back();

        } catch (\Throwable $th) {
            return $th;
        }
    }
    
}
