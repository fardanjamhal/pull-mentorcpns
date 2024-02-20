<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam\Answer;
use App\Models\Exam\Exam;
use App\Models\Lesson\{DetailValueCategory, ValueCategory};
use App\Models\Exam\GradeDetail;
use App\Models\Exam\Grade;
use App\Models\Exam\ExamGroupUser;
use App\Models\Exam\ExamGroup;
use DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid as Generator;
use Carbon\Carbon;
use App\Models\Lesson\Question;
use App\Models\Transaction\Transaction;
use Auth;
use App\Models\Transaction\Voucher;

class TestingController extends Controller
{
    public function checkConnection()
    {
        try {
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    function checkMemberCategories($data, $categories) {
        foreach ($data as $entry) {
            if (count(array_intersect($entry['member_categories'], $categories)) > 0) {
                return true;
            }
        }
        return false;
    }

    public function index()
    {
        $data = \App\Models\UserMemberCategory::all();

        return $this->checkMemberCategories($data, ["d Member", "test Member", "Hadian Member"]) == true ? 'ada' :'tidak ada';

        $grades = Grade::all();

        foreach($grades as $grade) {
            $answerData = [];
            foreach($grade->answers as $answer) {
                $answerData[] = [
                    'is_correct' => $answer['is_correct'],
                    'answer' => $answer['question_answer'],
                    'value_category_id' => $answer['value_category_id']
                ];
            }

            $grade->update(['answers' => $answerData]);
        }

        return "ada";

        
        
        $grade = DB::table('grades')
            ->join('exams', 'exams.id', '=', 'grades.exam_id')
            ->join('question_titles', 'question_titles.id', '=', 'exams.question_title_id')
            ->where('grades.id', 'c3a78f78-06e9-401c-9357-0dcad00972b9');
        
        $grade->update(['grades.answers' => []]);
        
        $updatedGrade = $grade->first();
        
        return $updatedGrade;
    
    }

    public function getOption($number)
    {
        switch ($number) {
            case 0:
                return 'A';
                break;
            case 1:
                return 'B';
                break;
            case 2:
                return 'C';
                break;
            case 3:
                return 'D';
                break;
            default:
                return 'E';
                break;
        }
    }

    public function jsonRelation()
    {
        // $grades[] = [
        //     'id' => 1,
        //     'description' => 'testing'
        // ];


        // return $grades;
        $exam = \App\Models\Exam\Exam::find('4752946b-2948-497c-92e5-1be24d533f7e');

        $grade = Grade::with(['gradeDetail'])->find('272a49f1-5327-4f69-bccc-5131bfb1912f');

        return $grade;

        // for($i = 0; $i < 500; $i++) {
        //     $grade->forceFill([
        //         'answers->'.$i.'->is_correct' => 'Y',
        //     ])->save();
        // }
        // return $grade;
        $gradeAnswers = $grade['answers'];

        $totalCorrectPerSection = [];
        for($i = 0; $i < $exam->questionTitle->total_section; $i++) {
            $totalCorrect = array_filter($gradeAnswers, function ($var) use($i) {
                return ($var['is_correct'] == "Y" && $var['section'] == $i);
            });

            $totalCorrectPerSection[] = count($totalCorrect);
        }

        $totalCorrect = array_filter($gradeAnswers, function ($var) {
            return ($var['is_correct'] == "Y");
        });

        $totalWrong = array_filter($gradeAnswers, function ($var) {
            return ($var['is_correct'] == "N");
        });

        $count_correct_answer = count($totalCorrect);
        $grade_exam = round($count_correct_answer / count($grade['answers']) * 100, 2);

        $grade->end_time = Carbon::now();
        $grade->total_correct = $count_correct_answer;
        $grade->grade = $grade_exam;
        $grade->is_finished = 1;
        $grade->update();

        $valueCategories = ValueCategory::where('lesson_id', $exam->lesson_id)->get();

        if($exam->questionTitle->add_value_category == 1) {

            $grades = [];

            foreach($valueCategories as $index => $valueCategory) {
                if($exam->questionTitle->assessment_type == 1) {
                    $totalCorrect = array_filter($gradeAnswers, function ($var) use($valueCategory) {
                        return ($var['value_category_id'] == $valueCategory->id && $var['is_correct'] == "Y");
                    });

                    $totalWrong = array_filter($gradeAnswers, function ($var) use($valueCategory) {
                        return ($var['value_category_id'] == $valueCategory->id && $var['is_correct'] == "N");
                    });
                }

                $totalCorrectFinal = count($totalCorrect);
                $totalWrongFinal = count($totalWrong);
                $totalQuestion = (int) $totalCorrectFinal + (int) $totalWrongFinal;

                $grades[] = [
                    'category_id' => $exam->category_id,
                    'lesson_category_id' => $exam->lesson_category_id,
                    'lesson_id' => $exam->lesson_id,
                    'exam_id' => $exam->id,
                    'total_correct' => $totalCorrectFinal,
                    'total_wrong' => $totalWrongFinal,
                    'value_category_id' => $valueCategory->id,
                    'value_category_name' => $valueCategory->name,
                    'value_category_assessment_type' => $valueCategory->assessment_type,
                ];

                if($valueCategory->assessment_type == 1) {
                    $grades[$index]['grade'] =($totalCorrectFinal / $totalQuestion) * 100;
                }

                if($valueCategory->assessment_type == 2) {
                    $grades[$index]['grade'] = $totalCorrectFinal;
                }

                if($valueCategory->assessment_type == 3) {
                    $selisihGradien = abs($this->slope($totalCorrectPerSection, $exam->questionTitle->total_section - 1));
                    $grades[$index]['grade'] = (100 - $selisihGradien * 50) < 0 ? 0 : 100 - $selisihGradien * 50;
                }
            }

            $result = [];

            foreach($grades as $gradeData) {
                $detailValueCategories = DetailValueCategory::where('value_category_id', $gradeData['value_category_id'])->get();
                $finalGrade = 0;
                $finalCategoryGrade = 'KS';
                foreach($detailValueCategories as $detailValueCategory) {
                    if($gradeData['grade'] >= $detailValueCategory->min_grade && $gradeData['grade'] <= $detailValueCategory->max_grade) {
                        $finalGrade = $detailValueCategory->final_grade;
                        $finalCategoryGrade = $detailValueCategory->category_grade;
                    }
                }

                $result[] = [
                    'id' => Generator::uuid4()->toString(),
                    'category_id' => $gradeData['category_id'],
                    'lesson_category_id' => $gradeData['lesson_category_id'],
                    'lesson_id' => $gradeData['lesson_id'],
                    'exam_id' => $gradeData['exam_id'],
                    'user_id' => auth()->user()->id,
                    'value_category_id' => $gradeData['value_category_id'],
                    'grade_id' => $grade->id,
                    'total_correct' => $gradeData['total_correct'],
                    'total_wrong' => $gradeData['total_wrong'],
                    'grade_category' => $finalCategoryGrade,
                    'grade' => $finalGrade,
                ];
            }

            GradeDetail::insert($result);
            return $result;
        }
    }

    public function localStorage()
    {
        $grade = Grade::first();

        return $grade;
        $questions = array_column($grade->answers, 'question_id');


        $data = [];
        foreach($questions as $question) {
            $data[] = Question::find($question);
        }

        return $data;
    }

    function slope($valuesIn, $period)
    {
        $valuesOut = array();

        $startIdx = 0;
        $endIdx = count($valuesIn) - 1;

        $sumX = $period * ( $period - 1 ) * 0.5;
        $sumXSqr = $period * ( $period - 1 ) * ( 2 * $period - 1 ) / 6;
        $divisor = $sumX * $sumX - $period * $sumXSqr;

        for ( $today = $startIdx, $outIdx = 0; $today <= $endIdx; $today++, $outIdx++ ) {
            $sumXY = 0;
            $sumY = 0;
            if ( $today >= $period - 1 ) {
            for( $aux = $period; $aux-- != 0;) {
                $sumY += $tempValue = $valuesIn[$today - $aux];
                $sumXY += (double)$aux * $tempValue;
            }

            $valuesOut[$outIdx] = ( $period * $sumXY - $sumX * $sumY) == 0 ? 0 : ( $period * $sumXY - $sumX * $sumY) / $divisor;
            }
        }

        return $valuesOut[$outIdx - 1];
    }

    public function onprogress()
    {
        return inertia('OnProgress/OnProgress');
    }

    public function testingWa()
    {
        $token = 'HoL+yqdpN9PPmIiog0P7';
        $curl = curl_init();

        $phoneNumber = '081223230946';
        $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari pelajarin.com, akun anda telah terdaftar di platform kami, berikut link verifikasi untuk aktivasi akun anda._\n\nNama: Dede Rusliandi\nEmail: dede.rusliandi1@gmail.com\n\nBerikut link verifikasi anda\nhttps://pelajarin.com/user/271373d8-0ed8-47a2-837a-e849b96ac0bd/activation \n\n*Jika link tidak bisa diklik, silakan copy dan paste dibrowser anda.*\n\n_terimakasih telah menjadi bagian dari kami, semoga pelajarin.com dapat membantu anda lolos terpilih. aamiin._";
        
        $data = [
            'target' => $phoneNumber,
            'message' => $message
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)),
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$token.''
        ),
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
