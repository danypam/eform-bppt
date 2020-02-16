<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Alamat;

class AlamatController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:alamat-list|alamat-create|alamat-edit|alamat-delete', ['only' => ['index','show']]);
        $this->middleware('permission:alamat-create', ['only' => ['create','store']]);
        $this->middleware('permission:alamat-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:alamat-delete', ['only' => ['delete']]);
    }

    public function index(){
        $data_alamat = Alamat::all();
        return view('/alamat.index',['data_alamat'=>$data_alamat]);
    }
    public function create(Request $request)
    {
        Alamat::create($request->all());
        LogActivity::addToLog('New Location Was Created');

        return redirect('/alamat')->with('sukses','Data Berhasil Ditambah');
    }
    public function edit($id)
    {
        $data_alamat = Alamat::find($id);
        return view('/alamat.edit',['data_alamat'=>$data_alamat]);
    }
    public function update(Request $request,$id)
    {
        $lok = Alamat::find($id);
        $lok->update($request->all());
        LogActivity::addToLog('Location Was Updated');
        return redirect('/alamat')->with('sukses','Data berhasil diupdate');
    }
    public function delete($id){

        $lok = Alamat::find($id);
        $lok->delete();
        LogActivity::addToLog('Location Was Deleted');
        return redirect('/alamat')->with('sukses','Data berhasil dihapus');
    }

}
