<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/',
            ],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'verify_email' => ['sometimes', 'boolean'],
            'role' => ['required', 'exists:roles,name'], // Add role validation
        ];
    }
}
