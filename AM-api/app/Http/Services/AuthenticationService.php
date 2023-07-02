<?php

namespace App\Http\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\OtpOperations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{

    use OtpOperations;

    public static function login(LoginRequest $request)
    {


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $otp = OtpOperations::generateOTP();


            return ["data" => $otp, "status" => true, "code" => $otp["code"]];
        } else {
            return ["data" => "invalid email or password", "status" => false];
        }
    }



    public function verify_otp(OtpRequest $request)
    {

        $verifyToken = OtpOperations::verifyToken($request->token);

        if ($verifyToken["status"]) {

            $otp = $verifyToken["otp"];

            if ($otp->otp_expired_at > now()) {
                if ($otp->otp == $request->otp) {

                    $user = $otp->user;

                    $token = $otp->user->createToken("API Token")->plainTextToken;

                    return ["data" => ["user" => new UserResource($user), "token" => $token], "status" => true];
                } else {


                    return ["data" => 'invalid Code', "status" => false];
                    
                }
            } else {
                return ["data" => 'the OTP expires', "status" => false];
            }
        } else {

            // throw ValidationException::withMessages(['message' => 'Unauthorized']);
            return ["data" => 'Unauthorized', "status" => false];
        }
    }

    public function reset_password(ResetPasswordRequest $request)
    {

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        $request->user()->tokens()->delete();

        return true;
    }
}