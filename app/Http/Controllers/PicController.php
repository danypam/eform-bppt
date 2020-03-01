<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\email_progress;
use App\Mail\email_complete;
use function foo\func;

class PicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:task-list', ['only' => ['index','show']]);
        $this->middleware('permission:task-take', ['only' => ['edit','update']]);
    }

    public function index()
    {
        //
        $tasks = $this->form_submissions(2);    //approved by kepala
        $mytasks = $this->form_submissions(3);  //take   by pic
        $completes = $this->form_submissions(4);    //complete by pic
        $pegawai = Pegawai::all();

        return view('/task/index',['tasks'=>$tasks, 'mytasks'=>$mytasks, 'completes'=>$completes, 'pegawai'=>$pegawai]);
    }

    public function form_submissions($status){
        $pic = DB::table('pegawai')
            ->select('id')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

        if($status == config('constants.status.waitForPic')){
                return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->whereRaw("JSON_SEARCH(f.pic, 'one', $pic->id) is not null")
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }elseif ($status == config('constants.status.onGoing')){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }else{
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->whereRaw('form_submissions.complete_at IS NOT NULL')
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }
    }

    public function commit($id){
        //Search ID Pegawai
        return \Illuminate\Support\Facades\DB::table('form_submissions')->where([
            'id' => $id
        ])->update([
            'status' => DB::raw('status + 1')
        ]);
    }

    public function fillWhoTake($id_form_submission){
        //get id pegawai
        $id_pegawai = DB::table('pegawai')
            ->select('id')
            ->where('user_id','=',Auth()->user()->id)
            ->first();

        return DB::table('form_submissions')->where([
            'id' => $id_form_submission
        ])->update([
            'pic' => $id_pegawai->id,
            'pic_at' => Carbon::now()->toDateTimeString()

        ]);
    }

    public function take($id){
        $isFilled = \Illuminate\Support\Facades\DB::table('form_submissions')
            ->select('mengetahui', 'menyetujui', 'pic', 'status')
            ->where('id', '=', $id)
            ->first();
        if(auth()->user()->can('task-list')) {
            \Illuminate\Support\Facades\DB::beginTransaction();
            if(!($isFilled->pic)){
                $this->commit($id);
                $this->fillWhoTake($id);
                DB::commit();
                return redirect('/task')->with('sukses', 'Selamat Mengerjakan');
            }else{
                DB::rollback();
                return redirect('/task')->with('error', 'Formulir Telah Dieksekusi oleh pic lain');
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

    public function complete(Request $request)
    {
        \Illuminate\Support\Facades\DB::table('form_submissions')->where([
            'id'=>$request->submission_id,
        ])->update([
            'status'=>DB::raw('status + 1'),
            'keterangan'=>$request->keterangan,
            'complete_at'=> Carbon::now()->toDateTimeString()
        ]);

        $emails = $this->getemailuser($request->submission_id);

        $details = [
            'name' => $emails->nama_lengkap,
            'url'=>'servicedesk.bppt.go.id',
            'keterangan'=> $request->keterangan
        ];
        //dd($email);
        \Mail::to($emails->email)->send(new email_complete($details));
        return redirect('/task')->with('sukses','Task Complete');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show_form_submissions($status, $id){

        $pic = DB::table('pegawai')
            ->select('id')
            ->where('user_id', '=', auth()->user()->id)
            ->first();

//        return DB::table('form_submissions')
//            ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
//            ->join('forms as f','form_submissions.form_id', '=', 'f.id')
//            ->whereRaw("JSON_SEARCH(f.pic, 'one', $pic->id) is not null")
//            ->where('form_submissions.status', '=', $status)
//            ->where('form_submissions.id', $id)
//            ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
//            ->get();
        if($status == config('constants.status.waitForPic')){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->whereRaw("JSON_SEARCH(f.pic, 'one', $pic->id) is not null")
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }elseif ($status == config('constants.status.onGoing')){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }else{
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->whereRaw('form_submissions.complete_at IS NOT NULL')
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at','form_submissions.keterangan','form_submissions.mengetahui','form_submissions.menyetujui','form_submissions.pic')
                ->get();
        }

    }

    public function show($id)
    {
        $tasks = $this->show_form_submissions(2,$id);    //approved by kepala
        $mytasks = $this->show_form_submissions(3,$id);  //take by pic
        $completes = $this->show_form_submissions(4,$id);    //complete by pic
        $pegawai = Pegawai::all();

        return view('/task/index',['tasks'=>$tasks, 'mytasks'=>$mytasks, 'completes'=>$completes,'pegawai'=>$pegawai]);

    }

    public function edit($id)
    {
        //

    }

    public function update(Request $request, $id)
    {
        //
    }


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
