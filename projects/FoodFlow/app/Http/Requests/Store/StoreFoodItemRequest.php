<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'location_id' => 'required|exists:locations,id',
                'expiration_date' => 'required|date|after:today',
                'quantity' => 'required|integer|min:1',
        ];
    }
}
