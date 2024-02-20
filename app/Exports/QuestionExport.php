<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Lesson\Question;

class QuestionExport implements FromView
{
    protected $questionTitle;

    public function __construct($questionTitle)
    {
        $this->questionTitle = $questionTitle;
    }

    public function view(): View
    {
        $questions = Question::where('question_title_id', $this->questionTitle->id)->orderBy('created_at', 'ASC')->get();
        
        return view('export.excel.question_export', [
            'questions' => $questions,
            'questionTitle' => $this->questionTitle
        ]);
    }
}