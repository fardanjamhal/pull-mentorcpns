<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamGroupRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
    
            'exam_group_type' => 'required',
            'duration' => 'required_if:exam_group_type, 1',
            'random_question' => 'required_if:exam_group_type, 1',
            'random_answer' => 'required_if:exam_group_type, 1',
            'show_answer' => 'required_if:exam_group_type, 1',
            'show_question_number_navigation' => 'required_if:exam_group_type, 1',
            'show_question_number' => 'required_if:exam_group_type, 1',
            'next_question_automatically' => 'required_if:exam_group_type, 1',
            'show_prev_next_button' => 'required_if:exam_group_type, 1',
            'type_option' => 'required_if:exam_group_type, 1',
            'button_type_finish' => 'required_if:exam_group_type, 1',
            'repeat_the_exam' => 'required_if:exam_group_type, 1',
            'total_tolerance' => 'sometimes',
    
            'assessment_type' => 'required',
            'minimal_grade_type' => 'required',
            'minimal_grade' => 'required_if:minimal_grade_type,2',
            'description_grade_less_than_minimal' => 'required_if:minimal_grade_type,1|required_if:minimal_grade_type,2',
            'description_grade_more_than_minimal' => 'required_if:minimal_grade_type,1|required_if:minimal_grade_type,2',
            'certificate_print_user' => 'required',
            'exam_status' => 'required',    
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => __('exam_group.category_id'),
            'lesson_category_id' => __('exam_group.lesson_category_id'),
            'title' => __('exam_group.title'),
            'description' => __('exam_group.description'),
            'exam_group_type' => __('exam_group.exam_group_type'),
            'duration' => __('exam_group.duration'),
            'random_question' => __('exam_group.random_question'),
            'random_answer' => __('exam_group.random_answer'),
            'show_answer' => __('exam_group.show_answer'),
            'show_question_number_navigation' => __('exam_group.show_question_number_navigation'),
            'show_question_number' => __('exam_group.show_question_number'),
            'next_question_automatically' => __('exam_group.next_question_automatically'),
            'show_prev_next_button' => __('exam_group.show_prev_next_button'),
            'type_option' => __('exam_group.type_option'),
            'button_type_finish' => __('exam_group.button_type_finish'),
            'repeat_the_exam' => __('exam_group.repeat_the_exam'),
            'total_tolerance' => __('exam_group.total_tolerance'),
            'assessment_type' => __('exam_group.assessment_type'),
            'minimal_grade_type' => __('exam_group.minimal_grade_type'),
            'minimal_grade' => __('exam_group.minimal_grade'),
            'description_grade_less_than_minimal' => __('exam_group.description_grade_less_than_minimal'),
            'description_grade_more_than_minimal' => __('exam_group.category_id'),
            'certificate_print_user' => __('exam_group.certificate_print_user'),
            'show_answer' => __('exam_group.show_answer'), 
            'exam_status' => __('exam_group.exam_status'), 
        ];
    }
}
