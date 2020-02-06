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
        $data = DB::table('activity_log')->limit(10)
            ->LeftJoin('users','users.id','=','activity_log.user_id')
            ->select('activity_log.*','users.name')
            ->orderBy('created_at','DESC')
            ->get();

        $status=\App\Submission::count_submission();
        $category=\App\Submission::count_form();

        return view('dashboard.index',['data'=>$data,'category'=>$category,'status'=>$status]);
    }
}
