<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'category_id' => 'required',
            'active_period' => 'required',
            'period_type' => 'required|in:day,month',
            'price_before_discount' => 'required',
            'price_after_discount' => 'required',
            'description' => 'required',
            'member_categories' => 'required',
            'is_active' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('voucher.name'),
            'category_id' => __('voucher.category_id'),
            'active_period' => __('voucher.active_period'),
            'period_type' => __('voucher.period_type'),
            'price_before_discount' => __('voucher.price_before_discount'),
            'price_after_discount' => __('voucher.price_after_discount'),
            'member_categories' => __('voucher.member_categories'),
            'description' => __('voucher.description'),
            'is_active' => __('voucher.is_active'),
        ];
    }
}
