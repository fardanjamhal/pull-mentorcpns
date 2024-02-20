<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMemberCategory extends Model
{
    use HasFactory;

    protected $casts = [
        'member_categories' => 'json',
    ];

    protected $fillable = [
        'transaction_id',
        'user_id',
        'category_id',
        'description',
        'member_categories',
        'expired_date',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }
}
