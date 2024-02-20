<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'app_name' => 'required|string|max:191',
            'app_url' => 'required|string|max:191',
            'whatsapp_number' => 'required|numeric',
            'whatsapp_token' => 'required|max:191',
            'address' => 'required',
            'logo' => 'required',
            'signed_name' => 'required',
            'signed_image' => 'required',
            'add_activation_user' => 'required',
            'purchase_type' => 'required',
            'payment_methods' => 'required',
            'login_type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'app_name' => __('setting.app_name'),
            'app_url' => __('setting.app_url'),
            'whatsapp_number' => __('setting.whatsapp_number'),
            'whatsapp_token' => __('setting.whatsapp_token'),
            'address' => __('setting.address'),
            'logo' => __('setting.logo'),
            'signed_name' => __('setting.signed_name'),
            'signed_image' => __('setting.signed_image'),
            'add_activation_user' => __('setting.add_activation_user'),
            'purchase_type' => __('setting.purchase_type'),
            'payment_methods' => __('setting.payment_methods'),
            'login_type' => __('setting.login_type'),
        ];
    }
}
