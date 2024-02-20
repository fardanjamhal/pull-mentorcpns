<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class DetailValueCategoryRequest extends FormRequest
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
            'min_grade' => 'required',
            'max_grade' => 'required',
            'category_grade' => 'required',
            'final_grade' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'min_grade' => __('detail_value_category.min_grade'),
            'max_grade' => __('detail_value_category.max_grade'),
            'category_grade' => __('detail_value_category.category_grade'),
            'final_grade' => __('detail_value_category.final_grade'),
        ];
    }
}
