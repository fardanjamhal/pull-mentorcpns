<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'province_id',
        'name',
    ];

    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
