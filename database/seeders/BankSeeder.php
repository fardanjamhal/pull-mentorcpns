<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::insert([
            [
                "id" => "80f683ec-e0df-4752-8b00-142eb8b7b052",
                "created_at" => "2022-09-19 18:17:52",
                "updated_at" => "2022-10-16 21:59:56",
                "deleted_at" => null,
                "bank_name" => "Bank Mandiri",
                "rekening_number" => "1300021581072",
                "rekening_name" => "Della Fadila Rahmawati",
                "image" => "2210171156_mandiri.png",
            ],
            [
                "id" => "e62da6ed-1e18-46d5-ae71-1ece93dc68c1",
                "created_at" => "2022-09-19 18:18:31",
                "updated_at" => "2022-11-04 02:35:25",
                "deleted_at" => null,
                "bank_name" => "Bank Syariah Indonesia",
                "rekening_number" => "7164565771",
                "rekening_name" => "Rifki Adha Darmawan",
                "image" => "2211040921_Bank_Syariah_Indonesia.svg.png",
            ]
        ]);
    }
}
