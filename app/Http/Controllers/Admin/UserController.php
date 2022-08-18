<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getDoctors(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('clinics as c')
                ->leftJoin('doctors as d','c.id','=','d.clinic_id')
                ->select('d.id','d.name as doctor_name','d.surname','d.image','c.name as clinic_name');
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="take/appointment/' .$row->id.'" class="edit btn btn-success btn-sm">Take Appointment</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function apponitmentView($id)
    {
        return view('appintments',compact('id'));
    }

    public function getAppiontments(Request $request,$id)
    {
        if ($request->ajax()){
            $data = DB::table('appointments as a')
                ->leftJoinWhere('doctors as d','a.doctor_id', '=','d.id')
                ->leftJoin('clinics as c','d.clinic_id','=','c.id')
                ->where('a.doctor_id',$id)
                ->where('a.active',1)
                ->select('a.id','a.date','c.name as clinic_name','d.name','d.surname');
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<input type="checkbox" class="form-check-input" value="' .$row->id.'">';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);


        }
    }

    public function takeAppiontmentFromDoctor(Request $request)
    {
        $user = auth()->user();

        $user->appointmnets()->create([
            'doctort_id'=>$request->value,
            'active'=>$request->isDisable ? 0 : 1
        ]);

        return response()->json([
            'message'=>'success'
        ],200);

    }
}
