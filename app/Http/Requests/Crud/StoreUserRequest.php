<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email|max:255|unique:users',
            'password' => [ 'required', 'confirmed', Password::defaults() ],
        ];
    }
}
