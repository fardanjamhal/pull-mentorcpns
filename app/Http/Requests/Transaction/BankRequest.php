<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
        return [
            'bank_name' => 'required|string|max:191',
            'rekening_number' => 'required|string|max:191',
            'rekening_name' => 'required|string|max:191',
            'image' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'bank_name' => __('bank.bank_name'),
            'rekening_number' => __('bank.rekening_number'),
            'rekening_name' => __('bank.rekening_name'),
            'image' => __('bank.image'),
        ];
    }
}
