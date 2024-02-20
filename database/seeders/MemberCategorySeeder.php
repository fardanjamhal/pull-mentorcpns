<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MemberCategory;
use Carbon\Carbon;

class MemberCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MemberCategory::insert([
            [
                'name' => 'Basic Member',
                'status' => 1,
                'created_at' => Carbon::now()->addMinutes(1),
                'updated_at' => Carbon::now()->addMinutes(1),
            ],
            [
                'name' => 'Standard Member',
                'status' => 1,
                'created_at' => Carbon::now()->addMinutes(2),
                'updated_at' => Carbon::now()->addMinutes(2),
            ],
            [
                'name' => 'Premium Member',
                'status' => 1,
                'created_at' => Carbon::now()->addMinutes(3),
                'updated_at' => Carbon::now()->addMinutes(3),
            ],
            [
                'name' => 'Platinum Member',
                'status' => 0,
                'created_at' => Carbon::now()->addMinutes(3),
                'updated_at' => Carbon::now()->addMinutes(3),
            ],
        ]);
    }
}
