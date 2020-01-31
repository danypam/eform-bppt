<?php

namespace App\Http\Controllers;

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
        $data = DB::table('activity_log')
            ->LeftJoin('users','users.id','=','activity_log.user_id')
            ->select('activity_log.*','users.name')
            ->orderBy('created_at','DESC')
            ->get();

        return view('/log.index',['data'=>$data]);
    }
    public function delete($id)
    {
        $a = Activity::find($id);
        $a->delete();
        return redirect('/log')->with('sukses','Data berhasil dihapus');
    }
}
