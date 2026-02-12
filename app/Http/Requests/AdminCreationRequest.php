<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:admins',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
