<?php

namespace App\Http\Controllers;

use App\Exports\PegawaiExport;
use App\Pegawai;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Models\Submission;

class ExportController extends Controller
{
    public function pegawai_excel()
    {
        return Excel::download(new PegawaiExport, 'pegawai.xlsx');
    }

    public function jenisform_excel()
    {
        return Excel::download(new PegawaiExport, 'pegawai.xlsx');
    }

    public function forms_pdf()
    {
        $pageTitle = "Forms";

        $forms = Form::getForUser(auth()->user());
        $pdf=PDF::loadview('vendor/formbuilder/forms/forms_pdf', compact('pageTitle', 'forms'))->setPaper('a4','landscape');
        /*return $pdf -> download('Data Pegawai');*/
        return $pdf->stream();
    }

    public function submission_pdf($id)
    {
        $user = auth()->user();
        $submission = Submission::where(['user_id' => $user->id, 'id' => $id])
            ->with('form')
            ->firstOrFail()
        ;
        $form_headers = $submission->form->getEntriesHeader();
        $pageTitle = "View Submission";
        $submission_data = DB::table('pegawai as p')
            ->Join('unit_kerja as uk','p.unit_id','=','uk.id')
            ->Join('form_submissions as fs','p.user_id','=','fs.user_id')
            ->select('p.nip','p.nip18','p.no_hp','uk.nama_unit')
            ->where(['fs.id' =>  $id])
            ->get()
        ;
        $pdf=PDF::loadview('formbuilder::my_submissions.submission_pdf', compact('submission', 'pageTitle', 'form_headers','submission_data'))->setPaper('a4','potrait');
        /*return $pdf -> download('Data Pegawai');*/
        return $pdf->stream();
    }

    public function task_pdf($form_id, $submission_id)
    {
           $submission = Submission::with('user', 'form')
            ->where([
                'form_id' => $form_id,
                'id' => $submission_id,
            ])
            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        $identitas = Pegawai::with('unit_jabatan')->where('user_id',$submission->user_id)->first();

        $pageTitle = "View Submission";

        $pdf=PDF::loadview('task.task_pdf' ,compact('pageTitle', 'submission', 'form_headers','identitas'))->setPaper('a4','potrait');

        return $pdf->stream();
    }
}
