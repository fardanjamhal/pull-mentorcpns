<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class PaymentConfirmationRequest extends FormRequest
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
            'bank_id' => 'required|exists:banks,id',
            'rekening_name' => 'required|max:191',
            'transfer_date' => 'required|date',
            'total_payment' => 'required|numeric',
            'file' => 'required|file|mimes:png,jpg,jpeg,gif,bmp,svg|max:5120',
        ];
    }

    public function attributes()
    {
        return [
            'bank_id' => __('payment_confirmation.bank_id'),
            'rekening_name' => __('payment_confirmation.rekening_name'),
            'transfer_date' => __('payment_confirmation.transfer_date'),
            'total_payment' => __('payment_confirmation.total_payment'),
            'file' => __('payment_confirmation.file'),
        ];
    }
}
