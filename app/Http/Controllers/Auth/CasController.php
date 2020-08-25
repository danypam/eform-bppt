<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kabupaten\Tasikmalaya\Cas\Facades\Cas;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class CasController extends Controller
{
    public function callback()
    {
        try {
            $id = '';
            if(is_array(Cas::user()->attributes['Email'])){
                foreach (Cas::user()->attributes['Email'] as $email){
                    if (fnmatch("*bppt.go.id",$email)){
                        $id = $email;
                    }
                }
            }else{
                $id = Cas::user()->attributes['Email'];
            }
            //dd(Cas::user()->attributes['Email']);

            $user = User::where('email',$id)->first();
            if($user ==  null){
                return view('/layouts/unregistered');
            }
            Auth::login($user);
        }catch (Exception $e){
            return view('/layouts/unregistered');
        }

//         dd($id);
        // Here you can store the returned information in a local User model on your database (or storage).

        // This is particularly usefull in case of profile construction with roles and other details
        // e.g. Auth::login($local_user);

        return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
    }
}
