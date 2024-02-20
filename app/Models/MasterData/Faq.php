<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class Faq extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $dates = ['created_at'];

    protected $fillable = [
        'id',
        'question',
        'answer',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getAnswerAttribute($value)
    {
        return str_replace("/storage/upload_files/questions","/storage/upload_files/questions", $value);
    }
}
