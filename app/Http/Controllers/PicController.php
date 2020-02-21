<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
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

        return view('/task/index',['tasks'=>$tasks, 'mytasks'=>$mytasks, 'completes'=>$completes]);
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
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->get();
        }elseif ($status == config('constants.status.onGoing')){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->get();
        }else{
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id', '=', 'f.id')
                ->where('form_submissions.pic','=',$pic->id)
                ->whereRaw('form_submissions.complete_at IS NOT NULL')
                ->where('form_submissions.status', '=', $status)
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
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

    public function complete($id)
    {
        \Illuminate\Support\Facades\DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>DB::raw('status + 1'),
            'complete_at'=> Carbon::now()->toDateTimeString()
        ]);
        return redirect('/task')->with('sukses','Task Complete');
    }
    /**
     * Show the form for creating a new resource.
     *
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

    /**
     * Display the specified resource.
     *
     * @param  int  $form_id
     * @param  int  $submission_id
     * @return \Illuminate\Http\Response
     */
    public function show($form_id, $submission_id)
    {
        //



        $submission = Submission::with('user', 'form')
            ->where([
                'form_id' => $form_id,
                'id' => $submission_id,
            ])
            ->firstOrFail();
        $form_headers = $submission->form->getEntriesHeader();

        $identitas = Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id',$submission->user_id)->first();

        $pageTitle = "View Submission";

        return view('/task/show', compact('pageTitle', 'submission', 'form_headers','identitas'));
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
}
