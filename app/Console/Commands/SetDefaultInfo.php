<?php

namespace App\Console\Commands;

use App\Models\Appointment\Appointment;
use App\Models\Clinic\Clinic;
use App\Models\Doctor\Doctor;
use App\Models\Treatment\Treatment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetDefaultInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:firs-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clinic = Clinic::create([
            'name'=>'Clinic 1',
            'email'=>'clinic_one.com',
            'password'=>Hash::make('clinicone')
        ]);

        $roleClient = Role::create(['name'=>'Client']);
        $roleDoctor = Role::create(['name'=>'Doctor']);
        $roleClinic = Role::create(['name'=>'Clinic','guard_name'=>'clinics']);

        $clientPermission1 = Permission::create(['name'=>'Update Clinic Name','guard_name'=>'clinics']);
        $clientPermission2 = Permission::create(['name'=>'Add New Treatment','guard_name'=>'clinics']);
        $clientPermission3 = Permission::create(['name'=>'Edit Appointment','guard_name'=>'clinics']);


        $roleClinic->givePermissionTo($clientPermission1);
        $roleClinic->givePermissionTo($clientPermission2);
        $roleClinic->givePermissionTo($clientPermission3);


        $client1 = User::create([
            'name'=>'Nurullah1',
            'email'=>'nurullah1@gmail.com',
            'password'=>Hash::make('nurullah1')
        ]);

        $client2 = User::create([
            'name'=>'Nurullah2',
            'email'=>'nurullah2@gmail.com',
            'password'=>Hash::make('nurullah2')
        ]);

        $doctor1 =Doctor::create([
            'name'=>'Doctor 1',
            'surname'=>'Demirel 1',
            'image'=>'Doctor1.png',
            'clinic_id'=>$clinic->id
        ]);
        $doctor2 =Doctor::create([
            'name'=>'Doctor 2',
            'surname'=>'Demirel 2',
            'image'=>'Doctor2.png',
            'clinic_id'=>$clinic->id
        ]);

        $treatment1 =Treatment::create([
            'name'=>'Treatment 1',
            'description'=>'Treatment 1 description',
            'doctor_id'=>$doctor1->id
        ]);

        $treatment2 =Treatment::create([
            'name'=>'Treatment 2',
            'description'=>'Treatment 2 description',
            'doctor_id'=>$doctor2->id
        ]);

        $appointment1 = Appointment::create([
            'date' => now()->addDays(2),
            'doctor_id'=>$doctor1->id,
            'user_id'=>$client1->id
        ]);

        $appointment2 = Appointment::create([
            'date' => now()->addDays(3),
            'doctor_id'=>$doctor2->id,
            'user_id'=>$client2->id
        ]);

    }
}
