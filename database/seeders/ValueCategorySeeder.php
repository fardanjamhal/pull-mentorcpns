<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson\ValueCategory;

class ValueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ValueCategory::insert([
            [
                "id" => "b17b0fd0-5381-43e1-b1a6-2528460538eb",
                "created_at" => "2022-09-17 23:29:23",
                "updated_at" => "2022-09-17 23:29:23",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Stabilitas Emosi",
                "assessment_type" => 1
            ],
            [
                "id" => "399e843f-61cd-499d-bcba-e5d3575c5d5e",
                "created_at" => "2022-09-17 23:29:25",
                "updated_at" => "2022-09-17 23:29:25",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Pro Sosial",
                "assessment_type" => 1
            ],
            [
                "id" => "8dffa187-47e8-4936-a2a0-531944b3b797",
                "created_at" => "2022-09-17 23:29:27",
                "updated_at" => "2022-09-17 23:29:27",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Kepercayaan Diri",
                "assessment_type" => 1
            ],
            [
                "id" => "c7b89779-c163-4bee-9033-16562107edb8",
                "created_at" => "2022-09-17 23:29:29",
                "updated_at" => "2022-09-17 23:29:29",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Penyesuaian Diri",
                "assessment_type" => 1
            ],
            [
                "id" => "019bf576-23e9-4482-93fc-ef139a5690c4",
                "created_at" => "2022-09-17 23:29:31",
                "updated_at" => "2022-09-17 23:29:31",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Motivasi Berprestasi",
                "assessment_type" => 1
            ],
            [
                "id" => "c2d49ac9-f97a-4e28-8bfb-2dfac269e8f5",
                "created_at" => "2022-09-17 23:29:33",
                "updated_at" => "2022-09-17 23:29:33",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Pengambil Keputusan",
                "assessment_type" => 1
            ],
            [
                "id" => "daefdbf5-d208-4af9-bd87-42da365f795c",
                "created_at" => "2022-09-17 23:29:35",
                "updated_at" => "2022-09-17 23:29:35",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Loyalitas",
                "assessment_type" => 1
            ],
            [
                "id" => "79ccb1bd-1cae-4259-9226-bc21522af948",
                "created_at" => "2022-09-17 23:29:38",
                "updated_at" => "2022-09-17 23:29:38",
                "deleted_at" => null,
                "lesson_id" => "cdc0e484-01a4-40be-a353-b3164f000ebc",
                "name" => "Kerjasama",
                "assessment_type" => 1
            ],
            [
                "id" => "a5df5a06-d994-4d72-bde0-8103a46f3e1a",
                "created_at" => "2022-09-17 23:30:11",
                "updated_at" => "2022-09-17 23:30:11",
                "deleted_at" => null,
                "lesson_id" => "26057c41-9113-46ed-af81-56716fc90937",
                "name" => "Verbal",
                "assessment_type" => 1
            ],
            [
                "id" => "9e366964-9400-469a-94d4-c2c725792650",
                "created_at" => "2022-09-17 23:30:12",
                "updated_at" => "2022-09-17 23:30:12",
                "deleted_at" => null,
                "lesson_id" => "26057c41-9113-46ed-af81-56716fc90937",
                "name" => "Praktis",
                "assessment_type" => 1
            ],
            [
                "id" => "ed0d01a6-c545-4242-bda8-d6f6b3cc5ca0",
                "created_at" => "2022-09-17 23:30:14",
                "updated_at" => "2022-09-17 23:30:14",
                "deleted_at" => null,
                "lesson_id" => "26057c41-9113-46ed-af81-56716fc90937",
                "name" => "Logis",
                "assessment_type" => 1
            ],
            [
                "id" => "f4a0b38b-c3f8-456b-8f1f-35a80ce2a1e0",
                "created_at" => "2022-09-17 23:30:53",
                "updated_at" => "2022-10-27 03:41:56",
                "deleted_at" => null,
                "lesson_id" => "a5f03254-7522-475f-a9be-ad618db28878",
                "name" => "Kecepatan",
                "assessment_type" => 2
            ],
            [
                "id" => "0313e968-744e-4097-8ce3-cae463a246c4",
                "created_at" => "2022-09-17 23:30:55",
                "updated_at" => "2022-09-17 23:30:55",
                "deleted_at" => null,
                "lesson_id" => "a5f03254-7522-475f-a9be-ad618db28878",
                "name" => "Ketelitian",
                "assessment_type" => 1
            ],
            [
                "id" => "06357aca-6365-45a7-a05e-0a95f3ab00d4",
                "created_at" => "2022-09-17 23:30:57",
                "updated_at" => "2022-10-27 03:42:19",
                "deleted_at" => null,
                "lesson_id" => "a5f03254-7522-475f-a9be-ad618db28878",
                "name" => "Ketahanan",
                "assessment_type" => 3
            ],
            [
                "id" => "e6122f8e-6118-4059-8b97-20802386c9cb",
                "created_at" => "2022-09-17 23:32:32",
                "updated_at" => "2022-09-17 23:32:32",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Stabilitas Emosi",
                "assessment_type" => 1
            ],
            [
                "id" => "2d6b7387-5da4-4dd5-a429-9dc44cc513be",
                "created_at" => "2022-09-17 23:32:33",
                "updated_at" => "2022-09-17 23:32:33",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Pro Sosial",
                "assessment_type" => 1
            ],
            [
                "id" => "97cd1887-5daa-4c67-acb2-d615dd384bbb",
                "created_at" => "2022-09-17 23:32:35",
                "updated_at" => "2022-09-17 23:32:35",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Kepercayaan Diri",
                "assessment_type" => 1
            ],
            [
                "id" => "75eb0ca4-45ad-48c5-8f1d-30c2bc4ce01f",
                "created_at" => "2022-09-17 23:32:37",
                "updated_at" => "2022-09-17 23:32:37",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Penyesuaian Diri",
                "assessment_type" => 1
            ],
            [
                "id" => "148ed279-d9d7-4802-bdc0-170768b64996",
                "created_at" => "2022-09-17 23:32:39",
                "updated_at" => "2022-09-17 23:32:39",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Motivasi Berprestasi",
                "assessment_type" => 1
            ],
            [
                "id" => "65a15144-d31d-406c-afe1-b053b6414b3c",
                "created_at" => "2022-09-17 23:32:41",
                "updated_at" => "2022-09-17 23:32:41",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Pengambilan Keputusan",
                "assessment_type" => 1
            ],
            [
                "id" => "492de9d4-9663-431c-8465-c4dda0680c5a",
                "created_at" => "2022-09-17 23:32:44",
                "updated_at" => "2022-09-17 23:32:44",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Loyalitas",
                "assessment_type" => 1
            ],
            [
                "id" => "7bbe1730-0271-42fb-bbc4-e4613be8a91b",
                "created_at" => "2022-09-17 23:32:46",
                "updated_at" => "2022-09-17 23:32:46",
                "deleted_at" => null,
                "lesson_id" => "b21f1a43-160c-4c0a-9666-7d40d6422756",
                "name" => "Kerjasama",
                "assessment_type" => 1
            ],
            [
                "id" => "b64c6b5c-c0d4-4e0e-add8-d414fb425e64",
                "created_at" => "2022-09-17 23:34:14",
                "updated_at" => "2022-09-17 23:34:14",
                "deleted_at" => null,
                "lesson_id" => "96d4b3b4-f3e8-4dad-a541-e822e45b5fef",
                "name" => "Verbal",
                "assessment_type" => 1
            ],
            [
                "id" => "3ca251fa-2496-4d44-b0a3-83fce24aecf8",
                "created_at" => "2022-09-17 23:34:15",
                "updated_at" => "2022-09-17 23:34:15",
                "deleted_at" => null,
                "lesson_id" => "96d4b3b4-f3e8-4dad-a541-e822e45b5fef",
                "name" => "Praktis",
                "assessment_type" => 1
            ],
            [
                "id" => "b347a81f-21e1-4e6c-b5c1-88390e5a47da",
                "created_at" => "2022-09-17 23:34:16",
                "updated_at" => "2022-09-17 23:34:16",
                "deleted_at" => null,
                "lesson_id" => "96d4b3b4-f3e8-4dad-a541-e822e45b5fef",
                "name" => "Logis",
                "assessment_type" => 1
            ],
            [
                "id" => "9396f6d0-0113-4c34-9360-9d18b502cd20",
                "created_at" => "2022-09-17 23:34:59",
                "updated_at" => "2022-10-27 03:47:00",
                "deleted_at" => null,
                "lesson_id" => "2a258198-ebc8-430b-9b94-d926c615c2dd",
                "name" => "Kecepatan",
                "assessment_type" => 2
            ],
            [
                "id" => "c7bcb8ef-aa83-4d3a-9e5f-a096b3e34559",
                "created_at" => "2022-09-17 23:35:00",
                "updated_at" => "2022-09-17 23:35:00",
                "deleted_at" => null,
                "lesson_id" => "2a258198-ebc8-430b-9b94-d926c615c2dd",
                "name" => "Ketelitian",
                "assessment_type" => 1
            ],
            [
                "id" => "b45343f5-b829-4400-ad02-5f8f96a4c27b",
                "created_at" => "2022-09-17 23:35:02",
                "updated_at" => "2022-10-27 03:47:04",
                "deleted_at" => null,
                "lesson_id" => "2a258198-ebc8-430b-9b94-d926c615c2dd",
                "name" => "Ketahanan",
                "assessment_type" => 3
            ]
        ]);
    }
}
