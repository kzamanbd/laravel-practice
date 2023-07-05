<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,'.$this->route('role'),
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ];
    }

    public function authorize()
    {
        return auth()->check();
    }
}
