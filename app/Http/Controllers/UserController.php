<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    public function login_page()
    {
        if(Auth::check())return redirect(route("work.index"));
        return view("user.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);

        $credentials = $request->only("username", "password");
        // return Hash::make("12345");
        if(Auth::attempt($credentials))
        {
            return redirect()->intended(route("work.index"));
        }

        return redirect(route("user.login_page"))->with("err", "Invalid Credentials");
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route("user.login_page"));
    }
}
