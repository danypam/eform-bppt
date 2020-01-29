<?php

namespace App\Http\Controllers;

use App\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:jabatan-list|jabatan-create|jabatan-edit|jabatan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:jabatan-create', ['only' => ['create','store']]);
        $this->middleware('permission:jabatan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jabatan-delete', ['only' => ['delete']]);
    }


    public function  index(Request $request)
    {

            $data_jabatan = Jabatan::all();

        return view('/jabatan.index',['data_jabatan'=>$data_jabatan]);
    }
//    public function getdatajabatan(){
//        $jabatan = \App\Jabatan::select('jabatan.*');
//        return \DataTables::eloquent($jabatan)
//            ->addColumn('aksi',function ($s){
//                return '<a href="#" class="btn btn-warning btn-sm ">Edit</a>';
//            })
//            ->rawColumns(['aksi'])
//            ->toJson();
//    }

    public function create(Request $request)
    {
        Jabatan::create($request->all());

        return redirect('/jabatan')->with('sukses','Data Berhasil Ditambah');
    }

    public function  edit($id)
    {
        $jabatan = Jabatan::find($id);
        return view('/jabatan.edit',['jabatan'=>$jabatan]);
    }
    public function update(Request $request,$id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->update($request->all());
        return redirect('/jabatan')->with('sukses','Data berhasil diupdate');
    }

    public function delete($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();
        return redirect('/jabatan')->with('sukses','Data berhasil dihapus');
    }
}
