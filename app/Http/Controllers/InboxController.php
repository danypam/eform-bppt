<?php

namespace App\Http\Controllers;

use App\Mail\email_kepala;
use App\Notifications\NewForm;
use App\Pegawai;
use App\UnitJabatan;
use App\Submission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:inbox-list-mengetahui|inbox-list-menyetujui|inbox-list-all|inbox-list-mengetahui-menyetujui', ['only' => ['index','show']]);
        $this->middleware('permission:inbox-approve-all|inbox-approve-mengetahui|inbox-approve-menyetujui|inbox-approve-mengetahui-menyetujui', ['only' => ['edit','update']]);
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
                ->select('nama_lengkap','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        //atasan langsung
        else if (auth()->user()->can('inbox-list-mengetahui')){
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
                ->select('nama_lengkap','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        //kepala
        else if(auth()->user()->can('inbox-list-menyetujui')){
            $inboxs = DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->select('nama_lengkap','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->where('form_submissions.status', '=', '1')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        //atasan langsung sekaligus kepala
        else if(auth()->user()->can('inbox-list-mengetahui-menyetujui')){
            $inboxs = DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->select('nama_lengkap','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->where(function($q) {
                    $peg = DB::table('pegawai')
                        ->where('user_id',auth()->user()->id)
                        ->first();
                    $q->where('form_submissions.status', '=', '0')
                        ->where('uj.kode_unitatas1', '=', $peg->unit_jabatan_id)
                        ->orwhere('uj.kode_unitatas2', '=', $peg->unit_jabatan_id);
                })
                ->orWhere('form_submissions.status', '=', '1')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
    }

    public function commit($id){
        //Search ID Pegawai
        return DB::table('form_submissions')->where([
                        'id' => $id
                    ])->update([
                        'status' => DB::raw('status + 1')
                    ]);
    }

    public function fillWhoApprove($id_form_submission, $column){
        //get id pegawai
        $id_pegawai = DB::table('pegawai')
                        ->select('id')
                        ->where('user_id','=',Auth()->user()->id)
                        ->first();

        return DB::table('form_submissions')->where([
             'id' => $id_form_submission
            ])->update([
            $column => $id_pegawai->id
            ]);
    }

    public function approve($id)
    {
        $isFilled = DB::table('form_submissions')
            ->select('mengetahui', 'menyetujui', 'pic', 'status')
            ->where('id', '=', $id)
        ->first();

            //approve all
                if(auth()->user()->can('inbox-approve-all')) {

                if(!isset($isFilled->mengetahui)
                    || !isset($isFilled->menyetujui)
                    || !isset($isFilled->pic)){
                    //$this->commit($id);
                    return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
                }
                else{
                    return redirect('/inbox')->with('error  ', 'Formulir Telah Dieksekusi oleh user lain');
                }
                //approve mengetahui sekaligus menyetujui
            }else if(auth()->user()->can('inbox-approve-mengetahui-menyetujui')){
                DB::beginTransaction();
                try{
                    if(!isset($isFilled->mengetahui)){
                        $this->commit($id);
                        $this->fillWhoApprove($id, "mengetahui");
                    }
                    if(!isset($isFilled->menyetujui)){
                        $this->commit($id);
                        $this->fillWhoApprove($id, "menyetujui");
                    }
                    DB::commit();
                    return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
                }catch (Throwable $e){
                    DB::rollback();
                    return redirect('/inbox')->with('error', 'Error');
                }
            } else if(auth()->user()->can('inbox-approve-menyetujui')){
                DB::beginTransaction();
                if(!($isFilled->menyetujui)){
                     $this->commit($id);
                     $this->fillWhoApprove($id, "menyetujui");
                     DB::commit();
                    $users = User::whereHas('roles',function($q){
                        $q->where('name','pic');
                    })->get();
                    if (\Notification::send($users, new NewForm(Submission::latest('id')->first())))
                    {
                        return back();
                    }

                    return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
                }else{
                    DB::rollback();
                    return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
                }
            }else if(auth()->user()->can('inbox-approve-mengetahui')) {
                DB::beginTransaction();
                if ((!$isFilled->mengetahui)) {
                    $this->commit($id);
                    $this->fillWhoApprove($id, "mengetahui");
                    DB::commit();
                    $users = User::whereHas('roles',function($q){
                        $q->where('name','kepala');
                    })->get();
                    if (\Notification::send($users, new NewForm(Submission::latest('id')->first())))
                    {
                        return back();
                    }
                    return redirect('/inbox')->with('sukses', 'Form Berhasil DiSetujui');
                } else {
                    DB::rollback();
                    return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
                }
            }

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
