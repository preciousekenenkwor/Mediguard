<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_id',
        'patient_id',
        'medication_name',
        'dosage',
        'schedule',
    ];
}
