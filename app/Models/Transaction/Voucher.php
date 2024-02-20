<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Voucher extends Model
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
        'name',
        'active_period',
        'period_type',
        'price_before_discount',
        'price_after_discount',
        'description',
        'member_categories',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(\App\Models\MasterData\SubCategory::class, 'voucher_sub_category');
    }
}
