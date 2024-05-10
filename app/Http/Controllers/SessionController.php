<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function store(Request $request)
    {
        $atributos = $request->validate([
            "username" => "required",
            "password" => "required"
        ]);
        if (Auth::attempt($atributos)) {
            return redirect("/")->with("login_success", "Login successful.");
        }
        return redirect("login")->with("login_error", "Incorrect credentials.");
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
