<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'thumbnail' => request()->isMethod('PUT') ? 'sometimes' : 'required',
            'development_status' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('category.name'),
            'thumbnail' => __('category.thumbnail'),
            'development_status' => __('category.development_status'),
        ];
    }
}
