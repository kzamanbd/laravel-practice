<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user,
            'password' => 'nullable|string|confirmed|min:8',
            'roles' => 'nullable|array',
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
