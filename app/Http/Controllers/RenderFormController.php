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
use App\Pegawai;
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
                 $details = [
                    'title' => 'Fajar Agustian',
                    'body' => 'You have one form to approved. Please check this link '
                ];

                \Mail::to('fajar654@gmail.com')->send(new email_atasan($details));
        DB::beginTransaction();

        $users = User::whereHas('roles',function($q){
            $q->where('name','atasan');
        })->get();
        if (\Notification::send($users, new NewForm(Submission::latest('id')->first())))
        {
            return back();
        }


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
            ]);

            DB::commit();
           /* return redirect()
                    ->route('formbuilder::form.feedback', $identifier)
                    ->with('success', 'Form successfully submitted. Please wait');*/
            return redirect('/my-submissions    ')->with('sukses', 'Formulir Berhasil diajukan');
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());

        }

    }
    public function notification(){
        return auth()->user()->unreadNotifications;
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
