<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->route( 'user' )->id],
            'password'   => ['nullable', 'confirmed', Password::defaults()],
            'role'       => ['required', 'string'],
            'phone'      => ['required', 'string', 'unique:users,phone,' . $this->route( 'user' )->id],
            'image'      => ['nullable', 'image'],
            'student_id' => ['required_if:role,student', 'nullable', 'string', 'unique:users,student_id,' . $this->route( 'user' )->id],
        ];
    }
}
