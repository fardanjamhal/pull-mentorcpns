<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $casts = [
        'payment_methods' => 'array',
    ];

    protected $fillable = [
        'id',
        'app_name',
        'app_url',
        'whatsapp_number',
        'whatsapp_token',
        'address',
        'logo',
        'signed_name',
        'signed_image',
        'add_activation_user',
        'purchase_type',
        'payment_methods',
        'login_type', // 1 email, 2 username, 3 email / username
        'theme',
        'add_data_detail_for_registration',
    ];
}
