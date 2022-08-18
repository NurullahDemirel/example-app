<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;
use App\Models\Clinic\Clinic;
use App\Models\Treatment\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{
    public function clinicLoginPage()
    {

    }
    public function clinicData()
    {
        $user = auth()->user();

        return response()->json([
            'data'=>$user
        ]);
    }

    public function clinicLogin(Request $request)
    {
        $input = $request->all();

        $validation = Validator::make($input,[
           'email'=>'required|email|exists:clinics',
           'password'=>'required'
        ]);

        $this->requestValidation($validation);

        if (Auth::guard('clinics')->attempt(['email'=>$input['email'],'password'=>$input['password']])){
            $user = Auth::guard('clinics')->user();

            $token = $user->createToken('MyApp',['clinics'])->plainTextToken;

            return  response()->json([
                'token'=>$token
            ],200);
        }
    }

    public function clinicRegister(Request $request)
    {
        $input = $request->all();

        $validation = Validator::make($input,[
            'name'=>'required',
            'email'=>'required|email|unique:clinics',
            'password'=>'required'
        ]);

        $this->requestValidation($validation);

        $user = Clinic::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        auth()->guard('clinics')->login($user);
        $token = $user->createToken('MyApp',['clinics'])->plainTextToken;


        return  response()->json([
            'token'=>$token
        ]);
    }
    public function requestValidation($validation)
    {
        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],422);
        }
    }

    public function updateClinicName(Request $request)
    {
        dd('success');
    }
    //clinic change status or date appointment
    public function updateAppoinment(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'appointment_id'=>'required',
        ]);

        $this->requestValidation($validation);

        //for log save
        $user =auth()->user();
        $appointment = Appointment::with(['doctor','doctor.appointmnets'])->find($request->appointment_id);
        if ($appointment){
            if ($request->has('date')){
                $doctor = $appointment->doctor;

                //check per hour rule

                $appointments = $appointment->doctor->appointmnets;

                $from = Carbon::createFromFormat('Y-m-d H:i:s', $request->date);
                $to = Carbon::createFromFormat('Y-m-d H:i:s', $request->date)->addHour();

                $exists=$appointments->whereBetween('reservation_from', [$from, $to])->get();

                if (count($exists)){
                    return response()->json([
                        'message'=>'',
                        'error'=>true
                    ],400);//bad request
                }
                $appointment->update([
                    'date'=>$request->date
                ]);

                return response()->json([
                    'message'=>'Appontment date was updated as ' . $request->date
                ],200);
            }

            if ($request->has('status')){
                $appointment->update([
                    'active' => $request->status
                ]);
            }

            return response()->json([
                'message'=>'updated successfully'
            ],200);


        }
        else{
            return response()->json([
                'message'=>'no appointment '
            ],404);
        }
    }

    public function updateTreatment(Request $request)
    {
        $validation =Validator::make($request->all(),[
            'treatment_id'=>'required|exists:treatments,id'
        ]);

        $this->requestValidation($validation);
        $input=$request->all();
        unset($input['treatment_id']);
        $appintment =Treatment::find($request->treatment_id)->update($input);

        return response()->json([
            'message'=>'treatment was updated successfully'
        ],200);

    }

    public function createTreatment(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'doctor_id'=>'required|exists:doctors,id'
        ]);

        Treatment::create($request->all());
        return response()->json([
            'message'=>'treatment was created successfully'
        ],200);
    }
}
