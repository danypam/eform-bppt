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
    public function index()
    {
        //create inbox table by join pegawai, unit_jabatan, and forms table
        function inbox_table(){
            return DB::table('form_submissions')
                ->join('pegawai as p','form_submissions.user_id','=','p.user_id')
                ->join('forms as f','form_submissions.form_id','=','f.id')
                ->join('unit_jabatan as uj', 'uj.id_unit_jabatan', '=', 'p.unit_jabatan_id')
                ->select('nama_lengkap','email','f.name','f.id as form_id','form_submissions.id as submission_id','form_submissions.status','form_submissions.created_at')
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
            $inboxs = inbox_table()->get();
            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
        //atasan langsung
        else if (auth()->user()->can('inbox-list-mengetahui')){

            function inboxs(){
                return inbox_table()
                    ->where(function ($q){
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
            //approved inbox (inbox yang telah di approve)
            $approved_inboxs = inboxs()->where('menyetujui','=', pegawai()->id)->get();
            //rejected inbox (inbox yang telah di reject)
            $rejected_inboxs = inboxs()->where('rejected','=',pegawai()->id)->get();
            return view('/inbox/index',compact('primary_inboxs','approved_inboxs','rejected_inboxs'));
        }
        //atasan langsung sekaligus     kepala
        else if(auth()->user()->can('inbox-list-menyetujui') && auth()->user()->can('inbox-list-mengetahui')){
            function inboxs($status1, $status2, $operator1, $operator2){

                return inbox_table()
                    ->where(function($q) use ($status1, $operator1) {
                        $q->where('form_submissions.status', $operator1, $status1)
                            ->where('uj.kode_unitatas1', '=', pegawai()->unit_jabatan_id)
                            ->orwhere('uj.kode_unitatas2', '=', pegawai()->unit_jabatan_id);
                    })
                    ->orWhere('form_submissions.status', $operator2, $status2);
            }


            return view('/inbox/index',['inboxs'=>$inboxs]);
        }
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
                    commit($id);
                    fillWhoApprove($id, "mengetahui", "mengetahui_at");
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
        $id_pegawai = DB::table('pegawai')
            ->select('id')
            ->where('user_id','=',Auth()->user()->id)
            ->first();

        DB::table('form_submissions')->where([
            'id'=>$id,
        ])->update([
            'status'=>-1,
            'rejected'=> $id_pegawai->id,
            'rejected_at'=> Carbon::now()->toDateTimeString()
        ]);

        return redirect('/inbox')->with('sukses','Formulir Berhasil Ditolak');
    }
}
