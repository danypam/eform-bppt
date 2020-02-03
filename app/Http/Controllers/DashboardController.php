<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = DB::table('activity_log')->limit(10)
            ->LeftJoin('users','users.id','=','activity_log.user_id')
            ->select('activity_log.*','users.name')
            ->orderBy('created_at','DESC')
            ->get();

        return view('dashboard.index',['data'=>$data]);
    }
}
