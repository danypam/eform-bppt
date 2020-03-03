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
            foreach (Cas::user()->attributes['Email'] as $email){
                if (fnmatch("*bppt.go.id",$email)){
                    $id = $email;
                }
            }
            $user = User::where('email',$id)->first();
            dd($email);
            Auth::login($user);
        }catch (Exception $e){

        }

//         dd($id);
        // Here you can store the returned information in a local User model on your database (or storage).

        // This is particularly usefull in case of profile construction with roles and other details
        // e.g. Auth::login($local_user);

        return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
    }
}
