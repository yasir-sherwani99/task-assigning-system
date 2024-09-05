<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
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
            'user_id' => 'required',
            'client_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location' => 'nullable|string|max:191',
            'notes' => 'nullable|string'
        ];
    }
}
