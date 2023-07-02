<?php 
namespace App\Http\Services;
use App\Http\Requests\ImageRequest;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;


class ProjectService {


    // public function upload_images(Request $request) {

       
        
    //     // if($files = $request->file('images')){
    //     //     // dd(gettype($files));
    //     //     foreach($files as $file){
                
               
    //     //         $imageName = md5(rand(1000,10000));
    //     //         $ext = strtolower($file->getClientOriginalExtension());
    //     //         $imageFullName = $imageName.'.'.$ext;
    //     //         $path = '/public/projectsImage/';
    //     //         $imageURL = $path.$imageFullName;
    //     //         $file->move($path,$imageFullName);
               
    //     //         $image[] = $imageURL;

               
                 

    //     //     }
    //     // }

    //     if ($request->hasFile("images")) {

            
                
    //         // $filePath = $request->file('images')->store('projectsFile', 'public');
    //         // $ext= $request->file('images')->extension();
    //         // $file = new File();
    //         // $file->name = "name";
    //         // $file->type = $ext;
    //         // $file->path = $filePath;
    //         // $file->save();

    //         foreach ($request->file('images') as $imageFile) {
                
    //             dd($imageFile);
    //             $image = new File;
    //             $path = $imageFile->store('projectsFile', 'public');
    //             $image->path = $path;
    //             $image->type = "png";
    //             $image->name = "Name";
    //             $image->save();
    //           }

    //           throw new Exception("Invalid");
           
    //     } else {

            
    //     }

    // }


    public function exportTxtFile($file){

        $file = fopen($file,'r');
        $data = array();

        while(!feof($file)){
            $content = fgets($file);
            $carry = explode(",", $content);
            $annotate_data = list($annotate_data)=$carry;
             $data = array_merge($data,$annotate_data);
        }

        return $data;

    }
}