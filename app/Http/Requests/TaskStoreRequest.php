<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'project_id' => 'required',
            'members' => 'required|array|min:1',
        //    'assigned_to_id' => 'required',
            'status' => 'required|string',
            'priority' => 'required|string',
            'estimated_hours' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable'
        ];
    }
}
