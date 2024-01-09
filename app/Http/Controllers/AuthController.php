<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
   {
    // dd(Hash::make(1234));
    return view('auth.login');
   }

   public function AuthLogin(Request $request)
   {

       $remember = !empty($request->remember) ? true : false;
       if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember))
       {
               return redirect('dashboard');
       }
           
       else
       {
           return redirect()->back()->with('error', 'Incorrect Email or Password');
       }
   }

   public function logout()
   {
       Auth::logout();
       return redirect(url(''));
   }

}
