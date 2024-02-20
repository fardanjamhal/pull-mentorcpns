<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Exam\ExamGroup;

class ExamGroupExport implements FromView
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
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
        ])->find($this->id);

        return view('report.excel.exam_group', [
            'examGroup' => $examGroup
        ]);
    }
}