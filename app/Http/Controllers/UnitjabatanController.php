<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\UnitJabatan;
use Illuminate\Http\Request;
use DB;

class UnitjabatanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:unitjab-list|unitjab-create|unitjab-edit|unitjab-delete', ['only' => ['index','show']]);
        $this->middleware('permission:unitjab-create', ['only' => ['create','store']]);
        $this->middleware('permission:unitjab-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:unitjab-delete', ['only' => ['delete']]);
    }

    public function index(){
        $data_unitjab1 = UnitJabatan::all();

        $data_unitjab = DB::table('unit_jabatan as a')
            ->join('unit_jabatan as b','b.id_unit_jabatan','=','a.kode_unitatas1')
            ->join('unit_jabatan as c','c.id_unit_jabatan','=','a.kode_unitatas2')
            ->select('a.kategori','a.id_unit_jabatan','a.unit as unit_jabatan','a.singkat','b.unit as unit_atas1','c.unit as unit_atas2')
            ->orderBy('a.id_unit_jabatan','asc')
            ->get();
//
        return view('/unitjab.index',['data_unitjab'=>$data_unitjab,'data_unitjab1'=>$data_unitjab1]);
//
    }
    public function create(Request $request){
        UnitJabatan::create($request->all());
        LogActivity::addToLog('Unit Jabatan Was Created');
        return redirect('/unitjab')->with('sukses','Data Berhasil Ditambah');
    }
    public function edit($id)
    {
        $data_unitjab = UnitJabatan::find($id);
        $data_unitjab1 = UnitJabatan::all();

        return view('/unitjab.edit',['data_unitjab'=>$data_unitjab,'data_unitjab1'=>$data_unitjab1]);
    }
    public function update(Request $request,$id)
    {
        $data_unitjab = UnitJabatan::find($id);
        $data_unitjab->update($request->all());
        LogActivity::addToLog('Unit Jabatan Was Updated');
        return redirect('/unitjab')->with('sukses','Data berhasil diupdate');
    }
    public function delete($id){

        $data_unitjab = UnitJabatan::find($id);
        $data_unitjab->delete();
        LogActivity::addToLog('Unit Jabatan Was Deleted');
        return redirect('/unitjab')->with('sukses','Data berhasil dihapus');
    }
}
