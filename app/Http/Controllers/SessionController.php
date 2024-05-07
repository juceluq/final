<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $atributos = $request->validate([
            "username" => "required",
            "password" => "required"
        ]);
        if (Auth::attempt($atributos)) {
            return redirect("login");
        }
        return redirect("login")->with("error", "Incorrect credentials.");
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
