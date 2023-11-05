<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        // Validate the form data
        $credentials = $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);
        // Attempt to log the user in
        if(Auth::attempt($credentials))
        {
            return redirect()->route('dashboard');
        }

        // If unsuccessful, redirect back to the login with the from data
        return redirect()->back()->withInput($request->only('username'))->with('error', 'Wrong username or password, Try again!');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
