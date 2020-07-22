<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\email_atasan;
use App\Pegawai;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UnitJabatan;
use phpDocumentor\Reflection\Types\Null_;
use mysql_xdevapi\Exception;
use Spatie\Permission\Models\Role;
use Throwable;
use App\User;
use App\Notifications\NewForm;
use App\Submission;
use function foo\func;

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
      //  dd($this->getEmail());
        $json_encode = json_decode($form->form_builder_json);
        foreach ($json_encode as $data){
           if($data->type == 'selectFromDatabase'){
               $label = "$data->lbl";
               $value = "$data->value";
              // dd($label);
               $result = DB::table($data->table)->get();
               foreach ($result as $r){
                   $values[] = [
                       'label' => $r->$label,
                       'value' => $r->$value
                   ];
               }
               //$data->type = 'select';
               $data->values = $values;
           }
        }
       // dd($json_encode);
        $form->form_builder_json = $json_encode;

        return view('formbuilder::render.index', compact('form', 'pageTitle'));
    }

    /**
     * Process the form submission
     *
     * @param Request $request
     * @param string $identifier
     * @return Response
     */

    function cek_jabatan(){
        //cek is_deputi, is_unit, is_kabppt
        $user_id = auth()->user()->id ?? null;
        $status = Pegawai::with('unit_jabatan')
            ->where('user_id','=',$user_id)
            ->whereHas('unit_jabatan', function ($q){
                $q->where('is_unit', '=', '1')
                    ->orWhere('is_kabppt', '=', '1')
                    ->orWhere('is_deputi','=', '1');
            })->first();
        return $status ? true : false;
    }
    public function submit(Request $request, $identifier)
    {
//        print_r($request->all());
        $form = Form::where('identifier', $identifier)->firstOrFail();
        DB::beginTransaction();
        try {
//            dd($request->all());
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
            $pegawai_id = Pegawai::all()->where('user_id','=',$user_id)->first()->id;
            $status = $this->cek_jabatan() ? config('constants.status.pending') : config('constants.status.new');

            $submission_id = $form->submissions()->create([
                'user_id' => $user_id,
                'pegawai_id' => $pegawai_id,
                'status' => $status,
                'content' => $input,
            ])->id;
            //===Notifikasi
            try {
                if($this->cek_jabatan()){
                    NotifikasiController::sent_atasan($submission_id);
                    EmailController::sent_atasan($submission_id);
                }else{
                    NotifikasiController::sent_kepala($submission_id);
                    EmailController::sent_kepala($submission_id);
                }
                LogActivity::addToLog('Submitted Form'.$form->name);
            }catch (Throwable $e){}
            DB::commit();
            return redirect('/my-submissions')->with('sukses', 'Terimakasih. Formulir Berhasil diajukan. Mohon Tunggu');
        } catch (Throwable $e) {
            DB::rollback();
            dd($e);
            return back()->withInput()->with('error', Helper::wtf())->with('error','');
        }
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
