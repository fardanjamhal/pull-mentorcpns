<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Grade extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $casts = [
        'answers' => 'json',
        'total_correct_per_section' => 'array',
        'grade_details' => 'json',
        'end_time' => 'datetime:Y-m-d H:i:s',
        'start_time' => 'datetime:Y-m-d H:i:s',
    ];

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'lesson_category_id',
        'lesson_id',
        'exam_id',
        'exam_group_id',
        'user_id',
        'duration',
        'section',
        'total_section',
        'start_time',
        'end_time',
        'work_duration',
        'total_correct',
        'total_correct_per_section',
        'percentage_grade',
        'grade',
        'final_grade',
        'answers',
        'grade_details',
        'is_finished',
        'grade_calculate',
        'total_tolerance',
        'is_blocked'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function lessonCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\LessonCategory::class);
    }

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson\Lesson::class);
    }

    public function exam()
    {
        return $this->belongsTo(\App\Models\Exam\Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
