<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;

class QuestionTitleRequest extends FormRequest
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
            'lesson_category_id' => 'required',
            'lesson_id' => 'required',
            'name' => 'required|string|max:191',
            'total_choices' => 'required',
            'total_section' => 'required',
            'add_value_category' => 'required',
            'assessment_type' => 'required_if:add_value_category,1',
            'passing_grade' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => __('question_title.category_id'),
            'lesson_category_id' => __('question_title.lesson_category_id'),
            'lesson_id' => __('question_title.lesson_id'),
            'name' => __('question_title.name'),
            'total_choices' => __('question_title.total_choices'),
            'total_section' => __('question_title.total_section'),
            'add_value_category' => __('question_title.add_value_category'),
            'assessment_type' => __('question_title.assessment_type'),
            'passing_grade' => __('question_title.passing_grade'),
        ];
    }
}
