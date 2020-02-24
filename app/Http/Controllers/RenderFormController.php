<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\email_atasan;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Throwable;
use App\User;
use App\Notifications\NewForm;
use jazmy\FormBuilder\Models\Submission;

class RenderFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('public-form-access');
    }

    /**
     * Render the form so a user can fill it
     *
     * @param string $identifier
     * @return Response
     */
    public function render($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();

        $pageTitle = "{$form->name}";

        return view('formbuilder::render.index', compact('form', 'pageTitle'));
    }

    /**
     * Process the form submission
     *
     * @param Request $request
     * @param string $identifier
     * @return Response
     */
    public function submit(Request $request, $identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        DB::beginTransaction();
        try {
            $input = $request->except('_token');

            // check if files were uploaded and process them
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                // store the file and set it's path to the value of the key holding it
                if ($file->isValid()) {
                    $input[$key] = $file->store('fb_uploads', 'public');

                }

            }

            $user_id = auth()->user()->id ?? null;
            $form->submissions()->create([
                'user_id' => $user_id,
                'status' => 0,
                'content' => $input,
            ])->id;

            $userid = $this->getAtasan();
//            $users = User::whereHas('roles',function($q){
//                $q->where('name','atasan');
//            })->get();

            if (isset($userid[0]))
            {
                try {
                    \Notification::send($userid[0], new NewForm(Submission::latest('id')->first()));
                }catch (Throwable $e){
                }
            }
            if (isset($userid[1]))
            {
                try {
                    \Notification::send($userid[1], new NewForm(Submission::latest('id')->first()));
                }catch (Throwable $e){
                }
            }
            LogActivity::addToLog('Submitted Form'.$form->name);

            $submission = Submission::where(['user_id' => $user_id, 'id' => $submission_id])->with('form')->firstOrFail();

            $details = [
                'name' => auth()->user()->name,
                'url'    => url('/inbox/'.$submission_id),
                'submission' => $submission,
                'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id', '=', auth()->user()->id)->firstOrFail(),
                'form_headers' => $submission->form->getEntriesHeader(),
                'pageTitle' => "View Submission"
            ];
            $email = $this->getEmail();
            //dd($email);
            if(isset($email[0])){
                \Mail::to($email[0])->send(new email_atasan($details));
            }
            if(isset($email[1])){
                \Mail::to($email[1])->send(new email_atasan($details));
            }
            DB::commit();
            return redirect('/my-submissions')->with('sukses', 'Formulir berhasil diajukan. Mohon ditunggu');
        } catch (Throwable $e) {
            dd($e);
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());
        }

    }

    private function getAtasan(){
        $unit_jabatan_user = DB::table('pegawai')
            ->select('unit_jabatan_id')
            ->where('user_id',auth()->user()->id)
            ->first();
        $id_unitatas = DB::table('unit_jabatan')
            ->join('pegawai','pegawai.unit_jabatan_id','=','unit_jabatan.id_unit_jabatan')
            ->select('kode_unitatas1','kode_unitatas2')
            ->where('id_unit_jabatan','=',$unit_jabatan_user->unit_jabatan_id)
            ->first();
        $id1 = DB::table('pegawai')
            ->where('unit_jabatan_id','=',$id_unitatas->kode_unitatas1)
            ->select('user_id','email')
            ->first();
        $id2 = DB::table('pegawai')
            ->where('unit_jabatan_id','=',$id_unitatas->kode_unitatas2)
            ->select('user_id','email')
            ->first();

        if(isset($id1)){
            $userid[] = User::find($id1->user_id);
        }
        if (isset($id2)){
            $userid[] = User::find($id2->user_id);
        }
//        $userid =$userid? $userid:0;
        return $userid;
    }

    private function getEmail(){
        $unit_jabatan_user=DB::table('pegawai')
            ->select('unit_jabatan_id')
            ->where('user_id',auth()->user()->id)
            ->first();
        $id_unitatas = DB::table('unit_jabatan')
            ->join('pegawai as p', 'p.unit_jabatan_id', '=', 'id_unit_jabatan')
            ->select('kode_unitatas1', 'kode_unitatas2')
            ->where('id_unit_jabatan', '=', $unit_jabatan_user->unit_jabatan_id )
            ->first();

        $email1=DB::table('pegawai')
            ->where('unit_jabatan_id','=',$id_unitatas->kode_unitatas1)
            ->select('email')
            ->first();

        $email2=DB::table('pegawai')
            ->where('unit_jabatan_id','=',$id_unitatas->kode_unitatas2)
            ->select('email')
            ->first();

        return $email[] = [$email1,$email2];
    }

    /**
     * Display a feedback page
     *
     * @param string $identifier
     * @return Response
     */
    public function feedback($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();

        $pageTitle = "Form Submitted!";

        return view('formbuilder::render.feedback', compact('form', 'pageTitle'));
    }
}
