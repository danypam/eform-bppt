<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kabupaten\Tasikmalaya\Cas\Facades\Cas;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postlogin(Request $request)
    {
        $this->validate($request, User::$login_validation_rules);
        if (Auth::attempt($request->only('email','password','status'))){
            if(auth()->user()->status == true) {
//                LogActivity::addToLog('User Was Login');
                if ($request->password == '123456') {
                    return redirect('/dashboard')->with('warning', 'PLEASE CHANGE YOUR PASSWORD!!!!');
                }else{
                    return redirect('/dashboard');
                }
            }else{

                return redirect('/login')->with('error','Your Account is not Active! Please Contact (021) 757 91262');
            }
        }
        return redirect('/login')->with('error', 'Your Email or Password is Invalid');;
    }

    public function logout()
    {
//        LogActivity::addToLog('User Was Logout');
        Auth::logout();
        cas()->logout('', url('/'));
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
