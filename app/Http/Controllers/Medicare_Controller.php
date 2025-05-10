<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationSchedule as Medic;
use App\Models\Dosage_Taken_Records;
use App\Models\Sessions;

class Medicare_Controller extends Controller
{
    public function save_dosage_schedule(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        if(!$req["patient_id"]){
            return response()->json(["status"=>"error", "message"=>"The patient's ID is required"], 400);
        }

        if(!$req["medication_name"]){
            return response()->json(["status"=>"error", "message"=>"Medication name is required"], 400);
        }

        if(!$req["schedule"]){
            return response()->json(["status"=>"error", "message"=>"The medication schedule is required"], 400);
        }

        if(!$req["dosage"]){
            return response()->json(["status"=>"error", "message"=>"The medication dosage is required"], 400);
        }

        $req["guardian_id"]=$user_id;

        if(Medic::create($req->all())){
            return json_encode(["status"=>"success", "message"=>"Schedule has been created successfully"]);
        }
    }

    public function update_dosage_schedule(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        if(!$req["medication_schedule_id"]){
            return response()->json(["status"=>"error", "message"=>"The Medication Schedule ID is required"], 400);
        }

        $req["guardian_id"]=$user_id;
        unset($req["medication_schedule_id"]);

        if(Medic::where("id", $req["medication_schedule_id"])->update($req->all())){
            return json_encode(["status"=>"success", "message"=>"Schedule has been updated successfully"]);
        }
    }


    public function record_doses_taken(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        if(!$req["patient_id"]){
            return response()->json(["status"=>"error", "message"=>"The patient's ID is required"], 400);
        }

        if(!$req["medication_schedule_id"]){
            return response()->json(["status"=>"error", "message"=>"The medication schedule ID is required"], 400);
        }

        if(!$req["doses_taken"]){
            return response()->json(["status"=>"error", "message"=>"The doses taken is required"], 400);
        }

        $req["administered_by"]=$user_id;

        if(Dosage_Taken_Records::create($req->all())){
            return json_encode(["status"=>"success", "message"=>"Dosage record has been updated successsfully"]);
        }
    }
}
