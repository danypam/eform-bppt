<?php


namespace App\Http\Controllers;


use App\Helpers\LogActivity;
use App\Jabatan;
use App\UnitJabatan;
use App\UnitKerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Pegawai;
// https://localhost/users

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:user-list');
        // $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        // $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:permission-delete', ['only' => ['delete']]);
    }

    public function profile($id)
    {
        $data = DB::table('log_activity')->limit(7)
            ->LeftJoin('users','users.id','=','log_activity.user_id')
            ->select('log_activity.*','users.name')
            ->orderBy('created_at','DESC')
            ->where('user_id',auth()->user()->id)
            ->get();

        $data_unitjab = UnitJabatan::all();
        $data_jabatan = Jabatan::all();
        $data_unit = UnitKerja::all();
        $peg = Pegawai::find($id);
        return view('profile',['data'=>$data,'peg'=>$peg,'data_unitjab'=>$data_unitjab,'data_jabatan'=>$data_jabatan,'data_unit'=>$data_unit]);
    }

    public function index(Request $request)
    {
        //User::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        $data = User::all();
        return view('users.index',compact('data'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['status'] = true;


        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $request->request->add(['user_id' => $user->id]);
        $request->request->add(['status' =>'AKTIF']);
        $request->request->add(['nama_lengkap'=>$user->name]);
        $request->request->add(['role'=>$user->getRoleNames()]);
        Pegawai::create($request->all());
        LogActivity::addToLog('User Was Created');

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));

        LogActivity::addToLog('User Was Updated');
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

//    public function delete($id)
//    {
//        User::find($id)->delete();
//        return redirect()->route('users.index')
//                        ->with('success','User deleted successfully');
//    }
    public function delete($id)
    {
        DB::table('users')->where([
            'id'=>$id,
            'status'=>true,
        ])->update([
            'status' => false,
        ]);
        LogActivity::addToLog('User Was Non Active');
        return redirect('/users')->with('sukses','Data berhasil dinonaktifkan');

    }
    public function deletee($id)
    {
        DB::table('users')->where([
            'id'=>$id,
            'status'=>false,
        ])->update([
            'status' => true,
        ]);
        DB::table('pegawai')->where([
           'user_id'=>$id,
        ])->update([
            'status'=>'AKTIF',
        ]);
        LogActivity::addToLog('User Was Active');
        return redirect('/users')->with('sukses','Data berhasil diaktifkan');

    }
}
