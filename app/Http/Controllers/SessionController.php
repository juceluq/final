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
            if (str_contains(back()->getTargetUrl(), "/login")) {
                return redirect('/')->with('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Login successful.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Login successful.'
                ]);
            }
        }
        return back()->with('alert', [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'Incorrect credentials.'
        ]);;
    }

    public function destroy()
    {
        Auth::logout();
        return back();
    }
}
