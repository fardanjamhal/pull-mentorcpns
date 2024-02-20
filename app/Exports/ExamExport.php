<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Exam\ExamGroup;
use App\Repositories\Exam\ExamRepository;
use App\Repositories\Exam\GradeRepository;

class ExamExport implements FromView
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        $rankingExams = (new GradeRepository())->getGradeByExam($this->id, 1);
        $exam = (new ExamRepository())->find($this->id);

        return view('report.excel.exam', [
            'exam' => $exam,
            'rankingExams' => $rankingExams,
        ]);
    }
}

