<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClownRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'name' => 'required',
        'email' => 'required|email',
        'description' => 'required|max:255',
        'rating' => 'required|integer',
        'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
        'name.required' => 'Name ist erforderlich',
        'email.required' => 'E-Mail ist erforderlich',
        'email.email' => 'E-Mail ist nicht korrekt',
        'description.required' => 'Beschreibung ist erforderlich',
        'rating.required' => 'Rating ist erforderlich',
        'rating.integer' => 'Rating ist nicht korrekt',
        'status.required' => 'Status ist erforderlich'
        ];
    }
}

