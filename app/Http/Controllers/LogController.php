<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Illuminate\Http\Request;
use DB;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:log-list|log-delete', ['only' => ['index','show']]);
        $this->middleware('permission:log-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = DB::table('log_activity')
            ->LeftJoin('users','users.id','=','log_activity.user_id')
            ->select('log_activity.*','users.name')
            ->orderBy('created_at','DESC')
            ->get();

        return view('/log.index',['data'=>$data]);
    }
    public function delete($id)
    {
        $a = LogActivity::find($id);
        $a->delete();
        return redirect('/log')->with('sukses','Data berhasil dihapus');
    }
}
