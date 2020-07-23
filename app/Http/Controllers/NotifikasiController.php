<?php

namespace App\Http\Controllers;

use App\Notifications\NewForm;
use App\Submission;
use App\User;
use App\Pegawai;
use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function get(){
        $notification = auth()->user()->unreadNotifications;
        return $notification;
    }
    public function read(Request $request){
        auth()->user()->unreadNotifications()->find($request->id)->markAsRead();
        return 'success';
    }

    public function show($id){
        function inbox_table(){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->select('nama_lengkap','keterangan','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at');
        }
        $inboxs = inbox_table()
            ->where('form_submissions.id', '=', $id)
            ->get();
        return view('/inbox/read',['inboxs'=>$inboxs]);
    }

    public function get_user($submisions_id){

    }
    public static function sent_kepala($submisions_id){
        $users = User::whereHas('roles',function($q){
            $q->where('name', 'kepala');
        })->get();
        if (\Notification::send($users, new NewForm(Submission::find($submisions_id)))){
            return back();
        }
    }
    public static function sent_pic($submisions_id){
        $pic = Submission::with('form')->find($submisions_id)->form->pic;
        $pic = json_decode($pic);
        $users = Pegawai::with('user')->find($pic)->pluck('user_id');
        $users = User::find($users);
        if (\Notification::send($users, new NewForm(Submission::find($submisions_id)))){
            return back();
        }
    }

    public static function sent_atasan($submissions_id){
        $sub = Submission::with('pegawai.unit_jabatan')->find($submissions_id);
        $unit_atas1 = $sub->pegawai->unit_jabatan->kode_unitatas1;
        $unit_atas2 = $sub->pegawai->unit_jabatan->kode_unitatas2;
        $users =   User::with('pegawai')->whereHas('pegawai', function($q) use ($unit_atas2, $unit_atas1){
            $q->where('unit_jabatan_id', '=',$unit_atas1)
                ->orWhere('unit_jabatan_id', '=', $unit_atas2);
        }) ->get();
        if (\Notification::send($users, new NewForm(Submission::find($submissions_id)))){
            return back();
        }
    }
}
