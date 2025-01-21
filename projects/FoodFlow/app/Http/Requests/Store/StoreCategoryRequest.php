<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Der Kategoriename ist erforderlich.',
            'name.max' => 'Der Kategoriename darf maximal 255 Zeichen lang sein.',
            'name.unique' => 'Diese Kategorie existiert bereits.'
        ];
    }

}
