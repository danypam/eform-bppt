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
        $data = DB::table('log_activity')->limit(5)
            ->LeftJoin('users','users.id','=','log_activity.user_id')
            ->select('log_activity.*','users.name')
            ->orderBy('created_at','DESC')
            ->get()
        ;
        $status=\App\Submission::count_submission();
        $chart1=\App\Submission::count_form();
        $chart2=\App\Submission::count_form2();
        $chart3=\App\Submission::count_form3();

        $data_unit = DB::table('unit_kerja')
            ->LeftJoin('pegawai as p', 'p.unit_id', '=', 'unit_kerja.id')
            ->LeftJoin('form_submissions as fs', 'p.user_id', '=', 'fs.user_id')
            ->select(DB::Raw('unit_kerja.nama_unit as nama_unit ,COUNT(fs.id) as total'))
            ->groupBy('unit_kerja.nama_unit')
            ->get();

        //dd($data_unit);
        return view('dashboard.index',['data'=>$data,'chart1'=>$chart1,'status'=>$status,'chart2'=>$chart2,'chart3'=>$chart3,'data_unit'=>$data_unit]);
    }
}
