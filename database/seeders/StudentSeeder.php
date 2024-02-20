<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterData\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::insert([
            [
                "id" => "63e4a458-c1d0-491c-b04a-b9f5e919d80d",
                "created_at" => null,
                "updated_at" => null,
                "user_id" => "62bcbaec-82a9-44f5-985b-e5abcc83ccca",
                "province_id" => 32,
                "city_id" => 3204,
                "district_id" => 320408,
                "village_id" => 26860,
                "address" => "Cigebar RT02/RW 02 No. 4",
                "phone_number" => "081223230946",
                "gender" => "M",
                "is_member" => 0,
            ],
        ]);
    }
}
