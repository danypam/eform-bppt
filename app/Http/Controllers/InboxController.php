<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\UnitJabatan;
use Illuminate\Http\Request;
use DB;
use jazmy\FormBuilder\Models\Submission;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:inbox-list-mengetahui|inbox-list-menyetujui|inbox-list-all', ['only' => ['index','show']]);
        $this->middleware('permission:inbox-list-mengetahui-edit|inbox-list-menyetujui-edit', ['only' => ['edit','update']]);
    }
    public function index()
    {
//        $datapeg = Pegawai::all()
//            ->where('user_id',auth()->user()->id);
//        dd($datapeg);

//        dd($peg->unit_jabatan_id);

        //admin
        if(auth()->user()->can('inbox-list-all')){

            $inboxs = DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        if (auth()->user()->can('inbox-list-mengetahui')){
            $inboxs = DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->where('form_submissions.status', '=', '0')
                ->where(function ($q){
                    $peg = DB::table('pegawai')
                        ->where('user_id',auth()->user()->id)
                        ->first();
                    $q->where('uj.kode_unitatas1', '=', $peg->unit_jabatan_id)
                        ->orwhere('uj.kode_unitatas2', '=', $peg->unit_jabatan_id);
                })
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        if(auth()->user()->can('inbox-list-menyetujui')){
            $inboxs = DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->select('nama_lengkap','nip','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->where('form_submissions.status', '=', '1')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
    }

    public function approve($id)
    {
        DB::table('form_submissions')->where([
            'id'=>$id
        ])->update([
            'status'=> DB::raw('status + 1')
        ]);
        return redirect('/inbox')->with('sukses','Formulir Berhasil DiSetujui');

    }
    public function reject($id)
    {
        DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>-1,
        ]);
        return redirect('/inbox')->with('sukses','Formulir Berhasil Ditolak');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
