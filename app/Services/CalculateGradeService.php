<?php

namespace App\Services;

use App\Models\Exam\Grade;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamGroup;
use App\Models\Exam\ExamGroupUser;
use App\Models\Lesson\ValueCategory;
use App\Models\Lesson\DetailValueCategory;
use Ramsey\Uuid\Uuid as Generator;
use Carbon\Carbon;

class CalculateGradeService 
{
    function calculateGradeCategory($id) 
    {
        $grade = Grade::find($id);
        $exam = Exam::find($grade->exam_id);
        $gradeAnswers = is_string($grade->answers) ? unserialize($grade->answers) : $grade->answers;

        $totalCorrect = array_filter($gradeAnswers, function ($var) {
            return ($var['is_correct'] === "Y" && $var['answer'] !== 0);
        });

        $totalAnswer = array_filter($gradeAnswers, function ($var) {
            return ($var['answer'] != 0);
        });

        $totalWrong = array_filter($gradeAnswers, function ($var) {
            return ($var['is_correct'] === "N");
        });

        $totalQuestionGrade = count($gradeAnswers);
        $count_correct_answer = count($totalCorrect);

        $grade_exam = 0;

        if ($exam->questionTitle->assessment_type == 3) {
            $grade_exam = array_reduce($totalCorrect, function ($carry, $correct) {
                return $carry + $correct['correct_point'];
            }, 0);
        } elseif ($exam->questionTitle->assessment_type == 4) {
            $grade_exam = array_reduce($totalAnswer, function ($carry, $correct) {
                return $carry + $correct['point_' . $correct['answer']];
            }, 0);
        } else {
            $grade_exam = round($count_correct_answer / $totalQuestionGrade * 100, 2);
        }

        $valueCategories = ValueCategory::where('lesson_id', $exam->lesson_id)->get();

        $resultGradeDetails = [];

        if ($exam->questionTitle->add_value_category == 1 && ($exam->questionTitle->assessment_type == 1 || $exam->questionTitle->assessment_type == 2)) {
            $grades = [];

            foreach ($valueCategories as $index => $valueCategory) {
                if ($exam->questionTitle->assessment_type == 1) {
                    $totalCorrect = array_filter($gradeAnswers, function ($var) use ($valueCategory) {
                        return ($var['value_category_id'] == $valueCategory->id && $var['is_correct'] == "Y");
                    });

                    $totalWrong = array_filter($gradeAnswers, function ($var) use ($valueCategory) {
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

                if ($valueCategory->assessment_type == 1) {
                    $grades[$index]['grade'] = round(($totalCorrectFinal == 0 ? 0 : ($totalCorrectFinal / $totalQuestion)) * 100);
                }

                if ($valueCategory->assessment_type == 2) {
                    $grades[$index]['grade'] = $totalCorrectFinal;
                }

                if ($valueCategory->assessment_type == 3) {
                    $selisihGradien = abs($this->slope($grade->total_correct_per_section, $exam->questionTitle->total_section - 1));
                    $grades[$index]['grade'] =round( (100 - $selisihGradien * 50) < 0 ? 0 : 100 - $selisihGradien * 50);
                }

                if ($valueCategory->assessment_type == 4) {
                    $grades[$index]['grade'] = ($totalCorrectFinal == 0 ? 0 : round(($totalCorrectFinal / count($totalAnswer))) * 100);
                }
            }

            $valueCategoryIds = array_unique(array_column($grades, 'value_category_id'));

            $detailValueCategories = DetailValueCategory::whereIn('value_category_id', $valueCategoryIds)
                ->orderBy('value_category_id')
                ->orderBy('final_grade')
                ->get();

            foreach ($grades as $gradeData) {
                $finalGrade = null;
                $finalCategoryGrade = null;

                foreach ($detailValueCategories as $detailValueCategory) {
                    if ($detailValueCategory->value_category_id == $gradeData['value_category_id'] &&
                        $gradeData['grade'] >= $detailValueCategory->min_grade &&
                        $gradeData['grade'] <= $detailValueCategory->max_grade) {
                        $finalGrade = $detailValueCategory->final_grade;
                        $finalCategoryGrade = $detailValueCategory->category_grade;
                        break;
                    }
                }

                $resultGradeDetails[] = [
                    'id' => Generator::uuid4()->toString(),
                    'grade_category_name' => $gradeData['value_category_name'],
                    'total_correct' => $gradeData['total_correct'],
                    'total_wrong' => $gradeData['total_wrong'],
                    'grade_category' => $finalCategoryGrade,
                    'grade' => $finalGrade,
                ];
            }
        }

        $examGroup = ExamGroup::with([
            'grade' => function ($query) use ($grade) {
                $query->where('user_id', $grade->user_id);
            }
        ])
        ->with(['exam', 'exam.questionTitle'])
        ->withCount('exam')
        ->withCount('grade')
        ->find($exam->exam_group_id);

        $updates = [
            'end_time' => Carbon::now(),
            'total_correct' => $count_correct_answer,
            'grade' => $grade_exam,
            'is_finished' => 1,
            'grade_calculate' => 1,
            'grade_details' => $resultGradeDetails
        ];

        if($exam->exam_group_id && $examGroup->assessment_type == 2) {
            $updates['percentage_grade'] = $exam->percentage_grade ?? 0;
            $updates['final_grade'] = $grade_exam * ($updates['percentage_grade'] / 100);
        } else {
            $updates['final_grade'] = $grade_exam;
        }

        $grade->update($updates);


        if ($exam->exam_group_id) {
        $gradeCount = Grade::where(['exam_group_id' => $examGroup->id, 'user_id' => $grade->user_id])->count();
            if($gradeCount == $examGroup->exam_count) {
                $gradeExamGroup = 0;
                
                if ($examGroup->assessment_type == 1 || $examGroup->assessment_type == 2) {
                    $gradeExamGroup = Grade::where([
                        'exam_group_id' => $examGroup->id, 
                        'user_id' => $grade->user_id]
                        )->sum('final_grade');
                }
            
                if ($examGroup->assessment_type == 3) {
                    $gradeExamGroup = Grade::where([
                        'exam_group_id' => $examGroup->id, 
                        'user_id' => $grade->user_id
                        ])->avg('final_grade');
                }
            
                if ($examGroup->assessment_type == 4) {
                    $gradeCategories = Grade::where(['exam_group_id' => $examGroup->id, 'user_id' => $grade->user_id])->get();

                    foreach ($gradeCategories as $gradeCategory) {
                        if($gradeCategory->grade_details) {
                            foreach ($gradeCategory->grade_details as $grade_detail) {
                                $gradeExamGroup += $grade_detail['grade'];
                            }
                        }
                    }
                }

                if ($gradeExamGroup >= $examGroup->minimal_grade) {
                    $finalGradeExamGroup = $examGroup->biggest_value_limit ? 
                        ($gradeExamGroup >= $examGroup->biggest_value_limit ? $examGroup->biggest_value_limit : $gradeExamGroup) : 
                        $gradeExamGroup;
                } else if ($gradeExamGroup <= $examGroup->minimal_grade) {
                    $finalGradeExamGroup = $examGroup->smallest_value_limit ? 
                        ($gradeExamGroup <= $examGroup->smallest_value_limit ? $examGroup->smallest_value_limit : $gradeExamGroup) : 
                        $gradeExamGroup;
                } else {
                    $finalGradeExamGroup = $gradeExamGroup;
                }
                
                $examGroup = $examGroup;
                
                $reason = null;
                if ($examGroup->minimal_grade_type != 0) {
                    if ($examGroup->minimal_grade_type == 1) {
                        $reason = $gradeCount == $this->totalAbovePassingGrade($examGroup) ? 
                            $examGroup->description_grade_more_than_minimal : 
                            $examGroup->description_grade_less_than_minimal;
                    }
                
                    if ($examGroup->minimal_grade_type == 2) {
                        $reason = $finalGradeExamGroup >= $examGroup->minimal_grade ? 
                            $examGroup->description_grade_more_than_minimal : 
                            $examGroup->description_grade_less_than_minimal;
                    }
                } else {
                    $reason = null;
                }
                
                ExamGroupUser::where([
                    'exam_group_id' => $examGroup->id,
                    'user_id' => $grade->user_id,
                ])->update([
                    'grade' => $finalGradeExamGroup,
                    'is_finished' => 1,
                    'description' => $reason
                ]);
            }
        }

        return $grade;
    }

    function totalAbovePassingGrade($gradesArray) 
    {
        $total = 0;
        if($gradesArray->grade) {
            foreach($gradesArray->grade as $grade) {
                $passingGrade = isset($grade->exam->questionTitle->passing_grade) ? floatval($grade->exam->questionTitle->passing_grade) : 0;
                if (!is_nan($passingGrade) && $grade->grade >= $passingGrade) {
                    $total += 1;
                }
            } 
        }

        return $total;
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
}