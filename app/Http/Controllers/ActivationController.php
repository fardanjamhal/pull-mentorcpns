<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MasterData\Student;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Models\Setting;
use Carbon\Carbon;

class ActivationController extends Controller
{
    public function activation($userId)
    {
        $user = User::find($userId);
        if(!$user) {
            return redirect('login')->with('error', 'Akun tersebut tidak terdaftar dalam sistem.');
        }

        return inertia('Auth/Activation', [
            'user' => $user,
        ]);
    }

    public function actived($userId)
    {
        $user = User::find($userId);

        if(!$user) {
            return redirect('login')->with('error', 'Akun tersebut tidak terdaftar dalam sistem.');
        }

        if($user->is_active == 1) {
            return redirect('login')->with('success', 'Akun '.$user->email.' sudah aktif, silakan login.');
        }

        if($user->expiry_verification_date < Carbon::now()) {
            return redirect('login')->with('error', 'Link verifikasi sudah kedaluarsa, Silakan hubungi admin.');
        }
        
        $user->update(['is_active' => 1, 'expiry_verification_date' => Carbon::now()]);
        return redirect('login')->with('success', 'Akun dengan email '.$user->email.' telah diaktifkan, silakan login.');
    }

    public function forgotPassword()
    {
        return inertia('Auth/ForgotPassword');
    }

    public function storeForgotPassword(ForgotPasswordRequest $request)
    {
        $student = Student::where('phone_number', $request->phone_number)->first();   
        $setting = Setting::first();
        
        if($student) {
            $user = User::find($student->user_id);

            if($user->is_active == 0) {
                return redirect()->back()->with('error', 'Untuk melakukan reset password, akun anda harus aktif terlebih dahulu, silakan hubungi admin untuk mendapatkan link aktivasi.');
            }
            
            $namePassword = explode(" ", $student->user->name);
            $newPassword = strtolower($namePassword[0]).mt_rand(10000, 99999);

            $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari ".(strtoupper($setting->app_name ?? "isi data setting terlebih dahulu")).", berikut permintaan perubahan password untuk akun anda._\n\nNama: ".$user->name."\nEmail: ".$user->email."\nPassword Baru: ".$newPassword."\n\n*Mohon diperhatikan untuk penulisan email dan password baik itu huruf besar atau kecilnya, karena itu sangat berpengaruh untuk login, ingat dan simpan supaya tidak lupa.*\n\n_terimakasih_";
            sendWhatsappNotification($user->student->phone_number, $message);

            $user->update([
                'password' => bcrypt($newPassword)
            ]);
            
            return redirect()->route('login')->with('success', 'Kami telah mengirimkan perubahan password ke nomor Whatsapp <b>'.$request->phone_number.'</b> silakan untuk di cek, terimakasih');

        } else {
            return redirect()->back()->with('error', 'Nomor <b>'.$request->phone_number. '</b> tidak ditemukan, silakan klik link dibawah button kirim untuk menghubungi admin.');
        }
    }
}
