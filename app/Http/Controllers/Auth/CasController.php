<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kabupaten\Tasikmalaya\Cas\Facades\Cas;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\String_;

class CasController extends Controller
{
    public function callback()
    {
        try {
            $id = '';
//            dd(Cas::user()->attributes['Email']);
            if (gettype(Cas::user()->attributes['Email'] == 'string')) {
                $id = Cas::user()->attributes['Email'];
            }else{
                foreach (Cas::user()->attributes['Email'] as $email) {
                    if (fnmatch("*bppt.go.id", $email)) {
                        $id = $email;
                        dd($id);
                    }
                }
            }
            $user = User::where('email',$id)->first();

            if ($user){
                Auth::login($user);
            }else{
                return view('layouts/unregistered');
            }


        }catch (Exception $e){

        }

//         dd($id);
        // Here you can store the returned information in a local User model on your database (or storage).

        // This is particularly usefull in case of profile construction with roles and other details
        // e.g. Auth::login($local_user);

        return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
    }
}
