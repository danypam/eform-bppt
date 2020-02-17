<?php

namespace App\Http\Controllers;

use App\Alamat;
use App\Helpers\LogActivity;
use App\Jabatan;
use App\UnitKerja;
use Illuminate\Http\Request;
use DB;

class UnitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:unit-list|unit-create|unit-edit|unit-delete', ['only' => ['index','store']]);
        $this->middleware('permission:unit-create', ['only' => ['create','store']]);
        $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data_jabatan = Jabatan::all();
        $data_alamat = Alamat::all();

        $data_unit = DB::table('unit_kerja')
            ->LeftJoin('jabatan','jabatan.id','=','unit_kerja.jabatan_id')
            ->LeftJoin('alamat','alamat.id','=','unit_kerja.alamat_id')
            ->select('unit_kerja.*','jabatan.nama_jabatan','alamat.alamat')

            ->get();
        return view('/unit.index',['data_unit'=>$data_unit,'data_jabatan'=>$data_jabatan,'data_alamat'=>$data_alamat]);
    }

    public function create(Request $request)
    {
        UnitKerja::create($request->all());
        LogActivity::addToLog('Unit Was Created');

        return redirect('/unit')->with('sukses','Data Berhasil Ditambah');
    }

    public function edit($id)
    {
        $data_lokasi = Alamat::all();
        $data_jabatan = Jabatan::all();
        $data_unit = UnitKerja::find($id);
        return view('/unit.edit',['data_unit'=>$data_unit,'data_jabatan'=>$data_jabatan,'data_lokasi'=>$data_lokasi]);
    }
    public function update(Request $request,$id)
    {
        $unit = UnitKerja::find($id);
        $unit->update($request->all());
        LogActivity::addToLog('Unit Was Updated');
        return redirect('/unit')->with('sukses','Data berhasil diupdate');
    }

    public function delete($id){

        $unit = UnitKerja::find($id);
        $unit->delete();
        LogActivity::addToLog('Unit Was Deleted');
        return redirect('/unit')->with('sukses','Data berhasil dihapus');
    }
}
