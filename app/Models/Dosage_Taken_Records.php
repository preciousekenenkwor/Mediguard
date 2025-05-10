<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosage_Taken_Records extends Model
{
    use HasFactory;

    protected $fillable=[
        "patient_id", "medication_schedule_id", "doses_taken", "administered_by"
    ];
}
