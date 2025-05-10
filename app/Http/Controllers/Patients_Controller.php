<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessions;
use App\Models\Patients;
use App\Models\MedicationSchedule as Medic;
use App\Models\Dosage_Taken_Records;

class Patients_Controller extends Controller
{
    public function add_patient_details(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();
        
        if(!$req["name"]){
            return response()->json(["status"=>"error", "message"=>"Name is required"], 400);
        }   

        if(!$req["age"]){
            return response()->json(["status"=>"error", "message"=>"Age is required"], 400);
        }   

        else if(!preg_match("/^[1-9][0-9]*$/", $req["age"])){
            return response()->json(["status"=>"error", "message"=>"Please input a valid age"], 400);
        }

        $req["guardian_id"]=$user_id;   
        if(Patients::create($req->all())){
            return response()->json(["status"=>"success", "message"=>"Patient's details have been saved successfully"]);
        };
    }

    public function update_patient_details(Request $req){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        $patient_exists=Patients::where("guardian_id", $user_id)->where("id", $req["patient_id"])->first();
        
        if(!$patient_exists){
            return response()->json(["status"=>"error", "message"=>"Patient does not exist"], 400);
        }

        $patient_id=$req["patient_id"];

        if(!$req["name"]){
            return response()->json(["status"=>"error", "message"=>"Name is required"], 400);
        }   

        if(!$req["age"]){
            return response()->json(["status"=>"error", "message"=>"Age is required"], 400);
        }   

        else if(!preg_match("/^[1-9][0-9]*$/", $req["age"])){
            return response()->json(["status"=>"error", "message"=>"Please input a valid age"], 400);
        }
          
        unset($req["patient_id"]);

        if(Patients::where("id", $patient_id)->update($req->all())){
            return response()->json(["status"=>"success", "message"=>"Patient's details have been updated successfully"]);
        };
    }


    public function get_patient_details($patient_id){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        $patient_exists=Patients::where("guardian_id", $user_id)->where("id", $patient_id)->first();
        
        if(!$patient_exists){
            return response()->json(["status"=>"error", "data"=>null], 400);
        }

        $medic_exists=Medic::where("patient_id", $patient_id)->get();
        $medic_taken_exists=Dosage_Taken_Records::where("patient_id", $patient_id)->get();

        $patient_details=json_decode(json_encode($patient_exists), true);
        $patient_details["patient_id"]=$patient_details["id"];
        unset($patient_details["id"]);

        $patient_details["medications_schedules"]=[];

        $medic_details=json_decode(json_encode($medic_exists), true);

        foreach($medic_details as $medic){
            $medic["medication_schedule_id"]=$medic["id"];
          
            unset($medic["id"]);
            array_push($patient_details["medications_schedules"], $medic);
        }

        $patient_details["medications_taken_records"]=[];
        $medi_taken_details=json_decode(json_encode($medic_taken_exists), true);

        foreach($medi_taken_details as $medic){
            $medic["doses_taken_id"]=$medic["id"];

            unset($medic["id"]);
            array_push($patient_details["medications_taken_records"], $medic);
        }

        return response()->json(["status"=>"success", "data"=>$patient_details]);
    }


    public function guardian_patients(){
        $user_id=Sessions::validate($_COOKIE["token"]);
        if(!$user_id){
            return response()->json(["status"=>"error", "message"=>"Unauthorized"], 401);
        }

        Sessions::revalidate();

        $patients=Patients::where("guardian_id", $user_id)->get();
        $patients=json_decode(json_encode($patients), true);

        $all_patients=[];
        
        foreach($patients as $patient){
            $patient["patient_id"]=$patient["id"];
            unset($patient["id"]);
            array_push($all_patients, $patient);
        }

        return response()->json(["status"=>"success", "data"=>$all_patients]);
    }
}
