<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Prüfe auf eindeutigen Namen innerhalb der Community
                Rule::unique('categories')->where('community_id', $this->community_id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Der Kategoriename ist erforderlich.',
            'name.max' => 'Der Kategoriename darf maximal 255 Zeichen lang sein.',
            'name.unique' => 'Diese Kategorie existiert bereits.'
        ];
    }
}
