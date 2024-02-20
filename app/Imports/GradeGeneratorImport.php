<?php

namespace App\Imports;

use App\Models\GradeGenerator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use App\Models\Exam\ExamGroup;

class GradeGeneratorImport implements ToModel, WithHeadingRow
{
    protected $index = 1;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $importdata = [
            'nama' => $row['nama'],
            'gender' => $row['gender'] == "L" ? 1 : 0,

            'twk_ke' => $row['twk_to_ke'],
            'nilai_twk' => str_replace(",", ".",$row['wawasan_kebangsaan']),

            'pu_ke' => $row['pu_to_ke'],
            'nilai_pu' => str_replace(",", ".",$row['pengetahuan_umum']),

            'mtk_ke' => $row['mtk_to_ke'],
            'nilai_mtk' => str_replace(",", ".",$row['matematika']),

            'inggris_ke' => $row['en_to_ke'],
            'nilai_inggris' => str_replace(",", ".",$row['bahasa_inggris']),

            'nilai_akhir' => str_replace(",", ".",$row['nilai_akhir']),
        ];

        return new GradeGenerator($importdata);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
