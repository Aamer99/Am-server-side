<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
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
            "token"=> ["required"],
            "otp"=> ["required","digits:6"],
        ];
    }
    public function messages(){
        return [
            'token.required' => "the token is required",
            'otp.digits'=> "the OTP should be 6 digits",
            'otp.required' => "the OTP is required",
            
            
        ];
    }
}