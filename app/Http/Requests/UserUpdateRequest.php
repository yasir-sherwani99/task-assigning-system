<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'photo' => 'nullable|mimes:jpeg,jpg,gif,png|max:2000',
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:191',
            'address' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'country' => 'nullable|string|max:191',
            'role_id' => 'required'
        ];
    }
}
