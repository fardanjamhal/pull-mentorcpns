<?php

namespace App\Http\Requests\Material;

use Illuminate\Foundation\Http\FormRequest;

class VideoModuleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
            'title' => 'required|string|max:191',
            'description' => 'required',
            'link' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => __('video_module.category_id'),
            'title' => __('video_module.title'),
            'description' => __('video_module.description'),
            'link' => __('video_module.link'),
        ];
    }
}
