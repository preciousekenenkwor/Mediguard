<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Medicare_Controller;
use App\Http\Controllers\Guardian_Controller;
use App\Http\Controllers\Patients_Controller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("save_dosage_schedule", [Medicare_Controller::class, "save_dosage_schedule"]);
Route::post("update_dosage_schedule", [Medicare_Controller::class, "update_dosage_schedule"]);
Route::post("record_doses_taken", [Medicare_Controller::class, "record_doses_taken"]);

Route::post("guardian_signup", [Guardian_Controller::class, "guardian_signup"]);
Route::post("guardian_login", [Guardian_Controller::class, "guardian_login"]);
Route::post("update_guardian_data", [Guardian_Controller::class, "update_guardian_data"]);

Route::post("add_patient_details", [Patients_Controller::class, "add_patient_details"]);
Route::post("update_patient_details", [Patients_Controller::class, "update_patient_details"]);
Route::get("get_patient_details/{patient_id}", [Patients_Controller::class, "get_patient_details"]);
Route::get("guardian_patients", [Patients_Controller::class, "guardian_patients"]);

