<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeGenerator extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gender',

        'twk_ke',
        'nilai_twk',

        'pu_ke',
        'nilai_pu',

        'mtk_ke',
        'nilai_mtk',

        'inggris_ke',
        'nilai_inggris',

        'nilai_akhir',
    ];
}
