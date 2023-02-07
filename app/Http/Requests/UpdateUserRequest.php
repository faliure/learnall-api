<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(Request $request): array
    {
        $affectedUser = $request->route()->parameter('user');

        return [
            'name'         => 'alpha|max:255',
            'email'        => [ 'email', 'max:255', Rule::unique('users')->ignore($affectedUser) ],
            'password'     => [ 'confirmed', Password::defaults() ],
            'old_password' => 'required_with:password|current_password',
        ];
    }
}
