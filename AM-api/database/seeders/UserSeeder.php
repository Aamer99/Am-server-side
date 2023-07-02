<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // admin 
        $newUser = new User();
        $newUser-> name = "Sortera Admin";
        $newUser-> email = "admin@sortera.com";
        $newUser-> password = Hash::make("123456");
        $newUser-> phone_number = "055555555";
        $newUser-> save(); 

        $adminRole = Role::find(1); 
        $newUser->role()->attach($adminRole);

        // annotators 

        $admin = User::find(1);
        // $newAnnotator->admin()->attach($admin);

        $newAnnotator = new User();
        $newAnnotator-> name = "Anika Kennedy";
		$newAnnotator-> email = "nulla.aliquet.proin@yahoo.com";
        $newAnnotator-> password = Hash::make("123456");
		$newAnnotator-> phone_number = "0555555555";
        $newAnnotator->admin_id = $admin->id;
        $newAnnotator-> save();

         $annotatorRole = Role::find(2);
        $newAnnotator->role()->attach($annotatorRole);  
      // assign role 

        

        //  assign admin 

        // $admin = User::find(1);
        // $newAnnotator->admin()->attach($admin);


        $newAnnotator = new User();
     
        $newAnnotator-> name = "Dahlia Holcomb";
		$newAnnotator-> email = "in@aol.couk";
        $newAnnotator-> password = Hash::make("123456");
		$newAnnotator-> phone_number = "0555555555";
        $newAnnotator-> admin_id = $admin->id;
        $newAnnotator-> save();
        
        // assign role 
        $annotatorRole = Role::find(2);
        $newAnnotator->role()->attach($annotatorRole); 

        // assign admin 
        // $admin = User::find(1);
        // $newAnnotator->admin()->attach($admin);

    }
}