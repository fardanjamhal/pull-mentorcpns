<?php

namespace App\Models\Material;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Module extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'member_categories' => 'json',
    ];
    
    protected $fillable = [
        'id',
        'category_id',
        'title',
        'description',
        'link',
        'member_categories'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }
}
