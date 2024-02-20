<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(request()->isMethod('PUT')) {
            $email = 'required|max:191|unique:users,email,'.request()->id;
            $username = 'required|max:191|unique:users,username,'.request()->id;
            $password = 'sometimes|confirmed';
        } else {
            $email = 'required|max:191|unique:users,email';
            $username = 'required|max:191|unique:users,username';
            $password = 'required|confirmed';
        }

        return [
            'name' => 'required|max:191',
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'level' => 'required',
            'member_type' => 'required',
            'is_active' => 'required',

            'province_id' => 'sometimes',
            'city_id' => 'sometimes',
            'district_id' => 'sometimes',
            'village_id' => 'sometimes',
            'address' => 'sometimes',
            'phone_number' => 'sometimes',
            'gender' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('user.name'),
            'email' => __('user.email'),
            'password' => __('user.password'),
            'level' => __('user.level'),
            'is_active' => __('user.is_active'),
        ];
    }
}
