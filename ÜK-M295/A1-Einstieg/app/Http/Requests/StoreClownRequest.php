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
}

