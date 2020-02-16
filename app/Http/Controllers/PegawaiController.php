<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Jabatan;
use App\Pegawai;
use App\UnitJabatan;
use App\UnitKerja;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class PegawaiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pegawai-list|pegawai-create|pegawai-edit|pegawai-delete', ['only' => ['index','show']]);
        $this->middleware('permission:pegawai-create', ['only' => ['create','store']]);
        $this->middleware('permission:pegawai-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pegawai-delete', ['only' => ['delete']]);
    }
    public function index(Request $request)
    {
        $data_unitjab = UnitJabatan::all();
        $data_role = Role::all();
        $data_jabatan = Jabatan::all();
        $data_unit = UnitKerja::all();
        $pegawai = Pegawai::all();
        $data_pegawai = DB::table('pegawai as a')
            ->LeftJoin('jabatan','jabatan.id','=','a.jabatan_id')
            ->LeftJoin('unit_kerja','unit_kerja.id','=','a.unit_id')
            ->LeftJoin('unit_jabatan','unit_jabatan.id_unit_jabatan','a.unit_jabatan_id')
            ->LeftJoin('pegawai as b','b.id','=','a.nip_atas')
            ->select('a.id','a.nip','a.nip18','a.nama_lengkap','a.no_hp','a.email','a.status','b.jabatan_id as idjab as nama','b.nama_lengkap as nama_atas','b.unit_jabatan_id as unjab_atas','unit_kerja.nama_unit','jabatan.nama_jabatan','unit_jabatan.unit')
            ->where('a.status','AKTIF')
            ->get();
        return view('/pegawai.index',['pegawai'=>$pegawai,'data_unitjab'=>$data_unitjab,'data_pegawai'=>$data_pegawai,'data_jabatan'=>$data_jabatan,'data_unit'=>$data_unit,'data_role'=>$data_role]);

    }

    public function create(Request $request)
    {

        $user = new User;
        $user->assignRole($request->role);
        $user->name = $request->nama_lengkap;
        $user->email = $request->email;
        $user->password = bcrypt('123456');
        $user->status = true;
        $user->remember_token = str_shuffle(60);
        $user->save();

        $request->request->add(['user_id' => $user->id]);
        $request->request->add(['status' =>'AKTIF']);
        $pegawai = Pegawai::create($request->all());
        LogActivity::addToLog('Pegawai Was Created');
        return redirect('/pegawai')->with('sukses','Data berhasil ditambah');
    }

    public function profile($id)
    {
        $data_unitjab = UnitJabatan::all();
        $data_role = Role::all();
        $data_jabatan = Jabatan::all();
        $data_unit = UnitKerja::all();
        $data_pegawai = Pegawai::find($id);
        return view('/pegawai.profile',['data_pegawai'=>$data_pegawai,'data_unitjab'=>$data_unitjab,'data_jabatan'=>$data_jabatan,'data_unit'=>$data_unit]);
    }
    public function edit($id)
    {
        $data_peg = Pegawai::all();
        $data_jabatan = Jabatan::all();
        $data_unit = UnitKerja::all();
        $data_unjab = UnitJabatan::all();

        $pegawai = Pegawai::find($id);
        return view('/pegawai/edit',['data_peg'=>$data_peg,'data_unjab'=>$data_unjab,'pegawai'=>$pegawai,'data_jabatan'=>$data_jabatan,'data_unit'=>$data_unit]);
    }
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->update($request->all());
        if($request->hasFile('foto')){
            $request->file('foto')->move('images/',$request->file('foto')->getClientOriginalName());
            $pegawai->foto = $request->file('foto')->getClientOriginalName();
            $pegawai->save();
        }
        LogActivity::addToLog('Pegawai Was Updated');
        return redirect('/pegawai')->with('sukses','Data berhasil diubah');
    }
    public function delete($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->update(['status'=>'NON AKTIF']);
        $user = User::find($pegawai->user_id);
        $user->update(['status'=>false]);

        LogActivity::addToLog('Pegawai Was Deleted');
        return redirect('/pegawai   ')->with('sukses','Data Berhasil Dinonaktifkan');
    }
}
