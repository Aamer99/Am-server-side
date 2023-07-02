<?php

namespace App\Http\Services;

trait HttpResponses{

    protected function success($message,$code){

        return response()->json([
           
            "message"=> $message
        ],$code);
    } 

    protected function error($message,$code){
        return response()->json(["message"=>$message],$code);
    }

    protected function successWithData($data,$message,$code){

        return response()->json([
            "data"=> $data,
            "message"=> $message
        ],$code);

    }
    
}



?>