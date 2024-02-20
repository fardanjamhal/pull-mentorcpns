<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $dates = ['created_at'];
    
    protected $casts = [
        'member_categories' => 'json',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'lesson_category_id',
        'exam_group_id',
        'exam_id',
        'code',
        'description',
        'payment_method',
        'total_payment',
        'transaction_status',
        'snap_token',
        'active_period',
        'period_type',
        'expired_date',
        'payment_file',
        'member_categories',
    ];

    public static function generateCode()
    {
        $code = 'INV';
        $result = $code.Carbon::now()->format('Ymdhis');

        return $result;
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\MasterData\Category::class);
    }

    public function lessonCategory()
    {
        return $this->belongsTo(\App\Models\Lesson\LessonCategory::class);
    }

    public function examGroup()
    {
        return $this->belongsTo(\App\Models\Exam\ExamGroup::class);
    }

    public function exam()
    {
        return $this->belongsTo(\App\Models\Exam\Exam::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return dateFormat($value, 'd-m-Y');
    }

    public function paymentConfirmation()
    {
        return $this->hasOne(\App\Models\Transaction\PaymentConfirmation::class);
    }
}
