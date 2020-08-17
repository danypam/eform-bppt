<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Pegawai;
use App\Http\Controllers\Controller;
use jazmy\FormBuilder\Events\Form\FormCreated;
use jazmy\FormBuilder\Events\Form\FormDeleted;
use jazmy\FormBuilder\Events\Form\FormUpdated;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
//use App\Form;
use jazmy\FormBuilder\Requests\SaveFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Throwable;

class FormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:form-list|form-delete|form-create|form-edit', ['only' => ['edit','update','destroy','show','index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Forms";
        // $forms = Form::getForUser(auth()->user());
        $forms = Form::getForUser(auth()->user());
        return view('formbuilder::forms.index', compact('pageTitle', 'forms'));
    }

    public static function getNamePic($id){
        return DB::table('pegawai')
            ->select('nama_lengkap', 'nip')
            ->find($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Create New Form";
        $saveURL = route('formbuilder::forms.store');
        //get pegawai
        $pegawai = Pegawai::all();
        // get the roles to use to populate the make the 'Access' section of the form builder work
        $form_roles = Helper::getConfiguredRoles();
        return view('formbuilder::forms.create', compact('pageTitle', 'saveURL', 'form_roles', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  jazmy\FormBuilder\Requests\SaveFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {
        $user = $request->user();

        $input = $request->merge(['user_id' => $user->id])->except('_token');
        // dd($input);
        DB::beginTransaction();

        // generate a random identifier
        $input['identifier'] = $user->id.'-'.Helper::randomString(20);
        $created = Form::create($input);

        try {
            // dispatch the event
            event(new FormCreated($created));

            DB::commit();
            LogActivity::addToLog('Form '.$created->name.' Was Created');

            return response()
                    ->json([
                        'success' => true,
                        'details' => 'Form successfully created!',
                        'dest' => route('formbuilder::forms.index'),
                    ]);
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => 'Failed to create the form.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $form = Form::where(['id' => $id])
                    ->with('user')
                    ->withCount('submissions')
                    ->firstOrFail();

        $pageTitle = "Preview Form";

        return view('formbuilder::forms.show', compact('pageTitle', 'form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        //get pegawai
        $pegawai = Pegawai::all();

        $form = Form::where(['id' => $id])->firstOrFail();

        $pageTitle = 'Edit Form';

        $saveURL = route('formbuilder::forms.update', $form);

        // get the roles to use to populate the make the 'Access' section of the form builder work
        $form_roles = Helper::getConfiguredRoles();

        return view('formbuilder::forms.edit', compact('form', 'pageTitle', 'saveURL', 'form_roles', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  jazmy\FormBuilder\Requests\SaveFormRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveFormRequest $request, $id)
    {
        $user = auth()->user();
        $form = Form::where(['id' => $id])->firstOrFail();

        $input = $request->except('_token');

        if ($form->update($input)) {
            // dispatch the event
            event(new FormUpdated($form));
            LogActivity::addToLog('Form '.$form->name.' Was Updated');

            return response()
                    ->json([
                        'success' => true,
                        'details' => 'Form successfully updated!',
                        'dest' => route('formbuilder::forms.index'),
                    ]);
        } else {
            response()->json(['success' => false, 'details' => 'Failed to update the form.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $form = Form::where(['id' => $id])->firstOrFail();
        $form->delete();

        // dispatch the event
        event(new FormDeleted($form));
        LogActivity::addToLog('Form '.$form->name.' Was Deleted');

        return back()->with('success', "'{$form->name}' deleted.");
    }

    //get table for "select from database" field
        public function getTable(){
        $result = DB::table('information_schema.tables')->select('table_name')->where('table_schema','=',DB::connection()->getDatabaseName())->get();
        $result = json_encode($result, true);
        return $result;
    }

    public function getcolumn($tableName){
        $result = DB::getSchemaBuilder()->getColumnListing($tableName);
        $result = json_encode($result, true);
        return $result;
    }

}
