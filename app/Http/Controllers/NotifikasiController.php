<?php

namespace App\Http\Controllers;

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
}
