<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                "id" => "20b2a4122c614bb68e41b1a6f3f37780",
                "name" => "Admin Pelajarin",
                "email" => "administrator@pelajarin.com",
                "email_verified_at" => null,
                "password" => bcrypt('12345678'),
                "level" => 1,
                "is_active" => 1,
                "created_at" => "2022-10-02 00:58:31",
                "updated_at" => "2022-10-02 00:58:31"
            ],
        ]);
    }
}
