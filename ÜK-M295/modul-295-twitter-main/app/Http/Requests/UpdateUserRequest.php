<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'min:8|identical:password_confirmation',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Der Name ist erforderlich.',
            'name.min' => 'Der Name muss mindestens 3 Zeichen lang sein.',

            'email.required' => 'Die E-Mail-Adresse ist erforderlich.',
            'email.email' => 'Bitte gib eine gültige E-Mail-Adresse ein.',

            'password.required' => 'Das Passwort ist erforderlich.',
            'password.min' => 'Das Passwort muss mindestens 8 Zeichen lang sein.',
            'password.confirmed' => 'Passwort und Passwortbestätigung müssen übereinstimmen.',

            'password_confirmation.required' => 'Die Passwortbestätigung ist erforderlich.',
            'password_confirmation.min' => 'Die Passwortbestätigung muss mindestens 8 Zeichen lang sein.',
        ];
    }
}
