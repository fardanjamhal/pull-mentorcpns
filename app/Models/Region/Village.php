<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'district_id',
        'name',
    ];

    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
