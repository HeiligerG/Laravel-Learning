<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTweetRequest extends FormRequest
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
            'text' => 'required|string|min:5|max:160',
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => 'Tweetinize: Der Text ist erforderlich',
            'text.min' => 'Tweetinize: Der Text muss mindestens 5 Zeichen lang sein',
            'text.max' => 'Tweetinize: Der Text darf maximal 160 Zeichen lang sein',
            'text.string' => 'Tweetinize: Der Text muss eine Zeichenkette sein und darf nicht Leer sein',
        ];
    }
}
