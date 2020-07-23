<?php

namespace App\Http\Controllers;

use App\Form;
use App\Helpers\LogActivity;

use App\Mail\email_rejected;
use App\Pegawai;
use App\Submission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Global_;
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
        $id_pegawai = Pegawai::get_id_pegawai(auth()->user()->id);

        $all = auth()->user()->can('inbox-list-all');
        $menyetujui = auth()->user()->can('inbox-list-menyetujui');
        $mengetahui = auth()->user()->can('inbox-list-mengetahui');
        //admin
        if($all){
            $primary_inboxs = $this->inbox()->get();
        }
        //atasan langsung sekaligus     kepala
        else if($menyetujui && $mengetahui){
            $primary_inboxs = $this->primary_inbox_kepala()->merge($this->primary_inbox_atasan($id_pegawai));
        }
        //atasan langsung
        else if ($mengetahui){
            $primary_inboxs = $this->primary_inbox_atasan($id_pegawai);
        }
        else if($menyetujui){
            $primary_inboxs = $this->primary_inbox_kepala();
        }

        $rejected_inboxs = $this->inbox()->where('rejected','=', $id_pegawai)->get();
        $approved_inboxs = $this->inbox()->where('mengetahui','=', $id_pegawai)
            ->orWhere('menyetujui','=', $id_pegawai)->get();

        return view('/inbox/index',compact('primary_inboxs','approved_inboxs','rejected_inboxs'));
    }

    function inbox(){
        return $inbox = Submission::with(['pegawai.unit_jabatan', 'form']);
    }

    function primary_inbox_kepala(){
        return $this->inbox()->where('status', '=', config('constants.status.pending'))->get();
    }

    function primary_inbox_atasan($id_pegawai){
        $unit_jabatan_id = Pegawai::find($id_pegawai)->unit_jabatan_id;
        return $this->inbox()->where('status', '=', config('constants.status.new'))
            ->whereHas('pegawai.unit_jabatan', function($q) use ($unit_jabatan_id){
            $q->where('kode_unitatas1', '=', $unit_jabatan_id)
                ->orWhere('kode_unitatas2', '=', $unit_jabatan_id);
        }) ->get();
    }

    public function show($id){
        dd($id);
        $inbox = Submission::with(['pegawai.unit_jabatan', 'form'])
            ->where('form_submissions.id', $id)->get();
        return view('/inbox/read',['inboxs'=>$inbox]);
    }

    function commit($id, $ket, $column, $column2){

        try {
            DB::beginTransaction();
            $id_pegawai = Pegawai::get_id_pegawai(auth()->user()->id);
            $kete = $ket;
            $commit = Submission::find($id);
            $commit->$column = $id_pegawai;
            $commit->$column2 = Carbon::now()->toDateTimeString();
            $commit->status = DB::raw('status + 1');
            $commit->keterangan = $kete;
            $commit->save();
            DB::commit();
        }catch (Throwable $e){
            DB::rollback();
            return redirect('/inbox')->with('error', 'Error');
        }
    }

    public function approve(Request $request){
        $can_menyetujui = auth()->user()->can('inbox-approve-menyetujui');
        $can_mengetahui = auth()->user()->can('inbox-approve-mengetahui');

        $isFilled = Submission::find($request->submission_id)->first();
        $empty_Menyetujui = (!isset($isFilled->menyetujui));
        $empty_Mengetahui = (!isset($isFilled->mengetahui));
//        dd($can_mengetahui);

            if ($can_menyetujui && $can_mengetahui && ($empty_Menyetujui || $empty_Mengetahui)) {
                if ($empty_Mengetahui) {
                    $this->commit($request->submission_id, $request->keterangan, "mengetahui", "mengetahui_at");
                }
                if ($empty_Menyetujui) {
                    $this->commit($request->submission_id, $request->keterangan, "menyetujui", "menyetujui_at");
                }
                try {
                    NotifikasiController::sent_pic($request->submission_id);
                    EmailController::sent_pic($request->submission_id);
                    LogActivity::addToLog('Form ' . $request->submission_id . ' Was Approved');
                } catch (Throwable $e) {
                }
                return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
            } else if ($can_menyetujui && $empty_Menyetujui) {
                $this->commit($request->submission_id, $request->keterangan, "menyetujui", "menyetujui_at");
                try {
                    NotifikasiController::sent_pic($request->submission_id);
                    EmailController::sent_pic($request->submission_id);
                    EmailController::sent_user($request->submission_id);
                    LogActivity::addToLog('Form ' . $request->submission_id . ' Was Approved');
                } catch (Throwable $e) {}
                return redirect('/inbox')->with('sukses', 'Formulir Berhasil DiSetujui');
            } else if ($can_mengetahui && $empty_Mengetahui) {
                $this->commit($request->submission_id, $request->keterangan, "mengetahui", "mengetahui_at");
                try {
                    NotifikasiController::sent_kepala($request->submission_id);
                    EmailController::sent_kepala($request->submission_id);
                    EmailController::sent_user($request->submission_id);
                    LogActivity::addToLog('Form ' . $request->submission_id . ' Was Approved');
                } catch (Throwable $e) {
                }
                return redirect('/inbox')->with('sukses', 'Form Berhasil DiSetujui');
            } else {
                dd('sini');
                return redirect('/inbox')->with('error', 'Formulir Error atau Telah Dieksekusi oleh user lain');
            }

    }

    public function update(Request $request)
    {
        $kete = json_encode($request->keterangan);
        $k = json_decode($kete)->ket;
        $id_pegawai = Pegawai::get_id_pegawai(auth()->user()->id);

        DB::table('form_submissions')->where([
            'id'=>$request->submission_id,
        ])->update([
            'status'=>-1,
            'keterangan'=>$kete,
            'rejected'=> $id_pegawai,
            'rejected_at'=> Carbon::now()->toDateTimeString()
        ]);
        $peg = Submission::with('pegawai')->find($request->submission_id);
        $emails = $peg->pegawai->email;
        $nama = Pegawai::find($id_pegawai)->nama_lengkap;
        $details = [
            'name' => $nama,
            'keterangan' => $k
        ];
        \Mail::to($emails)->send(new email_rejected($details));

        LogActivity::addToLog('Form '.$request->submission_id.' Was Rejected');
        return redirect('/inbox')->with('sukses','Formulir Berhasil Ditolak');
    }
}
