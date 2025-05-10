<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guardians;
use App\Models\Sessions;
use Hash;
use Cookie;
use Crypt;

class Guardian_Controller extends Controller
{
    public function guardian_signup(Request $req){
        if(!$req["name"]){
            return response()->json(["status"=>"error", "message"=>"Name is required"], 400);
        }   

        if(!$req["email"]){
            return response()->json(["status"=>"error", "message"=>"Email is required"], 400);
        }   

        else if(!filter_var($req["email"], FILTER_VALIDATE_EMAIL)){
            return response()->json(["status"=>"error", "message"=>"Wrong email format"], 400);
        }

        if(!$req["password"]){
            return response()->json(["status"=>"error", "message"=>"Password is required"], 400);
        }

        if(strlen($req["password"])<8){
            return response()->json(["status"=>"error", "message"=>"Password must contain at least 8 characters"], 400);
        }
        
        $email_exists=Guardians::where("email", $req["email"])->first();

        if($email_exists){
            return response()->json(["status"=>"error", "message"=>"Email address already exists"], 400);
        }

        $req["password"]=Hash::make($req["password"]);

        $data=$req->all();

        if(Guardians::create($data)){
            return response()->json(["status"=>"success", "message"=>"Signup was successful"]);
        }


        return response()->json(["status"=>"error", "message"=>"Signup failed"]);
    }


    public function update_guardian_data(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        $data=[];

        if($req["name"]){
            $data["name"]=$req["name"];
        }

        if(!filter_var($req["email"], FILTER_VALIDATE_EMAIL)){
            return response()->json(["status"=>"error", "message"=>"Wrong email format"], 400);
        }
        else{
            $data["email"]=$req["email"];
        }

        if($req["password"]){
            if(strlen($req["password"])<8){
                return response()->json(["status"=>"error", "message"=>"Password must contain at least 8 characters"], 400);
            }
            else{
                $data["password"]=Hash::make($req["password"]);
            }
        }

        $email_exists=Guardians::where("email", $req["email"])->where("id","!=", $user_id)->first();

        if($email_exists){
            return response()->json(["status"=>"error", "The email address is already in use by another user"]);
        }

        if(Guardians::where("id", $user_id)->update($data)){
            return response()->json(["status"=>"success", "message"=>"Profile data was successfully updated"]);
        }
    }


    public function guardian_login(Request $req){
        $data=$req->all();
        $email_exists=Guardians::where("email", $req["email"])->first();

        if(!$email_exists){
            return response()->json(["status"=>"error", "message"=>"Your login credentials are incorrect"], 400);
        }

        if(password_verify($req["password"], $email_exists["password"])){
            $session_id=Crypt::encrypt($_SERVER["HTTP_USER_AGENT"]);
            Sessions::create(["user_id"=>$email_exists["id"], "session_id"=>$session_id, "expires_on"=>time()+(365*24*60*60)]);
            setcookie("token", $session_id, time()+(365*24*60*60));
            return response()->json(["status"=>"success", "message"=>"Login was successful"]);
        }
    }
}
