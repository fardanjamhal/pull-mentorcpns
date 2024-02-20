<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class LessonCategory extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'description',
        'thumbnail'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function lesson()
    {
        return $this->hasMany(\App\Models\Lesson\Lesson::class);
    }
}
