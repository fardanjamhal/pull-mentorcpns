<?php

namespace App\Http\Requests\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lesson\QuestionTitle;

class QuestionRequest extends FormRequest
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
        $questionTitle = QuestionTitle::find(request()->question_title_id);

        $validation = [
            // 'value_category_id' => 'required_if:add_value_category,1',
            'audio_input' => 'required',
            'audio' => 'required_if:audio_input,1',
            'audio_played_limit' => 'required_if:audio_input,1',
            'audio_answer_time' => 'required_if:audio_input,1',
            // 'question' => 'required',
            'answer' => 'required',
            'section' => 'required',
        ];

        for($i = 1; $i <= $questionTitle->total_choices; $i++) {
            $validation['option_'.$i] = 'required';
        }

        return $validation;
    }

    public function attributes()
    {
        return [
            'value_category_id' => __('question.value_category_id'),
            'question' => __('question.question'),
            'option_1' => __('question.option_1'),
            'option_2' => __('question.option_2'),
            'option_3' => __('question.option_3'),
            'option_4' => __('question.option_4'),
            'option_5' => __('question.option_5'),
            'answer' => __('question.answer'),
            'section' => __('question.section'),

            'audio_input' => __('question.audio_input'),
            'audio' => __('question.audio'),
            'audio_played_limit' => __('question.audio_played_limit'),
            'audio_answer_time' => __('question.audio_answer_time'),
        ];
    }
}
