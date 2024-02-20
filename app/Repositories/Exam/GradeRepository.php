<?php

namespace App\Repositories\Exam;

use App\Models\Exam\Grade;
use App\Repositories\Contracts\Exam\GradeInterface;
use App\Repositories\BaseRepository;

class GradeRepository extends BaseRepository implements GradeInterface
{
    /**
     * @var
     */
    protected $model;

    public function __construct()
    {
        $this->model = new Grade;
    }

    public function getAllByUserPaginatedWithParams($params, $limit = 10)
    {
        $exams = $this->model;
        $exams = $exams->where(['is_finished' => 1, 'user_id' => auth()->user()->id])->whereNull('exam_group_id')->with(['category', 'lessonCategory', 'lesson', 'exam'])->orderBy('created_at', 'DESC')->paginate($limit);
        return $exams;
    }

    public function find($id)
    {
        return $this->model->with(['category', 'lessonCategory', 'lesson', 'exam', 'exam.questionTitle.question', 'exam.questionTitle'])->find($id);
    }

    public function getRankingByExam($examId, $limit = 10, $isFinished = null)
    {

        $rankings = $this->model->query();

        if($isFinished) {
            $rankings->where('is_finished', $isFinished);
        }

        $rankings = $rankings->where('exam_id', $examId)->with(['user.student', 'user.student.province', 'user.student.city'])->orderBy('grade', 'DESC')->paginate($limit);
        
        return $rankings;
    }

    public function getGradeByExam($examId, $isFinished = null)
    {
        $rankings = $this->model->query();

        if($isFinished) {
            $rankings->where('is_finished', $isFinished);
        }

        $rankings = $rankings->where('exam_id', $examId)->with(['user.student', 'user.student.province', 'user.student.city'])->orderBy('grade', 'DESC')->get();
        
        return $rankings;
    }
}
