<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function viewUserRegister() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('form.register');
    }

    public function viewUserLogin() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('form.login');
    }

    public function userLoginHandling(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'login' => 'Gagal login'
        ]);
    }

    public function userLogoutHandling(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
