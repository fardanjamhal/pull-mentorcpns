<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;
use App\Models\Setting;

class Announcement extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $dates = ['created_at'];

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getDescriptionAttribute($value)
    {
        // Mendapatkan pengaturan pertama dari database
        $setting = Setting::first();

        // Mengganti pola "../" dari nilai atribut menggunakan ekspresi reguler
        $value = preg_replace('/\.\.\/+/', '', $value);

        // Ganti path gambar jika ditemukan /storage/upload_files/questions
        $value = str_replace(
            "storage/upload_files/questions",
            $setting->app_url . "/storage/upload_files/questions",
            $value
        );

        return $value;
    }
}
