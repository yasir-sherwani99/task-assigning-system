<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefectStoreRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'defect_type' => 'required|string',
            'priority' => 'required|string',
            'project_id' => 'required',
            'team_id' => 'required',
            'assigned_to_id' => 'required',
            'status' => 'required|string',
            'estimated_hours' => 'nullable',
            'description' => 'nullable'
        ];
    }
}
