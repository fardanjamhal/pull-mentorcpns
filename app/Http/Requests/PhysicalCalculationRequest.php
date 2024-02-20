<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhysicalCalculationRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'sex' => 'sometimes',
            'running' => 'sometimes',
            'pull_up' => '',
            'chinning' => '',
            'sit_up' => 'sometimes',
            'push_up' => 'sometimes',
            'shuttle_run' => 'sometimes',
            'swimming' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'sex' => 'Jenis Kelamin',
            'running' => 'Lari',
            'pull_up' => 'Pull Up',
            'chinning' => 'Chinning',
            'sit_up' => 'Sit Up',
            'push_up' => 'Push Up',
            'shuttle_run' => 'Shuttle Run',
            'swimming' => 'Renang',
        ];
    }
}
