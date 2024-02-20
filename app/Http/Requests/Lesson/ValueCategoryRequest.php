<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class ValueCategoryRequest extends FormRequest
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
            'lesson_id' => 'required',
            'name' => 'required|string|max:191',
        ];
    }

    public function attributes()
    {
        return [
            'lesson_id' => __('lesson.lesson_id'),
            'name' => __('lesson.name'),
        ];
    }
}
