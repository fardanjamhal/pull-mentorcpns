<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fillable = [
        'code',
        'description',
        'is_active'
    ];
}
