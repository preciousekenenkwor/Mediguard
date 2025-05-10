<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Crypt;
use Session;

class Sessions extends Model
{
    use HasFactory;


    protected $fillable=[
        "user_id", "session_id", "expires_on"
    ];

    protected function validate($session_id){
        $valid_login=$this->where("session_id", $session_id)->where("expires_on", ">", time())->orderBy("id", "DESC")->first();
        if(!$valid_login){
            return false;
        }
        else{
            $user_agent=Crypt::decrypt($session_id);

            if($user_agent!==$_SERVER["HTTP_USER_AGENT"]){
                return false;
            }
        }

        Session::put("session_id", $session_id);

        return $valid_login["user_id"];
    }


    protected function revalidate(){
        $session_exists=$this->where("session_id", Session::get("session_id"))->where("expires_on",">", time())->orderBy("id", "DESC")->first();
      
        if($session_exists){
            $session_id=Crypt::encrypt($_SERVER["HTTP_USER_AGENT"]);
            setcookie("token", $session_id, $session_exists["expires_on"]);
            return  $session_exists->where("id", $session_exists["id"])->update(["session_id"=>$session_id]);
        }
    }
}
