<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction\PaymentMethod;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::insert([
            [
                'code' => 'account_balance',
                'description' => 'Saldo Akun',
                'is_active' => 1,
            ],
            [
                'code' => 'manual_transfer',
                'description' => 'Transfer Manual (Dibutuhkan Konfirmasi)',
                'is_active' => 1,
            ],
            [
                'code' => 'automatic_transfer_midtrans',
                'description' => 'Transfer Otomatis (Tanpa Konfirmasi)',
                'is_active' => 1,
            ],
            [
                'code' => 'automatic_transfer_xendit',
                'description' => 'Transfer Otomatis (Tanpa Konfirmasi)',
                'is_active' => 0,
            ],
        ]);
    }
}
