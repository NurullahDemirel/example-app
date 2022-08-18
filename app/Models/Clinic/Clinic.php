<?php

namespace App\Models\Clinic;

use App\Models\Doctor\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Clinic extends Authenticatable
{
    use HasFactory,HasRoles,HasApiTokens;

    protected $guarded = [];


    public function doctors()
    {
        return $this->hasMany(Doctor::class,'clinic_id');
    }

//    const ClinicAbilities = ['Update Clinic Name', ',Add New Treatment','Edit Appointment'];
}
