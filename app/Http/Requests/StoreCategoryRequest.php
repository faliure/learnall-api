<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255|unique:categories',
            'slug' => 'alpha_dash|min:3|max:255|unique:categories',
        ];
    }
}
