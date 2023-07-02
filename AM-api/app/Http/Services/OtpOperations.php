<?php


namespace App\Http\Services;

use App\Mail\OtpMail;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait OtpOperations
{

    public static function generateOTP()
    {
        $token =  Str::random(100);
        $otpCode = sprintf("%06d", mt_rand(1, 999999));
        $otpExpiredDate = now()->addMinutes(3);
        $tokenExpiredDate = now()->addMinutes(5);


        Otp::updateOrCreate(['user_id' => auth()->user()->id], [
            "user_id" => auth()->user()->id,
            "token" => $token,
            "otp_expired_at" => $otpExpiredDate,
            "token_expired_at" => $tokenExpiredDate,
            "otp" => $otpCode,
        ]);
       
        
        return ["expired_at" => $otpExpiredDate, "token" => $token,"code" => $otpCode];
    }

    public static function reGenerateOTP(Request $request){

        //check if the token is exist 
        
       $otp = Otp::where('token', $request->token)->first(); 
          
         if($otp){

            // check if the token is expired 
           

            if($otp-> token_expired_at > now()){


                $newToken =  Str::random(100);
                $otpCode = sprintf("%06d", mt_rand(1, 999999));
                $otpExpiredDate = now()->addMinutes(3);
                $tokenExpiredDate = now()->addMinutes(5);
            
            
                 

                Otp::updateOrCreate(['token' => $otp->token], [
                    "user_id" => $otp->user->id,
                    "token" => $newToken,
                    "token_expired_at" => $tokenExpiredDate,
                    "otp_expired_at" => $otpExpiredDate,
                    "otp" => $otpCode,
                ]);
                Mail::to($otp->user-> email )->send(new OtpMail($otpCode));
                $data = ["expired_at" => $otpExpiredDate, "token" => $newToken];
                return ["data"=>$data , "status"=> true];

            } else {
                return ["data"=> "sorry you need to login again ","status"=> false];
            }
         }   else {
            return ["data"=> "sorry you need to login again ","status"=> false];
         }   
          
    }

    public static function verifyToken($token)
    {
        $token = Otp::where('token', $token)->first();
        if ($token) {
            return ["status" => true, "otp" => $token];
        } else {
            return ["status" => false, "token" => null];
        }
    }
}