<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:locations']
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Der Standortname ist erforderlich.',
            'name.max' => 'Der Standortname darf maximal 255 Zeichen lang sein.',
            'name.unique' => 'Dieser Standort existiert bereits.'
        ];
    }
}
