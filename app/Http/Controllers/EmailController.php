<?php

namespace App\Http\Controllers;

use App\Mail\email_atasan;
use App\Mail\email_kepala;
use App\Mail\email_ongoing;
use App\Mail\email_pending;
use App\Mail\email_progress;
use App\Mail\email_rejected;
use App\Mail\email_complete;
use App\Mail\email_pic;
use App\Pegawai;
use App\Submission;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    //
    public static function sent_atasan($submission_id){
        $emails = self::get_email_atasan($submission_id);
        $form_id = Submission::find($submission_id)->form_id;
        $url = url('/forms/' . $form_id . '/submissions/' . $submission_id);
        $details = self::get_details($submission_id, $url);
        \Mail::to($emails)->send(new email_atasan($details));
    }


    public static function sent_pic($submission_id){
        $form_id = Submission::find($submission_id)->form_id;
        $url = url('/task/'.$form_id.'/submissions/'.$submission_id);
        $details = self::get_details($submission_id, $url);
        $email = self::get_email_pic($submission_id);
        \Mail::to($email)->send(new email_pic($details));
    }

    public static function sent_kepala($submission_id){
        $i = Submission::with(['pegawai.unit_jabatan', 'form'])->find($submission_id)->first();
        $emails = Pegawai::with('user')->whereHas('user.roles',function($q){$q->where('name','kepala');})->pluck('email');
        $url = url('/forms/'.$i->form_id.'/submissions/'.$submission_id);
        $details = self::get_details($submission_id, $url);
        \Mail::to($emails)->send(new email_kepala($details));
    }

    public static function sent_user($submission_id){


        $i = Submission::with(['pegawai.unit_jabatan', 'form'])->find($submission_id);
        $status = $i->status;
        $details = [
            'name' => $i->pegawai->nama_lengkap,
            'url'    => url('/my-submissions/'.$submission_id)
            
        ];
        if ($status == config('constants.status.pending')){
            \Mail::to($i->pegawai->email)->send(new email_pending($details));
        }else if ($status == config('constants.status.waitForPic')){
            \Mail::to($i->pegawai->email)->send(new email_ongoing($details));
        }else if ($status == config('constants.status.onGoing')){
            \Mail::to($i->pegawai->email)->send(new email_progress($details));
        }else if ($status == config('constants.status.completed')){
            \Mail::to($i->pegawai->email)->send(new email_complete($details));
        }else if ($status == config('constants.status.rejected')){
            \Mail::to($i->pegawai->email)->send(new email_rejected($details));
        }
    }

    static function get_details($submission_id, $url){
        $i = Submission::with(['pegawai.unit_jabatan', 'form'])->find($submission_id);
        return [
            'name' => $i->pegawai->nama_lengkap,
            'url'    => $url,
            'submission' => $i,
            'identitas' => Pegawai::with('unit_kerja', 'unit_jabatan')->find($i->pegawai_id)->firstOrFail(),
            'form_headers' => $i->form->getEntriesHeader(),
            'pageTitle' => "View Submission"
        ];
    }

    static function get_email_pic($submission_id){
        $pic = Submission::with('form')->find($submission_id)->form->pic;
        $pic = json_decode($pic);
        return Pegawai::find($pic)->pluck('email');
    }

    static function get_email_atasan($submission_id){
        $sub = Submission::with('pegawai.unit_jabatan')->find($submission_id);
        $unit_atas1 = $sub->pegawai->unit_jabatan->kode_unitatas1;
        $unit_atas2 = $sub->pegawai->unit_jabatan->kode_unitatas2;

         return Pegawai::where('unit_jabatan_id','=',$unit_atas1)
            ->orWhere('unit_jabatan_id','=',$unit_atas2)->pluck('email');
    }
}
