<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Lesson extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'id',
        'lesson_category_id',
        'name',
        'thumbnail'
    ];

    public function lessonCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\LessonCategory::class);
    }
}
