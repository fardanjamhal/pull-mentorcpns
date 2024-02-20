<?php

namespace App\Http\Requests\Material;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'category_id' => __('module.category_id'),
            'title' => __('module.title'),
            'description' => __('module.description'),
            'link' => __('module.link'),
        ];
    }
}
