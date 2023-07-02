<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => ["required", "min:3"],
            "email" => ["required", "email","unique:users"],
            "password" => ["required", "string","regex:/[a-z]/","regex:/[A-Z]/","regex:/[0-9]/","regex:/[@$!%*#?&]/", "min:7"],
            "phone_number"=> ["required"]
        ];
    }

    public function messages():array{
        return [

            "name.required" => "the name is required",
            "name.min" => "the name should be more than 3 character",
            "email.required" => "the email is required", 
            "email.email"=> "please enter veiled email ",
            "email.unique" => "sorry the email is taken", 
            "password.required" => "the password is required ",
            "password.min" => "the length of the password should be more than 7 ",
            "password.regex" => "the password should contain at least one lowercase, uppercase,digit and special character "
        ];
    }
}