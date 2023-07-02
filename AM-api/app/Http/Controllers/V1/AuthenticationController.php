<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\TokenResource;
use App\Http\Services\AuthenticationService;
use App\Http\Services\OtpOperations;
use App\Mail\OtpMail;
use App\Models\Otp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticationController extends Controller
{

    use OtpOperations;
    public function login(LoginRequest $request)
    {

        $authenticationService = new AuthenticationService();
        $loggedIn = $authenticationService->login($request);

        if ($loggedIn['status'] == true) {

            Mail::to(auth()->user()-> email )->queue(new OtpMail($loggedIn['code']));
            $data = $loggedIn["data"];
            
            return $this->successWithData(["data" => ["token"=> $data["token"], "expired_at"=> $data["expired_at"]]], "success", 200);
        } else {
            return $this->error($loggedIn["data"], 400);
        }
    }


    public function verifyOtp(OtpRequest $request)
    {

        try {
            $authenticationService = new AuthenticationService();

            $authenticated = $authenticationService->verify_otp($request);
            if ($authenticated["status"] == true) {

                return  $this->successWithData($authenticated["data"], "success", 200);

            } else {

                return $this->error($authenticated["data"], 400);
            }
        } catch (Exception $error) {

            return $this->error($error->getMessage(), 400);
        }
    }


    public function logout(Request $request)
    {

        try {
            $request->user()->tokens()->delete();
            return $this->success("User logged out successfully", 200);
        } catch (Exception $error) {
            $this->error($error->getMessage(), 400);
        }
    }


    public function resetPassword(ResetPasswordRequest $request){

        try{ 


        $user = auth()->user(); 
        $checkPassword = Hash::check($request->current_password,$user->password);

        if($checkPassword){
            $authenticationService = new AuthenticationService();
            
           $resetPassword = $authenticationService->reset_password($request);

           if($resetPassword){
            return $this->success("successfully",200);
           } else{
            return $this->error("Password reset failed",400);
           }
  
        }else {
           
            return response()->json(["errors"=>["current_password"=>"Invalid password"]],401);
        }
    } catch(Exception $error){
        return $this->error($error->getMessage(),400);
    }
    }

    public function regenerateOtp(Request $request){

       $reGenerateOTP =  OtpOperations::reGenerateOTP($request);

    
      if($reGenerateOTP["status"] == true){
         
       return $this->successWithData($reGenerateOTP,"successfully",200);

       } else {
        return $this->error($reGenerateOTP["data"],401);
       }
        
      


    }
}