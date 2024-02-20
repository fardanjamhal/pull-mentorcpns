<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'lesson_category_id' => 'required',
            'name' => 'required|string|max:191',
            'thumbnail' => request()->isMethod('PUT') ? 'sometimes' : 'required',
        ];
    }

    public function attributes()
    {
        return [
            'lesson_category_id' => __('lesson.lesson_category_id'),
            'name' => __('lesson.name'),
            'thumbnail' => __('lesson.thumbnail'),
        ];
    }
}
