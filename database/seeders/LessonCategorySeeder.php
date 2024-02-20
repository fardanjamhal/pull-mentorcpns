<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson\LessonCategory;

class LessonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LessonCategory::insert([
            [
                "id" => "95b24afd-d3fe-462d-afae-576e5ae91b6b",
                "created_at" => "2022-09-16 12:05:52",
                "updated_at" => "2022-10-24 00:42:25",
                "deleted_at" => null,
                "category_id" => "f968e7a3-74ed-4090-b9bc-99e7c36f2a69",
                "name" => "Tes Psikologi",
                "thumbnail" => "2210240225_2 POLRI PSIKOLOGI.jpg",
                "description" => "Berisi berbagai jenis try out mulai dari tes kecerdasan, kecermatan dan kepribadian"
            ],
            [
                "id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "created_at" => "2022-09-16 12:05:53",
                "updated_at" => "2022-10-24 00:42:29",
                "deleted_at" => null,
                "category_id" => "f968e7a3-74ed-4090-b9bc-99e7c36f2a69",
                "name" => "Tes Akademik",
                "thumbnail" => "2210240229_3 POLRI AKADEMIK.jpg",
                "description" => "Berisi berbagai jenis try out semua mapel tes akademik persiapan seleksi anggota POLRI"
            ],
            [
                "id" => "d03ea694-94f3-4808-aed3-b5be9f33c31c",
                "created_at" => "2022-09-16 12:07:18",
                "updated_at" => "2022-10-24 00:42:57",
                "deleted_at" => null,
                "category_id" => "ab1e771a-0037-40a4-be89-527224a6d4cc",
                "name" => "Tes Psikologi",
                "thumbnail" => "2210240257_2 TNI PSIKOLOGI.jpg",
                "description" => "Berisi berbagai jenis try out mulai dari tes kecerdasan, kecermatan dan kepribadian"
            ],
            [
                "id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "created_at" => "2022-09-16 12:07:19",
                "updated_at" => "2022-10-24 00:43:02",
                "deleted_at" => null,
                "category_id" => "ab1e771a-0037-40a4-be89-527224a6d4cc",
                "name" => "Tes Akademik",
                "thumbnail" => "2210240202_3 TNI AKADEMIK.jpg",
                "description" => "Berisi berbagai jenis try out semua mapel tes akademik persiapan seleksi anggota POLRI"
            ],
            [
                "id" => "be809627-2ab5-4537-9016-c3d39cff1aee",
                "created_at" => "2022-09-16 12:07:21",
                "updated_at" => "2022-10-24 00:43:08",
                "deleted_at" => null,
                "category_id" => "ab1e771a-0037-40a4-be89-527224a6d4cc",
                "name" => "Tes Lainnya",
                "thumbnail" => "2210240208_4 TNI LAINYA.jpg",
                "description" => "Berisi paket tryout tes lainnya"
            ],
            [
                "id" => "ebaba4ee-6736-459d-ba88-c6910a9fd08e",
                "created_at" => "2022-09-16 12:13:19",
                "updated_at" => "2023-01-20 01:06:06",
                "deleted_at" => null,
                "category_id" => "1350c742-67be-4841-9cf7-a92a9ce6278a",
                "name" => "Tes SKD Kedinasan",
                "thumbnail" => "2210240232_2 KEDINASAN SKD.jpg",
                "description" => "BerisI paket try out Tes Wawasan Kebangsaan, Tes Intelegensi Umum, dan Tes Karakteristik Pribadi"
            ],
            [
                "id" => "7748616f-372e-44c5-8689-7725f80a0b63",
                "created_at" => "2022-09-16 12:13:20",
                "updated_at" => "2023-01-20 01:06:17",
                "deleted_at" => null,
                "category_id" => "1350c742-67be-4841-9cf7-a92a9ce6278a",
                "name" => "Tes SKB Kedinasan",
                "thumbnail" => "2210240236_3 KEDINASAN SKB.jpg",
                "description" => "Berisi paket try out Tes Seleksi Kemampuan Bidang yang diujikan pada beberapa sekolah kedinasan"
            ],
            [
                "id" => "d6072975-3337-4f31-a90c-cbb4c36a8ec1",
                "created_at" => "2022-09-16 12:13:22",
                "updated_at" => "2022-10-24 00:43:40",
                "deleted_at" => null,
                "category_id" => "1350c742-67be-4841-9cf7-a92a9ce6278a",
                "name" => "Tes Lainnya",
                "thumbnail" => "2210240240_4 KEDINASAN LAINNYA.jpg",
                "description" => "Berisi paket try out lainnya seperti tes Psikologi, Kesehatan Jiwa, dan lain - lain"
            ],
            [
                "id" => "762d89b4-08b3-43fa-8861-49dae9c6178c",
                "created_at" => "2022-09-16 12:14:55",
                "updated_at" => "2023-01-20 01:06:35",
                "deleted_at" => null,
                "category_id" => "0f4348b6-10ed-4d98-ac73-bc9970dc8b73",
                "name" => "Tes SKD CPNS",
                "thumbnail" => "2210240257_2 CPNS SKD.jpg",
                "description" => "BerisI paket try out Tes Wawasan Kebangsaan, Tes Intelegensi Umum, dan Tes Karakteristik Pribadi"
            ],
            [
                "id" => "37ba260d-d743-4dd8-a086-988d1f7bb143",
                "created_at" => "2022-09-16 12:14:57",
                "updated_at" => "2023-01-24 03:35:09",
                "deleted_at" => null,
                "category_id" => "0f4348b6-10ed-4d98-ac73-bc9970dc8b73",
                "name" => "Tes SKB CPNS",
                "thumbnail" => "2210240201_3 CPNS SKB.jpg",
                "description" => "Berisi paket try out Tes Seleksi Kemampuan Bidang yang diujikan pada beberapa sekolah kedinasan"
            ],
            [
                "id" => "7e542b29-403b-4e45-a14f-855122cdd722",
                "created_at" => "2022-09-16 12:14:58",
                "updated_at" => "2022-10-24 00:44:05",
                "deleted_at" => null,
                "category_id" => "0f4348b6-10ed-4d98-ac73-bc9970dc8b73",
                "name" => "Tes Lainnya",
                "thumbnail" => "2210240205_4 CPNS LAINNYA.jpg",
                "description" => "Berisi paket try out lainnya seperti tes Psikologi, Kesehatan Jiwa, dan lain - lain"
            ]
        ]);
    }
}
