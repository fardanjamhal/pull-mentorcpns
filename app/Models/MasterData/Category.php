<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Category extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'thumbnail',
        'development_status',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function subCategory()
    {
        return $this->hasMany(\App\Models\MasterData\SubCategory::class);
    }

    public function exam()
    {
        return $this->hasMany(\App\Models\Exam\Exam::class);
    }

    public function examGroup()
    {
        return $this->hasMany(\App\Models\Exam\ExamGroup::class);
    }

    public function module()
    {
        return $this->hasMany(\App\Models\Material\Module::class);
    }

    public function videoModule()
    {
        return $this->hasMany(\App\Models\Material\VideoModule::class);
    }
}
