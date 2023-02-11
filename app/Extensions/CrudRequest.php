<?php

namespace App\Extensions;

use Illuminate\Foundation\Http\FormRequest;

class CrudRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'with'    => 'array',
            'count'   => 'array',
            'with.*'  => 'regex:/^[\w\*]*$/|nullable',
            'count.*' => 'regex:/^[\w\*]*$/|nullable',
        ];
    }
}
