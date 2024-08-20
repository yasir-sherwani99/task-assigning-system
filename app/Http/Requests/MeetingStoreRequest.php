<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
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
            'title' => 'required|string|max:191',
            'start_date' => 'required',
            'end_date' => 'required',
            'project_id' => 'nullable',
            'client_id' => 'nullable',
            'members' => 'required|array|min:1',
            'location' => 'nullable|string|max:191',
            'description' => 'nullable|string'
        ];
    }
}
