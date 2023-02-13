<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearnableRandomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'count' => 'integer|between:1,50',
        ];
    }
}
