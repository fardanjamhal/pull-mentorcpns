<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class DetailValueCategory extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'value_category_id',
        'min_grade',
        'max_grade',
        'category_grade',
        'final_grade',
    ];

    public function valueCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\ValueCategory::class);
    }
}
