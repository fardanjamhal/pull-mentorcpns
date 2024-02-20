<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson\Lesson;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lesson::insert([
            [
                "id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "created_at" => "2022-09-16 12:18:30",
                "updated_at" => "2022-10-24 00:45:43",
                "deleted_at" => null,
                "lesson_category_id" => "95b24afd-d3fe-462d-afae-576e5ae91b6b",
                "name" => "Kepribadian",
                "thumbnail" => "2210240243_5 POLRI KEPRIBADIAN.jpg"
            ],
            [
                "id" => "26057c41-9113-46ed-af81-56716fc90937",
                "created_at" => "2022-09-16 12:18:37",
                "updated_at" => "2022-10-24 00:45:48",
                "deleted_at" => null,
                "lesson_category_id" => "95b24afd-d3fe-462d-afae-576e5ae91b6b",
                "name" => "Kecerdasan",
                "thumbnail" => "2210240248_6 POLRI KECERDASAN.jpg"
            ],
            [
                "id" => "a5f03254-7522-475f-a9be-ad618db28878",
                "created_at" => "2022-09-16 12:18:41",
                "updated_at" => "2022-10-24 00:45:54",
                "deleted_at" => null,
                "lesson_category_id" => "95b24afd-d3fe-462d-afae-576e5ae91b6b",
                "name" => "Kecermatan",
                "thumbnail" => "2210240254_7 POLRI KECERMATAN.jpg"
            ],
            [
                "id" => "8064c176-a1ea-4be9-988d-b3dd3cd3361a",
                "created_at" => "2022-09-16 12:20:21",
                "updated_at" => "2022-11-17 02:13:20",
                "deleted_at" => null,
                "lesson_category_id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "name" => "Bahasa Indonesia",
                "thumbnail" => "2211170920_polri_indonesia.jpg"
            ],
            [
                "id" => "2dd79341-f433-4072-a0b1-8619b3323e5a",
                "created_at" => "2022-09-16 12:20:22",
                "updated_at" => "2022-11-17 02:13:29",
                "deleted_at" => null,
                "lesson_category_id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "name" => "Bahasa Inggris",
                "thumbnail" => "2211170929_polri_inggris.jpg"
            ],
            [
                "id" => "dd7051bf-ff99-4eea-92a2-968f5b2c3a57",
                "created_at" => "2022-09-16 12:20:24",
                "updated_at" => "2022-11-17 02:13:39",
                "deleted_at" => null,
                "lesson_category_id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "name" => "Matematika",
                "thumbnail" => "2211170939_polri_matematika.jpg"
            ],
            [
                "id" => "b733447f-6928-42ea-b15a-c0808afc58bc",
                "created_at" => "2022-09-16 12:20:25",
                "updated_at" => "2022-11-17 02:13:50",
                "deleted_at" => null,
                "lesson_category_id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "name" => "Pengetahuan Umum",
                "thumbnail" => "2211170950_polri_pu.jpg"
            ],
            [
                "id" => "f88e9bba-2c84-478e-a1d9-4bfd2e06a2b2",
                "created_at" => "2022-09-16 12:20:27",
                "updated_at" => "2022-11-17 02:13:59",
                "deleted_at" => null,
                "lesson_category_id" => "309b2425-f865-4baa-93dd-bb6cd5ef9cbc",
                "name" => "Wawasan Kebangsaan",
                "thumbnail" => "2211170959_polri_wk.jpg"
            ],
            [
                "id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "created_at" => "2022-09-16 12:22:35",
                "updated_at" => "2022-10-24 00:48:52",
                "deleted_at" => null,
                "lesson_category_id" => "d03ea694-94f3-4808-aed3-b5be9f33c31c",
                "name" => "Kepribadian",
                "thumbnail" => "2210240252_5 TNI KEPRIBADIAN.jpg"
            ],
            [
                "id" => "96d4b3b4-f3e8-4dad-a541-e822e45b5fef",
                "created_at" => "2022-09-16 12:22:42",
                "updated_at" => "2022-10-24 00:48:56",
                "deleted_at" => null,
                "lesson_category_id" => "d03ea694-94f3-4808-aed3-b5be9f33c31c",
                "name" => "Kecerdasan",
                "thumbnail" => "2210240256_6 TNI KECERDASAN.jpg"
            ],
            [
                "id" => "2a258198-ebc8-430b-9b94-d926c615c2dd",
                "created_at" => "2022-09-16 12:22:47",
                "updated_at" => "2022-10-24 00:49:01",
                "deleted_at" => null,
                "lesson_category_id" => "d03ea694-94f3-4808-aed3-b5be9f33c31c",
                "name" => "Kecermatan",
                "thumbnail" => "2210240201_7 TNI KECERMATAN.jpg"
            ],
            [
                "id" => "a7d634a2-3955-4e83-b889-2f37a52a75a6",
                "created_at" => "2022-09-16 12:24:05",
                "updated_at" => "2022-10-24 00:47:57",
                "deleted_at" => null,
                "lesson_category_id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "name" => "Bahasa Indonesia",
                "thumbnail" => "2210240257_img_not_available.jpg"
            ],
            [
                "id" => "28e50ae1-ee56-495f-a1be-cb735a75ef85",
                "created_at" => "2022-09-16 12:24:06",
                "updated_at" => "2022-10-24 00:48:03",
                "deleted_at" => null,
                "lesson_category_id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "name" => "Bahasa Inggris",
                "thumbnail" => "2210240203_img_not_available.jpg"
            ],
            [
                "id" => "fe3e0925-f7f8-4cec-b67c-b2a28712f850",
                "created_at" => "2022-09-16 12:24:08",
                "updated_at" => "2022-10-24 00:48:09",
                "deleted_at" => null,
                "lesson_category_id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "name" => "Matematika",
                "thumbnail" => "2210240209_img_not_available.jpg"
            ],
            [
                "id" => "779ff446-64da-4c8a-ac68-1216ce41385d",
                "created_at" => "2022-09-16 12:24:09",
                "updated_at" => "2022-10-24 00:48:14",
                "deleted_at" => null,
                "lesson_category_id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "name" => "Pengetahuan Umum",
                "thumbnail" => "2210240214_img_not_available.jpg"
            ],
            [
                "id" => "db3cfb9c-93c9-4cf3-ae77-e4b6608b8cd1",
                "created_at" => "2022-09-16 12:24:11",
                "updated_at" => "2022-12-08 06:31:00",
                "deleted_at" => null,
                "lesson_category_id" => "9efc0903-53b4-44b2-94b6-24c2c00ede1c",
                "name" => "Wawasan Kebangsaan",
                "thumbnail" => "2212080100_img_not_available.jpg"
            ],
            [
                "id" => "a1f85313-956a-43ed-9f55-43a2a50f1c5a",
                "created_at" => "2022-09-16 12:24:21",
                "updated_at" => "2022-10-24 00:49:10",
                "deleted_at" => null,
                "lesson_category_id" => "be809627-2ab5-4537-9016-c3d39cff1aee",
                "name" => "Pash Hand",
                "thumbnail" => "2210240210_8 TNI PASHHAND.jpg"
            ],
            [
                "id" => "972e573d-c0d3-4973-a480-1a6f7aa71e6e",
                "created_at" => "2023-01-18 13:12:37",
                "updated_at" => "2023-01-18 13:12:37",
                "deleted_at" => null,
                "lesson_category_id" => "ebaba4ee-6736-459d-ba88-c6910a9fd08e",
                "name" => "Tes Intelegensi Umum",
                "thumbnail" => "2301180837_skd-image.jpg"
            ],
            [
                "id" => "291feb2a-7cba-4d9c-8cae-cd1608a8a8fd",
                "created_at" => "2023-01-18 13:17:51",
                "updated_at" => "2023-01-18 13:17:51",
                "deleted_at" => null,
                "lesson_category_id" => "ebaba4ee-6736-459d-ba88-c6910a9fd08e",
                "name" => "Tes Wawasan Kebangsaan",
                "thumbnail" => "2301180851_skd-image.jpg"
            ],
            [
                "id" => "dcd839a2-c0a1-412f-99c8-c0d646ecfb17",
                "created_at" => "2023-01-18 13:22:13",
                "updated_at" => "2023-01-18 13:22:13",
                "deleted_at" => null,
                "lesson_category_id" => "ebaba4ee-6736-459d-ba88-c6910a9fd08e",
                "name" => "Tes Karakteristik Pribadi",
                "thumbnail" => "2301180813_skd-image.jpg"
            ],
            [
                "id" => "df313e06-668b-4bb7-9ee2-7c6e541ea5fc",
                "created_at" => "2023-01-18 13:28:34",
                "updated_at" => "2023-01-18 13:28:34",
                "deleted_at" => null,
                "lesson_category_id" => "762d89b4-08b3-43fa-8861-49dae9c6178c",
                "name" => "Tes Intelegensi Umum",
                "thumbnail" => "2301180834_skd-image.jpg"
            ],
            [
                "id" => "03c209c8-26b1-4cf7-a8a1-44f3ef5cfec6",
                "created_at" => "2023-01-18 13:28:37",
                "updated_at" => "2023-01-18 13:28:37",
                "deleted_at" => null,
                "lesson_category_id" => "762d89b4-08b3-43fa-8861-49dae9c6178c",
                "name" => "Tes Wawasan Kebangsaan",
                "thumbnail" => "2301180837_skd-image.jpg"
            ],
            [
                "id" => "c2874b72-6ebf-4864-9c7e-49aad29a3c74",
                "created_at" => "2023-01-18 13:28:40",
                "updated_at" => "2023-01-18 13:28:40",
                "deleted_at" => null,
                "lesson_category_id" => "762d89b4-08b3-43fa-8861-49dae9c6178c",
                "name" => "Tes Karakteristik Pribadi",
                "thumbnail" => "2301180840_skd-image.jpg"
            ]
        ]);
    }
}
