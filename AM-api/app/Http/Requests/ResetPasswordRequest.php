<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            "current_password"=>["required"],
            "password" => ["required", "string","regex:/[a-z]/","regex:/[A-Z]/","regex:/[0-9]/","regex:/[@$!%*#?&]/", "min:7","confirmed"],
        ];
    }

    public function messages():array{
        return [
            "password.required" => "the password is required ",
            "password.min" => "the length of the password should be more than 7 ",
            "password.regex" => "the password should contain at least one lowercase, uppercase,digit and special character ",
            "password.confirmed"=> "the password not match",
            "current_password.required"=>"the current password is required"

        ];
    }
}