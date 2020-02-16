<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','show']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['delete']]);
    }

    public function  index(Request $request)
    {

        $data_permis = Permission::all();
        return view('/permission.index',['data_permis'=>$data_permis]);
    }

    public function create(Request $request)
    {
        Permission::create($request->all());

        LogActivity::addToLog('Permission Was Created');
        return redirect('/permission')->with('sukses','Permission '.$request->name.' Berhasil Ditambah');
    }

    public function  edit($id)
    {
        $permis = Permission::find($id);
        return view('permission.edit',['permis'=>$permis]);
    }
    public function update(Request $request,$id)
    {
        $permis = Permission::find($id);
        $permis->update($request->all());
        LogActivity::addToLog('Permission Was Updated');
        return redirect('/permission')->with('sukses','Permission '.$request->name.' berhasil diupdate');
    }

    public function delete($id)
    {
        $permis = Permission::find($id);
        $permis->delete();
        LogActivity::addToLog('Permission Was Deleted');
        return redirect('/permission')->with('sukses','Permission '.$permis->name.' berhasil dihapus');
    }

}
