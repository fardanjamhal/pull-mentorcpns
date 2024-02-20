<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class AccountBalance extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'code',
        'top_up_balance',
        'transaction_status',
    ];

    protected $dates = ['created_at'];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y H:i');
    }

    public static function generateCode()
    {
        $code = 'TPS';
        $sequence = 1;
        $format = formatCode($code, $sequence);
        $result = null;

        while (true) {
            $query = static::where('code', $format)->first();
            if (empty($query)) {
                $result = $format;
                break;
            }
            $format = formatCode($code, ++$sequence);
        }

        return $result;
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
