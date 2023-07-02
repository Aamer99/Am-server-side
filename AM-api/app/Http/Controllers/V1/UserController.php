<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;



class UserController extends Controller
{



  public function signup(UserRequest $request)
  {

    try {

      $createNewUser = UserService::create_User($request);

      if ($createNewUser["status"] == true) {
        return $this->successWithData($createNewUser["data"], "success", 200);
      } else {
        return $this->error("create admin failed ", 400);
      }
    } catch (Exception $error) {
      return $this->error($error->getMessage(), 400);
    }
  }

  public function myAccount(){
    try{
      $user = auth()->user();
    return $this->successWithData(new UserResource ($user), "success", 200);
    
  } catch (Exception $error) {
    return $this->error($error->getMessage(), 400);
  }
    
  }


 



}