<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Mail\email_atasan;
use App\Mail\email_kepala;
use App\Mail\email_pic;
use App\Mail\email_rejected;
use App\Mail\email_progress;
use App\Mail\email_pending;
use App\Notifications\NewForm;
use App\Pegawai;
use App\UnitJabatan;
use App\Submission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;
use Carbon\Carbon;
use function foo\func;

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
        $this->middleware('permission:inbox-approve-all|inbox-approve-mengetahui|inbox-approve-menyetujui', ['only' => ['edit','update']]);
    }
    public function index(){
        //create inbox table by join pegawai, unit_jabatan, and forms table
        function inbox_table(){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->select('nama_lengkap','keterangan','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
                ->orderBy('created_at', 'desc');
        }
        //get data pegawai
        function pegawai(){
            return DB::table('pegawai')
                ->where('user_id',auth()->user()->id)
                ->first();
        }
        //admin
        if(auth()->user()->can('inbox-list-all')){
            $primary_inboxs = inbox_table()->get();
            $approved_inboxs = inbox_table()
                ->where('mengetahui','=', pegawai()->id)
                ->orWhere('menyetujui','=', pegawai()->id)->get();
            $rejected_inboxs = inbox_table()->where('rejected','=', pegawai()->id)->get();
            return view('/inbox/index',compact('primary_inboxs','approved_inboxs','rejected_inboxs'));
        }
        //atasan langsung sekaligus     kepala
        else if(auth()->user()->can('inbox-list-menyetujui') && auth()->user()->can('inbox-list-mengetahui')){
            function inboxs($operator1, $status1, $operator2, $status2){
                return inbox_table()
                    ->where(function($q) use ($status1, $operator1) {
                        $q->where('form_submissions.status', $operator1, $status1)
                            ->where('uj.kode_unitatas1', '=', pegawai()->unit_jabatan_id)
                            ->orwhere('uj.kode_unitatas2', '=', pegawai()->unit_jabatan_id);
                    })
                    ->orWhere('form_submissions.status', $operator2, $status2);
            }
            /* inboxs($status1, $status2, $operator1, $operator2)
             * function dibuat untuk menyeseuaikan dengan kasus yang berbeda
             * param:
             * $status1()
             * $status2()
             * operator1()
             * operator2()
             * */

            $primary_inboxs = inboxs("=", config('constants.status.pending'), "=", config('constants.status.waitForPic'))->get();

            $approved_inboxs = inboxs("LIKE", "%", "LIKE", "%")
                ->where('menyetujui','=', pegawai()->id)
                ->orWhere('mengetahui','=', pegawai()->id)
                ->get();

            $rejected_inboxs = inboxs("=", config('constants.status.rejected'), "=", config('constants.status.rejected'))
                ->where('menyetujui','=', pegawai()->id)
                ->orWhere('mengetahui','=', pegawai()->id)
                ->get();

            return view('/inbox/index',compact('primary_inboxs', 'approved_inboxs', 'rejected_inboxs'));
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
            function inboxs(){
                return inbox_table();
            }
            //primary inbox (inbox yang belum di approve)
            $primary_inboxs = inboxs()->where('form_submissions.status', '=', config('constants.status.pending'))->get();
//            foreach ($primary_inboxs as $sub){
//                $sub->keterangan = json_decode($sub->keterangan);
//            }
//            dd($primary_inboxs);
            //approved inbox (inbox yang telah di approve)
            $approved_inboxs = inboxs()->where('menyetujui','=', pegawai()->id)->get();
            //rejected inbox (inbox yang telah di reject)
            $rejected_inboxs = inboxs()->where('rejected','=',pegawai()->id)->get();
            return view('/inbox/index',compact('primary_inboxs','approved_inboxs','rejected_inboxs'));
        }
    }

    public function show($id)
    {
        function inbox_table($id){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->select('nama_lengkap','keterangan','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at', 'form_submissions.keterangan')
                ->where('form_submissions.id', $id);
        }
        $inboxs = inbox_table($id)->get();
        return view('/inbox/read',['inboxs'=>$inboxs]);
    }

    public function approve(Request $request)
    {
        $isFilled = DB::table('form_submissions')
            ->select('mengetahui', 'menyetujui', 'pic', 'status')
            ->where('id', '=', $request->submission_id)
        ->first();

        function commit($id, $ket){
        //Search ID Pegawai
            $kete = json_encode($ket);

            return DB::table('form_submissions')->where([
                'id' => $id
            ])->update([
                'status' => DB::raw('status + 1'),
                'keterangan'=>$kete
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
                        commit($request->submission_id, $request->keterangan);
                        fillWhoApprove($request->submission_id, "mengetahui", "mengetahui_at");
                    }
                    if(!isset($isFilled->menyetujui)){

                       commit($request->submission_id, $request->keterangan);
                        fillWhoApprove($request->submission_id, "menyetujui", "menyetujui_at");
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
                     commit($request->submission_id, $request->keterangan);
                     fillWhoApprove($request->submission_id, "menyetujui", "menyetujui_at");
                     DB::commit();
                    $users = User::whereHas('roles',function($q){
                        $q->where('name','pic');
                    })->get();
                    if (\Notification::send($users, new NewForm(Submission::find($request->submission_id)->first())))
                    {
                        return back();
                    }

                    //email ke kepala
                    $emails = $this->getEmailPIC($request->submission_id);
                $submission = Submission::where('id', $request->submission_id)->with('form')->firstOrFail();

                foreach ($emails as $email) {
                    $details = [
                        'name' => $email->nama_lengkap,
                        'url'    => url('/task/'.$request->submission_id),
                        'submission' => $submission,
                        'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id', '=', $submission->user_id)->firstOrFail(),
                        'form_headers' => $submission->form->getEntriesHeader(),
                        'pageTitle' => "View Submission"
                    ];

                    \Mail::to($email->email)->send(new email_pic($details));
                }
                //email ke pemohon
                $emailtouser = $this->getEmailPegawai($request->submission_id);
                $details = [
                    'name' => $emailtouser->nama_lengkap,
                    'url'    => url('/my-submissions/'.$request->submission_id)
                ];
                \Mail::to($emailtouser->email)->send(new email_progress($details));

                    LogActivity::addToLog('Form '.$request->submission_id.' Was Approved');
                    return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
                }else{
                    DB::rollback();
                    return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
                }
            }else if(auth()->user()->can('inbox-approve-mengetahui')) {
                DB::beginTransaction();
                if ((!$isFilled->mengetahui)) {
                    commit($request->submission_id, $request->keterangan);
                    fillWhoApprove($request->submission_id, "mengetahui", "mengetahui_at");
                    DB::commit();
                    $users = User::whereHas('roles',function($q){
                        $q->where('name','kepala');
                    })->get();
                    if (\Notification::send($users, new NewForm(Submission::find($request->submission_id)->first())))
                    {
                        return back();
                    }

                    //email ke atasan
                    $emails = $this->getEmailKepala();
                    $submission = Submission::where('id', $request->submission_id)->with('form')->firstOrFail();

                    $details = [
                        'name' => $emails->nama_lengkap,
                        'url'    => url('/inbox/'.$request->submission_id),
                        'submission' => $submission,
                        'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id', '=', $submission->user_id)->firstOrFail(),
                        'form_headers' => $submission->form->getEntriesHeader(),
                        'pageTitle' => "View Submission"
                    ];
                    \Mail::to($emails->email)->send(new email_kepala($details));

                    //email ke pemohon
                    $emailtouser = $this->getEmailPegawai($request->submission_id);
                    $details = [
                        'name' => $emailtouser->nama_lengkap,
                        'url'    => url('/my-submissions/'.$request->submission_id)
                    ];
                    \Mail::to($emailtouser->email)->send(new email_pending($details));


                    LogActivity::addToLog('Form '.$request->submission_id.' Was Approved');
                    return redirect('/inbox')->with('sukses', 'Form Berhasil DiSetujui');
                } else {
                    DB::rollback();
                    return redirect('/inbox')->with('error', 'Formulir Telah Dieksekusi oleh user lain');
                }

        }

    }

    public function update(Request $request)
    {
        $kete = json_encode($request->keterangan);
        $id_pegawai = DB::table('pegawai')
            ->select('id')
            ->where('user_id','=',Auth()->user()->id)
            ->first();

        DB::table('form_submissions')->where([
            'id'=>$request->submission_id,
        ])->update([
            'status'=>-1,
            'keterangan'=>$kete,
            'rejected'=> $id_pegawai->id,
            'rejected_at'=> Carbon::now()->toDateTimeString()

/*        $sub = Submission::findOrFail($request->submission_id);
        $sub->update([
           'status'=>-1,
           'keterangan'=>$request->keterangan,
*/
        ]);
        //email rejected
        $emails = $this->getEmailRejected($request->submission_id, $request->keterangan);

        $details = [
            'name' => $emails->nama_lengkap,
            'keterangan' => $kete
        ];
        \Mail::to($emails->email)->send(new email_rejected($details));

        LogActivity::addToLog('Form '.$request->submission_id.' Was Rejected');
        return redirect('/inbox')->with('sukses','Formulir Berhasil Ditolak');
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
