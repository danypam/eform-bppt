<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Mail\email_atasan;
use App\Mail\email_kepala;
use App\Mail\email_pic;
use App\Mail\email_rejected;
use App\Mail\email_progress;
use App\Notifications\NewForm;
use App\Pegawai;
use App\UnitJabatan;
use App\Submission;
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
        $this->middleware('permission:inbox=approve-all|inbox-approve-mengetahui|inbox-approve-menyetujui|inbox-approve-mengetahui-menyetujui', ['only' => ['edit','update']]);
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

            function inboxs(){
                return inbox_table()->where(function ($q){
                    $q->where('uj.kode_unitatas1', '=', pegawai()->unit_jabatan_id)
                        ->orwhere('uj.kode_unitatas2', '=', pegawai()->unit_jabatan_id);
                });
            }
            //primary inbox (inbox yang belum di approve)
            $primary_inboxs = inboxs()->where('form_submissions.status', '=', config('constants.status.new'))->get();
            //approved inbox (inbox yang telah di approve)
            $approved_inboxs = inboxs()->where('mengetahui','=', pegawai()->id)->get();
            //rejected inbox (inbox yang telah di reject)
            $rejected_inboxs = inboxs()->where('rejected','=',pegawai()->id)->get();
            return view('/inbox/index',compact('primary_inboxs', 'approved_inboxs','rejected_inboxs'));
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

        $inboxs = inbox_table($id)->get();
        return view('/inbox/read',['inboxs'=>$inboxs]);
    }

    public function approve($id)
    {

        $isFilled = DB::table('form_submissions')
            ->select('mengetahui', 'menyetujui', 'pic', 'status')
            ->where('id', '=', $id)
            ->first();

        function commit($id){
            //Search ID Pegawai
            return DB::table('form_submissions')->where([
                'id' => $id
            ])->update([
                'status' => DB::raw('status + 1')
            ]);
        }

        function fillWhoApprove($id_form_submission, $column, $column2){
            //get id pegawai
            $id_pegawai = DB::table('pegawai')
                ->select('id')
                ->where('user_id','=',Auth()->user()->id)
                ->first();

            return DB::table('form_submissions')->where([
                'id' => $id_form_submission
            ])->update([
                $column => $id_pegawai->id,
                $column2 => Carbon::now()->toDateTimeString()
            ]);
        }

        //approve all
        if(auth()->user()->can('inbox-approve-all')) {

            if(!isset($isFilled->mengetahui)
                || !isset($isFilled->menyetujui)
                || !isset($isFilled->pic)){
                return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
            }
            else{
                return redirect('/inbox')->with('error  ', 'Formulir Telah Dieksekusi oleh user lain');
            }
            //approve mengetahui sekaligus menyetujui
        }else if(auth()->user()->can('inbox-approve-menyetujui') && auth()->user()->can('inbox-approve-mengetahui')){
            DB::beginTransaction();
            try{
                if(!isset($isFilled->mengetahui)){
                    commit($id);
                    fillWhoApprove($id, "mengetahui", "mengetahui_at");
                }
                if(!isset($isFilled->menyetujui)){
                    commit($id);
                    fillWhoApprove($id, "menyetujui", "menyetujui_at");
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
                commit($id);

                fillWhoApprove($id, "menyetujui", "menyetujui_at");
                DB::commit();
                $users = User::whereHas('roles',function($q){
                    $q->where('name','pic');
                })->get();
                if (\Notification::send($users, new NewForm(Submission::find($id)->first())))
                {
                    return back();
                }

                $emails = $this->getEmailPIC($id);
                $submission = Submission::where('id', $id)->with('form')->firstOrFail();

                foreach ($emails as $email) {
                    $details = [
                        'name' => $email->nama_lengkap,
                        'url'    => url('/task/'.$id),
                        'submission' => $submission,
                        'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id', '=', $submission->user_id)->firstOrFail(),
                        'form_headers' => $submission->form->getEntriesHeader(),
                        'pageTitle' => "View Submission"
                    ];

                    \Mail::to($email->email)->send(new email_pic($details));
                }
                $emailtouser = $this->getEmailPegawai($id);
                $details = [
                    'name' => $emailtouser->nama_lengkap,
                    'url'    => url('/my-submissions/'.$id)
                ];
                \Mail::to($emailtouser->email)->send(new email_progress($details));

                LogActivity::addToLog('Form '.$id.' Was Approved');
                return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
            }else{
                DB::rollback();
                return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
            }
        }else if(auth()->user()->can('inbox-approve-mengetahui')) {
            DB::beginTransaction();
            if ((!$isFilled->mengetahui)) {
                commit($id);
                fillWhoApprove($id, "mengetahui", "mengetahui_at");
                DB::commit();
                $users = User::whereHas('roles',function($q){
                    $q->where('name','kepala');
                })->get();
                if (\Notification::send($users, new NewForm(Submission::find($id)->first())))
                {
                    return back();
                }
                $emails = $this->getEmailKepala();
                $submission = Submission::where('id', $id)->with('form')->firstOrFail();

                $details = [
                    'name' => $emails->nama_lengkap,
                    'url'    => url('/inbox/'.$id),
                    'submission' => $submission,
                    'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id', '=', $submission->user_id)->firstOrFail(),
                    'form_headers' => $submission->form->getEntriesHeader(),
                    'pageTitle' => "View Submission"
                ];
                \Mail::to($emails->email)->send(new email_kepala($details));

                LogActivity::addToLog('Form '.$id.' Was Approved');
                return redirect('/inbox')->with('sukses', 'Form Berhasil Disetujui');
            } else {
                DB::rollback();
                return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
            }
        }

    }

    public function reject($id)
    {

        $id_pegawai = DB::table('pegawai')
            ->select('id')
            ->where('user_id','=',Auth()->user()->id)
            ->first();
        DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>-1,
            'keterangan'=>$request->keterangan,
            'rejected'=> $id_pegawai->id,
            'rejected_at'=> Carbon::now()->toDateTimeString()
            /*        $sub = Submission::findOrFail($request->submission_id);
                    $sub->update([
                       'status'=>-1,
                       'keterangan'=>$request->keterangan,
            */
        ]);

        $emails = $this->getEmailRejected($request->submission_id, $request->keterangan);
        $details = [
            'name' => $emails->nama_lengkap,
            'keterangan' => $request->keterangan
        ];
        \Mail::to($emails->email)->send(new email_rejected($details));


        LogActivity::addToLog('Form '.$request->submission_id.' Was Rejected');
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
    private function getEmailKepala(){
        $emailkepala=DB::table('pegawai')
            ->where('role','=','kepala')
            ->select('email', 'nama_lengkap')
            ->first();
        return $emailkepala;
    }

    private function getEmailPIC($id){

        $submission=Submission::find($id);
        $pics = json_decode($submission->form->pic);
        $emails = array();
        foreach ($pics as $pic) {
            $pegawai = Pegawai::select('nama_lengkap','email')->where('id',$pic)->first();
            array_push($emails, $pegawai);
        }
        return $emails;
    }


    private function getEmailPegawai($id){
//        $formsub = DB::table('form_submissions')
////            ->select('user_id')
////            ->where('user_id','=',auth()->user()->id)
////            ->first();
////        $pegawai=DB::table('pegawai')
////            ->join('form_submissions as fs', 'fs.user_id', '=', 'pegawai.user_id')
////            ->select('email')
////            ->where('pegawai.user_id', '=', $formsub->user_id)
////            ->first();
////        return $pegawai->email;
        $submission=Submission::find($id);
        $user_id = $submission->user_id;
        $pegawai = Pegawai::select('nama_lengkap','email')->where('user_id',$user_id)->first();

        return $pegawai;
    }
    private function getEmailRejected($id, $ket){
        $submission=Submission::find($id);
        $user_id = $submission->user_id;
        $pegawai = Pegawai::select('nama_lengkap','email')->where('user_id',$user_id)->first();

        return $pegawai;
    }

}
