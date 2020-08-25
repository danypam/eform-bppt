<?php

namespace App\Http\Controllers;
use DB;
use App\Submission;
use App\UnitKerja;

use Illuminate\Http\Request;
use jazmy\FormBuilder\Models\Form;



class DashboardController extends Controller
{
    public function index()
    {
        $data = DB::table('log_activity')->limit(7)
            ->LeftJoin('users','users.id','=','log_activity.user_id')
            ->select('log_activity.*','users.name')
            ->orderBy('created_at','DESC')
            ->get()
        ;
        $status=\App\Submission::count_submission();
        $chart1=\App\Submission::count_form();
        $chart2=\App\Submission::count_form2();
        $chart3=\App\Submission::count_form3();
        // $chart=\App\Submission::chart();


        $data_unit = DB::table('unit_jabatan')
            ->LeftJoin('pegawai as p', 'p.unit_id', '=', 'unit_jabatan.id_unit_jabatan')
            ->LeftJoin('form_submissions as fs', 'p.user_id', '=', 'fs.user_id')
            ->select(DB::Raw('unit_jabatan.unit as nama_unit ,COUNT(fs.id) as total'))
            ->where('unit_jabatan.is_unit','=','1')
            ->orWhere('unit_jabatan.is_deputi','=','1')
            ->orWhere('unit_jabatan.is_kabppt','=','1')
            ->groupBy('unit_jabatan.unit')
            ->get();

        //dd($data_unit);
        return view('dashboard.index',['data'=>$data,'chart1'=>$chart1,'status'=>$status,'chart2'=>$chart2,'chart3'=>$chart3,'data_unit'=>$data_unit]);
    }
}
