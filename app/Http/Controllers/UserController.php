<?php

namespace App\Http\Controllers;

use App\Models\HariRayaIdulAdha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function getTanggalIduAdha(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        $tanggal = HariRayaIdulAdha::find($request->json('tahun'));

        return response()->json(['tanggal' => $tanggal->tanggal]);
    }

    public function viewUserRegister() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('form.register', ['title' => 'User Registration']);
    }

    public function viewUserLogin() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('form.login', ['title' => 'Login User']);
    }

    public function viewUserDashboard(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        $hewan_qurban = Auth::user()->pembelianQurban()->where('status', 'Sedang Angsuran')->first() ?? false;

        return view('dashboard', ['title' => Auth::user()->name . " | Dashboard", 'hewan_qurban' => $hewan_qurban]);
    }

    public function userRegisterHandling(Request $request) {
        $data = $request->validate([
            'nik' => 'required|numeric|digits:16',
            'name' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'telepon' => 'required|numeric|digits_between:11,15',
            'password' => ['required', 'confirmed', Password::min(4)]
        ]);

        $new_user = User::create($data);

        Auth::login($new_user);

        $request->session()->regenerate();

        return redirect()->intended('/user/dashboard');
    }

    public function userLoginHandling(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->intended('/user/dashboard');
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
