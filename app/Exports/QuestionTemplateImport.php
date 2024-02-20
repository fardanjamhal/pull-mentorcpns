<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QuestionTemplateImport implements FromView
{
    protected $questionTitle;

    public function __construct($questionTitle)
    {
        $this->questionTitle = $questionTitle;
    }

    public function view(): View
    {
        return view('export.excel.question_import_format', [
            'questionTitle' => $this->questionTitle
        ]);
    }
}