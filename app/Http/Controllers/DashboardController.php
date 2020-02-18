<?php

namespace App\Http\Controllers;
use DB;
use App\Submissiom;

use Illuminate\Http\Request;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Models\Submission;



class DashboardController extends Controller
{
    public function index()
    {
        $data = DB::table('log_activity')->limit(5)
            ->LeftJoin('users','users.id','=','log_activity.user_id')
            ->select('log_activity.*','users.name')
            ->orderBy('created_at','DESC')
            ->get();

        $status=\App\Submission::count_submission();
        $chart1=\App\Submission::count_form();
        $chart2=\App\Submission::count_form2();
        $chart3=\App\Submission::count_form3();



        return view('dashboard.index',['data'=>$data,'chart1'=>$chart1,'status'=>$status,'chart2'=>$chart2,'chart3'=>$chart3]);
    }
}
