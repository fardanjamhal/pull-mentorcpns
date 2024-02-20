<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamGroupDetailRequest extends FormRequest
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
            'category_id' => 'required',
            'lesson_category_id' => 'required',
            'lesson_id' => 'required',
            'question_title_id' => 'required',
            'title' => 'required',
            'exam_group_type' => 'required',

            'duration' => 'required_if:exam_group_type, 2',
            'random_question' => 'required_if:exam_group_type, 2',
            'random_answer' => 'required_if:exam_group_type, 2',
            'show_answer' => 'required_if:exam_group_type, 2',
            'show_question_number_navigation' => 'required_if:exam_group_type, 2',
            'show_question_number' => 'required_if:exam_group_type, 2',
            'next_question_automatically' => 'required_if:exam_group_type, 2',
            'show_prev_next_button' => 'required_if:exam_group_type, 2',
            'type_option' => 'required_if:exam_group_type, 2',
            'button_type_finish' => 'required_if:exam_group_type, 2',

            'access_type' => 'required_if:exam_group_type, 2',
            'percentage_grade' => 'required_if:assessment_type, 2',
            'repeat_the_exam' => 'required_if:exam_group_type, 2',
            'show_answer_discussion' => 'required',
            'exam_status' => 'required_if:exam_group_type, 2',
            'total_tolerance' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => __('exam_group_detail.category_id'),
            'lesson_category_id' => __('exam_group_detail.lesson_category_id'),
            'lesson_id' => __('exam_group_detail.lesson_id'),
            'question_title_id' => __('exam_group_detail.question_title_id'),
            'title' => __('exam_group_detail.title'),
            'duration' => __('exam_group_detail.duration'),
            'description' => __('exam_group_detail.description'),
            'access_type' => __('exam_group_detail.access_type'),
            'random_question' => __('exam_group_detail.random_question'),
            'random_answer' => __('exam_group_detail.random_answer'),
            'show_answer' => __('exam_group_detail.show_answer'),
            'show_question_number_navigation' => __('exam_group_detail.show_question_number_navigation'),
            'show_question_number' => __('exam_group_detail.show_question_number'),
            'next_question_automatically' => __('exam_group_detail.next_question_automatically'),
            'show_prev_next_button' => __('exam_group_detail.show_prev_next_button'),
            'type_option' => __('exam_group_detail.type_option'),
            'repeat_the_exam' => __('exam_group_detail.repeat_the_exam'),
            'button_type_finish' => __('exam_group_detail.button_type_finish'),
            'percentage_grade' => __('exam_group_detail.percentage_grade'),
            'exam_status' => __('exam_group_detail.exam_status'),
            'show_answer_discussion' => __('exam_group_detail.show_answer_discussion'),
            'total_tolerance' => __('exam_group_detail.total_tolerance'),
        ];
    }
}
