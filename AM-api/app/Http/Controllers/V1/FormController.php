<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Invitation;
use App\Models\Submission;
use FFI\Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{


    public function create_form(Request $request)
    {

        try {

            $request->validate([
                "content" => ["required"],
                "submission_limit" =>["required"],
                "form_name" => ["required"]
            ]);

            $createForm = Http::post("http://127.0.0.1:3001/draft-db/form", [
                'owner_id' => auth()->user()->id,
                "content" => $request->content,
                "form_name" => $request->form_name
                
            ]);

            if ($createForm->successful()) {
                $newForm = new Form();
                $newForm->form_id = $createForm->json();
                $newForm->owner_id = auth()->user()->id;
                $newForm->submission_limit = $request->submission_limit;
                $newForm->save();

                return $this->success("Form created successfully", 200);
            } else {
                $status = json_decode($createForm->body(), true);
                return $this->error($status, 400);
            }
        } catch (Exception $error) {
            return $this->error($error->getMessage(), 400);
        }
    }


    public function getMyForms()
    {

        try {

            $myForms = Http::get("http://127.0.0.1:3001/draft-db/form/user-forms/" . auth()->user()->id);

            if ($myForms->successful()) {

                return $this->successWithData($myForms->json(), "success", 200);
            } else {

                $status = json_decode($myForms->body(), true);
                return $this->error($status, 400);
            }
        } catch (Exception $error) {

            return $this->error($error->getMessage(), 400);
        }
    }


    public function editForm($id, Request $request)
    {
        try {

            $request->validate([
                "content" => ["required"],
                "form_name" => ["required"]
            ]);
            $data= [
                'content' => $request->content,
                "form_name" => $request->form_name
            ];

            $editForm = Http::patch("http://127.0.0.1:3001/draft-db/form/" . $id, $data);

            if ($editForm->successful()) {
                return $this->success("edit form successfully", 200);
            } else if ($editForm->status() == 404) {
                return $this->error("Not Found", 404);
            } else {
                $status = json_decode($editForm->body(), true);
                return $this->error($status, 400);
            }
        } catch (Exception $error) {
            return $this->error($error->getMessage(), 400);
        }
    }

    public function submission(Request $request)
    {
        try {

            $request->validate([
                "content" => ["required"],
                "form_id" => ["required"],
            ]);

            $makeSubmission = Http::post("http://127.0.0.1:3001/draft-db/submission", [
                'form_id' => $request->form_id,
                "content" => $request->content
            ]);

            if ($makeSubmission->successful()) {

                $newSubmission = new Submission();
                $newSubmission-> form_id = $request->form_id;
                $newSubmission-> submission_id = $makeSubmission->json();
                $newSubmission-> save();
               

                return $this->success("Submission successfully", 200);
            } else {
                $status = json_decode($makeSubmission->body(), true);
                return $this->error($status, 400);
            }
        } catch (Exception $error) {
            return $this->error($error->getMessage(), 400);
        }
    }

    public function sendInvitation(Request $request){
        try{
    
          $request->validate([
            "form_id"=> ["required"],
            "user_email"=> ["required"]
          ]);

          $form = Form::where("form_id", $request->form_id)->first();

          if($form){

            $token=  Str::random(50); 
            $url = "http://192.168.1.147:3000/form/".$token;
            $form_id = $request->form_id;

            $newInvitation = new Invitation();

            $newInvitation->url = $url;
            $newInvitation->token = $token;
            $newInvitation->form_id = $form_id;
            $newInvitation->user_email = $request->user_email;
            $newInvitation->save();

            //send email 

            
            return $this->success("invitation send successfully",200);

          }
            return $this->error("Not Found",404);
    
        }catch(Exception $error){
          return $this->error($error->getMessage(), 400);
        }
      }


      public function checkInvitation(Request $request){
        try{

            $request->validate([
                "token"=>["required"]
            ]);

            $check = Invitation::where("token",$request->token)->first();

            if($check){
                 
                $form = Http::get("http://127.0.0.1:3001/draft-db/form/".$check->form_id);

                
                    if($form->successful()){
    
                        return $this->successWithData($form->json(),"success",200);
    
                    }else{
                        $status = json_decode($form->body(), true);
                        return $this->error($status, 400);
                    }


            }else{

                return $this->error("Unauthorized",401);
            }



        }catch(Exception $error){
            return $this->error($error->getMessage(),400);
        }
      }

      public function getOneForm($id){
        try{

            $form = Http::get("http://127.0.0.1:3001/draft-db/form/".$id);

                
                if($form->successful()){

                    return $this->successWithData($form->json(),"success",200);

                }else{
                    $status = json_decode($form->body(), true);
                    return $this->error($status, 400);
                }

        }catch(Exception $error){
            return $this->error($error->getMessage(),400);
        }
      }

      public function getSubmissionsData($id){
        try{
             

             $submissionExist =  Submission::where("submission_id",$id)->first();

             if($submissionExist){
                
                $data = Http::get("http://127.0.0.1:3001/draft-db/submission/".$id);

                if($data->successful()){
                    return $this->successWithData($data->json(),"success",200);
                }else {
                    $status = json_decode($data->body(), true);
                    return $this->error($status, 400); 
                }
             }

        }catch(Exception $error){
          return $this->error($error->getMessage(),400);
        }
      }
}