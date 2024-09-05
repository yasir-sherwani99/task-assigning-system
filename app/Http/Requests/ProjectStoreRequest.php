<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'version' => 'required|string|max:191',
            'client_id' => 'required',
            'team_id' => 'required',
            'assigned_to_id' => 'required',
            'demo_url' => 'nullable|url',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string',
            'billing_type' => 'nullable',
            'budget' => 'nullable',
            'estimated_hours' => 'nullable',
            'is_auto_progress' => 'nullable',
            'logo' => 'nullable|mimes:jpeg,jpg,gif,png|max:2000',
        ];
    }
}
