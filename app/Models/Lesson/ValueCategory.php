<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class ValueCategory extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lesson_id',
        'name',
        'assessment_type',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson\Lesson::class);
    }
}
