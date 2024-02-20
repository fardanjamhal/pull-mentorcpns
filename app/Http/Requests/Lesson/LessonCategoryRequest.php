<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class LessonCategoryRequest extends FormRequest
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
            'category_id' => 'required',
            'name' => 'required|string|max:191',
            'description' => 'required',
            'thumbnail' => request()->isMethod('PUT') ? 'sometimes' : 'required',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => __('lesson_category.category_id'),
            'name' => __('lesson_category.name'),
            'description' => __('lesson_category.description'),
            'thumbnail' => __('lesson_category.thumbnail'),
        ];
    }
}
