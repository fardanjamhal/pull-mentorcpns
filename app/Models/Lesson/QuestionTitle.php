<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class QuestionTitle extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'lesson_category_id',
        'lesson_id',
        'name',
        'total_choices',
        'total_section',
        'add_value_category',
        'assessment_type',
        'passing_grade',
        'created_at',
        'updated_at',
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

    public function question()
    {
        return $this->hasMany(\App\Models\Lesson\Question::class);
    }

    public function exam()
    {
        return $this->hasMany(\App\Models\Exam\Exam::class);
    }
}
