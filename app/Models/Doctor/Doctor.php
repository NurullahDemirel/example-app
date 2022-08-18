<?php

namespace App\Models\Doctor;

use App\Models\Appointment\Appointment;
use App\Models\Clinic\Clinic;
use App\Models\Treatment\Treatment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class,'doctor_id');
    }

    public function appointmnets()
    {
        return $this->hasMany(Appointment::class,'doctor_id');
    }
}
