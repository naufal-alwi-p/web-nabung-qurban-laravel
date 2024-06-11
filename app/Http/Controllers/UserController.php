<?php

namespace App\Http\Controllers;

use App\Models\HariRayaIdulAdha;
use App\Models\HewanQurban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function viewHome() {
        $hewan_qurban = HewanQurban::all();
        $tanggal = HariRayaIdulAdha::find(Carbon::now()->year);

        $jumlah_angsuran_per_minggu = round(Carbon::now()->diffInWeeks($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN);
        $jumlah_angsuran_per_bulan = round(Carbon::now()->diffInMonths($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN);

        if ($jumlah_angsuran_per_minggu < 2) {
            $tanggal = HariRayaIdulAdha::find(Carbon::now()->year + 1);

            $jumlah_angsuran_per_minggu = round(Carbon::now()->diffInWeeks($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN);
        }

        if ($jumlah_angsuran_per_bulan < 2) {
            $tanggal = HariRayaIdulAdha::find(Carbon::now()->year + 1);

            $jumlah_angsuran_per_bulan = round(Carbon::now()->diffInMonths($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN);
        }

        $biaya_per_minggu = [];
        $biaya_per_bulan = [];

        foreach ($hewan_qurban as $hewan) {
            $biaya_per_minggu[$hewan->nama] = floor($hewan->harga / $jumlah_angsuran_per_minggu);

            $biaya_per_bulan[$hewan->nama] = floor($hewan->harga / $jumlah_angsuran_per_bulan);
        }

        $data = [
            'title' => 'Homepage',
            'per_minggu' => $biaya_per_minggu,
            'per_bulan' => $biaya_per_bulan,
            'jatuh_tempo' => Carbon::parse($tanggal->tanggal)->format('Y-m-d')
        ];

        return view('home', $data);
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

        $paksa_alihkan = false;

        if ($hewan_qurban) {
            $jatuh_tempo = Carbon::parse($hewan_qurban->jatuh_tempo);
    
            $jumlah_angsuran = Carbon::now()->diffInWeeks($jatuh_tempo);
    
    
            if ($jumlah_angsuran < 1) {
                $paksa_alihkan = true;
            }
        }

        return view('dashboard', ['title' => Auth::user()->name . " | Dashboard", 'hewan_qurban' => $hewan_qurban, 'paksa_alihkan' => $paksa_alihkan]);
    }

    public function viewDetailAkun() {
        if (!Auth::check()) {
            return redirect('/');
        }

        return view('detail', ['title' => Auth::user()->name . ' | Detail', 'user' => Auth::user()]);
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

    public function userUpdateHandling(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }
        $data = $request->validate([
            'name' => 'required|ascii',
            'email' => 'required|email:rfc,dns,spoof',
            'telepon' => 'required|numeric|digits_between:11,15',
            'password' => 'required|current_password'
        ]);

        $user = Auth::user();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->telepon = $data['telepon'];

        if ($user->save()) {
            $request->session()->flash('update', true);
        } else {
            $request->session()->flash('update', false);
        }

        return redirect('/user/detail');
    }

    public function userLogoutHandling(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
