<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postlogin(Request $request)
    {

        if (Auth::attempt($request->only('email','password','status'))){
            if(auth()->user()->status == true) {
                if ($request->password == '123456') {
                    return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
                }else{
                    return redirect('/dashboard');
                }
            }
        }
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function edit(Request $request)
    {
        return view('/auth.ubahpass');

    }
    public function update(Request  $request)
    {
        $newpass = $request->password_lama;
        $oldpass = auth()->user()->password;
        //        dd($oldpass, $newpass);
        if(Hash::check($newpass, $oldpass)){
            if($request->password_baru == $request->password_confirm){

                $user = auth()->user();
                $user->password = Hash::make($request->password_baru);
                $user->save();
                return redirect('/dashboard')->with('sukses','Password Matches and Allowed for New Password');
            }
            return redirect('/auth/ubahpass')->with('error','New Password Not Match with Confirm Password');

        }else{

            return redirect('/auth/ubahpass')->with('error','Old Password Not Match and Please Try Again');
        }


    }
}
