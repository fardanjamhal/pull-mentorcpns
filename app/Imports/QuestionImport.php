<?php

namespace App\Imports;

use App\Models\Lesson\Question;
use App\Models\Lesson\ValueCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use App\Models\Exam\ExamGroup;

class QuestionImport implements ToModel, WithHeadingRow
{
    protected $questionTitle;

    protected $index = 1;

    public function __construct($questionTitle)
    {
        $this->questionTitle = $questionTitle;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $importdata = [
            'question_title_id' => $this->questionTitle->id,
            'question' => ltrim($row['soal']),
            'created_at' => Carbon::now()->subDays(1)->addMinutes($this->index),
            'updated_at' => Carbon::now()->subDays(1)->addMinutes($this->index),
        ];

        if ($this->questionTitle->assessment_type == 1) {
            $importdata['value_category_id'] = $this->valueCategory(ltrim($row['kategori_penilaian']));
        }

        for ($i = 0; $i < $this->questionTitle->total_choices; $i++) {
            $importdata['option_' . ($i + 1)] = ltrim($row['pilihan_' . strtolower(chr(65 + $i))]);
        }

        if ($this->questionTitle->assessment_type != 4) {
            $importdata['answer'] = $this->convertAnswerToNumber(ltrim($row['jawaban']));
        }

        if ($this->questionTitle->assessment_type == 4) {
            for ($i = 0; $i < $this->questionTitle->total_choices; $i++) {
                $importdata['point_' . ($i + 1)] = ltrim($row['bobot_jawaban_' . strtolower(chr(65 + $i))]);
            }
        }

        if ($this->questionTitle->assessment_type == 3) {
            $importdata['correct_point'] = ltrim($row['poin_jawaban_benar']);
        }

        $this->index++;

        
        foreach($this->questionTitle->exam as $exam) {
            if(!empty($exam->exam_group_id)) {
                ExamGroup::find($exam->exam_group_id)->update(['updated_at' => Carbon::now()]);
            }
        }

        return new Question($importdata);
    }

    private function convertAnswerToNumber($answer)
    {
        $answer = strtoupper($answer);
        $letterToNumber = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5];
        
        return $letterToNumber[$answer] ?? 0;
    }

    private function valueCategory($value)
    {
        $valueCategory = ValueCategory::where(['lesson_id' => $this->questionTitle->lesson_id, 'name' => $value])->first();

        return $valueCategory ? $valueCategory->id : null;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
