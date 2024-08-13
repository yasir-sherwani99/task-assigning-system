<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'nullable|max:191',
            'address' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'country' => 'nullable|string|max:191',
            'company_name' => 'nullable|string|max:191',
            'designation' => 'required|string|max:191',
            'company_address' => 'nullable|string|max:191',
            'company_city' => 'nullable|string|max:191',
            'company_country' => 'nullable|string|max:191',
            'company_website' => 'nullable|url',
            'company_logo' => 'nullable|mimes:jpeg,jpg,gif,png|max:2000',
        ];
    }
}
