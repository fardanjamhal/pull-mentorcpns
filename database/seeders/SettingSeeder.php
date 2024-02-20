<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'app_name' => 'Pelajarin',
            'whatsapp_number' => '6281212126043',
            'email' => 'finance@pelajarin.com',
            'address' => 'Jl Cigebar No 4 RT02/RW02 Desa Bojongsari Kec. Bojongsoang, Kab Bandung',
            'logo' => 'pelajarin.png',
            'add_activation_user' => 1,
            'login_type' => 1,
        ]);
    }
}
