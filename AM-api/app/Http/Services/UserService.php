<?php

namespace App\Http\Services;

use App\Http\Requests\UserRequest;
use App\Mail\WelcomeMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{



    public static function create_User(UserRequest $request)
    {

       
        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->phone_number = $request->phone_number;
        $newUser->save();

     
        // send Email to the new user with the account information 

        Mail::to($newUser->email)->queue(new WelcomeMail($newUser->name, $newUser->email, "444"));

        return ["data" => $newUser, "status" => true];
    }

    
  

    public static function edit_profile()
    {
        
    }
}