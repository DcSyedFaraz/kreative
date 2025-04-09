<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        $userId = $this->route('user')->id;

        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($userId),
                'regex:/^[a-zA-Z0-9_]+$/',
            ],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'verify_email' => ['sometimes'],
            'role' => ['required', 'exists:roles,name'], // Add role validation
        ];
    }
}
