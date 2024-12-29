<?php

namespace App\Http\Requests;

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
        $userId = $this->route( 'user' ); // Getting the user ID from the route parameter

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', "unique:users,email,{$userId}"],
            'phone'      => ['nullable', 'string', 'max:15', "unique:users,phone,{$userId}"],
            'role'       => ['required', 'string'],
            'student_id' => ['nullable', 'string', 'max:50', "unique:users,student_id,{$userId}"],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
}
