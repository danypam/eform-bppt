<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kabupaten\Tasikmalaya\Cas\Facades\Cas;
use Illuminate\Support\Facades\Auth;

class CasController extends Controller
{
    public function callback()
    {
        $id = Cas::user()->attributes['Email'][1];
//        dd($id);
        $user = User::where('email',$id)->first();
//        $id = Cas::user()->email;
        Auth::login($user);
//         dd($id);
        // Here you can store the returned information in a local User model on your database (or storage).

        // This is particularly usefull in case of profile construction with roles and other details
        // e.g. Auth::login($local_user);

        return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
    }
}
