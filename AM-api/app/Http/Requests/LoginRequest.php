<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "email"=> ["required", "Email"],
            "password"=> ["required","min:6"],
        ];
    }

    public function messages(){
        return [
            'email.required' => "the email is required",
            'email.email'=> "please enter a valid email",
            'password.required' => "the password is required",
            'password.max' => "the password should be at least 6 characters"
            
        ];
    }
}