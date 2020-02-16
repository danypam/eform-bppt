<?php
use App\Submission;
use Illuminate\Support\Facades\DB;

function totalsurat(){
    $sub = DB::table('form_submissions')
        ->where('user_id','=',auth()->user()->id)
        ->count();
    return $sub;
}
function formFinish(){
    $fin = DB::table('form_submissions')
        ->where('status','=','4')
        ->where('user_id','=',auth()->user()->id)
        ->count();
    return $fin;
}
function formReject(){
    $re = DB::table('form_submissions')
        ->where('status','=','-1')
        ->where('user_id','=',auth()->user()->id)
        ->count();
    return $re;
}
