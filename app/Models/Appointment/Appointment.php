<?php

namespace App\Models\Appointment;

use App\Models\Doctor\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
