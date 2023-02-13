<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'string|min:1|max:255|unique:categories',
            'slug' => 'alpha_dash|min:3|max:255|unique:categories',
        ];
    }
}
