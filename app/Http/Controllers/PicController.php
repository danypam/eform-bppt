<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\email_progress;
use App\Mail\email_complete;


class PicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pic = DB::table('pegawai')
            ->select('id')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

        $tasks = DB::table('form_submissions')
            ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
            ->join('forms as f','form_submissions.form_id', '=', 'f.id')
//            ->whereJsonContains('f.pic', $pic)
            ->whereRaw("JSON_SEARCH(f.pic, 'one', $pic->id) is not null")
            ->where('form_submissions.status', '=', '2')
            ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
            ->get();

        return view('/task/index',['tasks'=>$tasks]);
    }

    public function take($id){


        if(auth()->user()->can('task-list')) {
            \Illuminate\Support\Facades\DB::beginTransaction();
            if(!($isFilled->pic)){
                $this->commit($id);
                $this->fillWhoTake($id);
                DB::commit();
                return redirect('/task')->with('sukses', 'Selamat Mengerjakan');
            }else{
                DB::rollback();
                return redirect('/task')->with('error', 'Formulir Telah Dieksekusi oleh PIC Lain');
            }
        }
    }

    public function cancel($id)
    {
        \Illuminate\Support\Facades\DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>DB::raw('status - 1'),
            'pic'=>null
        ]);
        return redirect('/task')->with('sukses','Task Berhasil Dibatalkan');
    }

    public function complete($id)
    {
        \Illuminate\Support\Facades\DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>DB::raw('status + 1'),
            'complete_at'=> Carbon::now()->toDateTimeString()
        ]);
        $emails = $this->getemailuser($id);

        $details = [
            'name' => $emails->nama_lengkap,
            'url'=>'servicedesk.bppt.go.id'
        ];
        //dd($email);
        \Mail::to($emails->email)->send(new email_complete($details));

        return redirect('/task')->with('sukses','Task Completed');
    }
    /**
     * Show the form for creating a new resource.

     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show_form_submissions($status, $id){

        $pic = DB::table('pegawai')
            ->select('id')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

        return DB::table('form_submissions')
            ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
            ->join('forms as f','form_submissions.form_id', '=', 'f.id')
            ->whereRaw("JSON_SEARCH(f.pic, 'one', $pic->id) is not null")
            ->where('form_submissions.status', '=', $status)
            ->where('form_submissions.id', $id)
            ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
            ->get();

    }

    public function show($id)
    {
        $tasks = $this->show_form_submissions(2,$id);    //approved by kepala
        $mytasks = $this->show_form_submissions(3,$id);  //take by pic
        $completes = $this->show_form_submissions(4,$id);    //complete by pic

        return view('/task/index',['tasks'=>$tasks, 'mytasks'=>$mytasks, 'completes'=>$completes]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    private function getemailuser($id){
//        $iduser= DB::table('pegawai')
//            ->select('id')
//            ->where('id',auth()->user()->id)
//            ->first();
//        $id_form_submission = DB::table('form_submissions')
//            ->join('pegawai as p', 'p.id', '=', 'user_id')
//            ->select('status')
//            ->where('user_id', '=', $iduser->id )
//            ->first();
////        $nilai=config('constants.status.completed');
//        $nilai =4;
//        $emailtouser=DB::table('pegawai')
//            ->where('id','=',$id_form_submission->status->$nilai)
//            ->select('email')
//            ->first();
//
//        return $emailtouser->email;
        $submission=Submission::find($id);
        $user_id = $submission->user_id;
        $pegawai = Pegawai::select('nama_lengkap','email')->where('user_id',$user_id)->first();

        return $pegawai;
    }

}
