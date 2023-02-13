<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        return $request->route()->parameter('user')->is(me());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(Request $request): array
    {
        $affectedUser = $request->route()->parameter('user');

        return [
            'name'          => 'alpha|max:255',
            'email'         => [ 'email', 'max:255', Rule::unique('users')->ignore($affectedUser) ],
            'password'      => [ 'confirmed', Password::defaults() ],
            'old_password'  => 'required_with:password|current_password',
            'active_course' => 'exists:courses,id',
        ];
    }
}
