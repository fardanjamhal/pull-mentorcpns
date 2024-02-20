<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\MasterData\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Ramsey\Uuid\Uuid;
use App\Models\Setting;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $setting = Setting::first();

        $niceNames = [
            'province_id' => 'Provinsi'
        ];

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|unique:users',
            'phone_number' => 'required|numeric|unique:students',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',

            'province_id' => $setting->add_data_detail_for_registration == 1 ? 'required' : 'sometimes',
            'city_id' => $setting->add_data_detail_for_registration == 1 ? 'required' : 'sometimes',
            'district_id' => $setting->add_data_detail_for_registration == 1 ? 'required' : 'sometimes',
            'village_id' => $setting->add_data_detail_for_registration == 1 ? 'required' : 'sometimes',
            'address' => $setting->add_data_detail_for_registration == 1 ? 'required' : 'sometimes',
            'gender' => $setting->add_data_detail_for_registration == 1 ? 'required' : '',
        ],
        [], // messages
        [
            'name' => __('user.name'),
            'province_id' => __('user.province_id'),
            'city_id' => __('user.city_id'),
            'district_id' => __('user.district_id'),
            'village_id' => __('user.village_id'),
            'address' => __('user.address'),
            'phone_number' => __('user.phone_number'),
            'gender' => __('user.gender'),
            'email' => __('user.email'),
            'username' => __('user.username'),
            'password' => __('user.password'),

        ])->validate();

        $user = User::create([
            'id' => Uuid::uuid4()->getHex(),
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'level' => 2,
            'expiry_verification_date' => Carbon::now()->addDays(1),
            'is_active' => $setting && $setting->add_activation_user == 0 ? 1 : 0
        ]);

        Student::create([
            'id' => Uuid::uuid4()->getHex(),
            'user_id' => $user->id,
            'province_id' => $input['province_id'],
            'city_id' => $input['city_id'],
            'district_id' => $input['district_id'],
            'village_id' => $input['village_id'],
            'address' => $input['address'],
            'phone_number' => $input['phone_number'],
            'gender' => $input['gender'],
            'member_type' => 2,
            'is_member' => 0,
        ]);

        if($setting && $setting->add_activation_user == 1) {
            $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari ".($setting->app_name ?? "isi data setting terlebih dahulu").", akun anda telah terdaftar di platform kami, berikut link untuk aktivasi akun anda._\n\nNama: ".$user->name."\nEmail: ".$user->email."\n\nBerikut link verifikasi anda\n".($setting->app_url ?? "isi-setting-terlebih-dahulu")."/user/".$user->id."/activation \n\n*Jika link tidak bisa diklik, silakan copy dan paste dibrowser anda.*\n\n_terimakasih telah menjadi bagian dari kami, semoga kami dapat membantu anda lolos terpilih. aamiin._";
            sendWhatsappNotification($user->student->phone_number, $message);
        }

        return $user;
    }

    public function setAttributeNames(array $attributes)
    {
        $this->customAttributes = $attributes;

        return $this;
    }
}
