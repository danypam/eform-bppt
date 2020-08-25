<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Pegawai;
use Illuminate\Support\Carbon;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:inbox-list-mengetahui|inbox-list-menyetujui|inbox-list-all', ['only' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param integer $form_id
     * @return \Illuminate\Http\Response
     */
    public function index($form_id)
    {
        $user = auth()->user();

        $form = Form::where(['id' => $form_id])
                    ->with(['user'])
                    ->firstOrFail();

        $submissions = $form->submissions()
                            ->with('user')
                            ->latest()
                            ->paginate(100);

        // get the header for the entries in the form
        $form_headers = $form->getEntriesHeader();

        $pageTitle = "Submitted Entries for '{$form->name}'";

        return view(
            'formbuilder::submissions.index',
            compact('form', 'submissions', 'pageTitle', 'form_headers')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $form_id
     * @param integer $submission_id
     * @return \Illuminate\Http\Response
     */
    public function show($form_id, $submission_id)
    {

      $id_pegawai = Pegawai::get_id_pegawai(auth()->user()->id);
      $unjab = Pegawai::find($id_pegawai)->unit_jabatan_id;
      // dd($unjab);


      $all = auth()->user()->can('inbox-list-all');
      $menyetujui = auth()->user()->can('inbox-list-menyetujui');
      $mengetahui = auth()->user()->can('inbox-list-mengetahui');

      $submission = Submission::with(['user', 'form', 'pegawai.unit_jabatan'])
                          ->where([
                              'form_id' => $form_id,
                              'id' => $submission_id,
                          ])
                          ->firstOrFail();

        $atasan_form = ($submission->pegawai->unit_jabatan->kode_unitatas1 == $unjab || $submission->pegawai->unit_jabatan->kode_unitatas2 == $unjab);
        if(($menyetujui && $submission->status >= config('constants.status.pending')) ||
            ($mengetahui  && $atasan_form) ||
              $all){

                        $form_headers = $submission->form->getEntriesHeader();
                        $identitas = Pegawai::with('unit_kerja', 'unit_jabatan')->where('user_id',$submission->user_id)->first();
                        $pageTitle = "View Submission";
                        return view('formbuilder::submissions.show', compact('pageTitle', 'submission', 'form_headers','identitas'));
        }else{
          abort(404);
        }

    }

    public static function duration($start, $end){
        $t1 = Carbon::parse($start);
        $t2 = Carbon::parse($end);
        $diff = $t1->diff($t2);
        if($diff->d == 0){
            return ($diff->h . ' Jam ' . $diff->i . ' Menit');
        }else{
            return ($diff->d . ' Hari ' . $diff->h . ' Jam ' . $diff->i . ' Menit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $form_id
     * @param int $submission_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($form_id, $submission_id)
    {
        $submission = Submission::where(['form_id' => $form_id, 'id' => $submission_id])->firstOrFail();
        $submission->delete();

        return redirect()
                    ->route('formbuilder::forms.submissions.index', $form_id)
                    ->with('success', 'Submission successfully deleted.');
    }
}
