<?php

namespace App\Http\Controllers;

use App\Models\HariRayaIdulAdha;
use App\Models\HewanQurban;
use App\Models\PembelianQurban;
use App\Models\RiwayatPembayaran;
use App\TipeAngsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function viewPendaftaranQurban() {
        if (!Auth::check()) {
            return redirect('/');
        } else if (Auth::user()->pembelianQurban()->where('status', 'Sedang Angsuran')->count() === 1) {
            return redirect('/user/dashboard');
        }

        $jatuh_tempo = HariRayaIdulAdha::find(Carbon::now()->year);

        $data = [
            'title' => 'Form Pendaftaran Qurban',
            'hewan_qurban' => HewanQurban::all(),
            'jatuh_tempo' => $jatuh_tempo->tanggal,
        ];

        return view('form.daftarQurban', $data);
    }

    public function viewPaymentPage() {
        if (!Auth::check()) {
            return redirect('/');
        }

        $hewan_qurban = Auth::user()->pembelianQurban()->where('status', 'Sedang Angsuran')->first() ?? false;

        if ($hewan_qurban) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $biaya = $hewan_qurban->sisa_angsuran == 1 ? $hewan_qurban->hewanQurban->harga - $hewan_qurban->total_uang : $hewan_qurban->biaya_per_periode;

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $biaya,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->telepon,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $data = [
                'title' => 'Pembayaran',
                'hewan_qurban' => $hewan_qurban,
                'snap_token' => $snapToken,
                'client_key' => env('MIDTRANS_CLIENT_KEY')
            ];

            return view('payment', $data);
        } else {
            return redirect('/user/dashboard');
        }
    }

    public function paymentNotificationHandling(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        if ($request->json('fraud_status') === 'accept' && ($request->json('transaction_status') === 'capture' || $request->json('transaction_status') === 'settlement')) {
            $bayar = $request->json('gross_amount');

            $hewan_qurban = Auth::user()->pembelianQurban()->where('id', $request->json('id_qurban'))->first() ?? false;

            if ($hewan_qurban) {
                $riwayat_bayar = new RiwayatPembayaran([
                    'waktu' => $request->json('transaction_time'),
                    'biaya' => $bayar
                ]);

                $hewan_qurban->total_uang += $bayar;
                $hewan_qurban->sisa_angsuran -= 1;

                if ($hewan_qurban->sisa_angsuran === 0) {
                    $hewan_qurban->status = "Berhasil";
                }

                if ($hewan_qurban->save() && $hewan_qurban->riwayatPembayaran()->save($riwayat_bayar)) {
                    $request->session()->flash('status', true);

                    return response()->json(['result' => true]);
                } else {
                    return response()->json(['result' => false]);
                }
            } else {
                return redirect('/user/dashboard')->with('status', false);
            }
        } else {
            return redirect('/user/dashboard')->with('status', false);
        }
    }

    public function getHargaHewan(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }

        $hewan = HewanQurban::find($request->integer('id'));

        $jumlah_angsuran = $request->json('metode') === 'per Minggu' ?
            round(Carbon::now()->diffInWeeks($request->json('tanggal')), mode: PHP_ROUND_HALF_DOWN) :
            round(Carbon::now()->diffInMonths($request->json('tanggal')), mode: PHP_ROUND_HALF_DOWN);

        $checkbox = false;

        if ($jumlah_angsuran < 2) {
            $checkbox = true;

            $tanggal = HariRayaIdulAdha::find(Carbon::now()->year + 1);

            $jumlah_angsuran = $request->json('metode') === 'per Minggu' ?
                round(Carbon::now()->diffInWeeks($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN) :
                round(Carbon::now()->diffInMonths($tanggal->tanggal), mode: PHP_ROUND_HALF_DOWN);
        }

        $biaya_per_angsuran = $hewan->harga / $jumlah_angsuran;

        $data = [
            'harga_readable' => explode(',', Number::currency($hewan->harga, 'IDR', 'id'))[0],
            'jumlah_angsuran' => $jumlah_angsuran,
            'biaya_per_angsuran' => floor($biaya_per_angsuran),
            'biaya_per_angsuran_r' => explode(',', Number::currency($biaya_per_angsuran, 'IDR', 'id'))[0],
            'checkbox' => $checkbox
        ];

        return response()->json($data);
    }

    public function pembayaranQurbanHandling(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        } else if (Auth::user()->pembelianQurban()->where('status', 'Sedang Angsuran')->count() === 1) {
            return redirect('/user/dashboard');
        }

        $data = $request->validate([
            'tipe_angsuran' => ['required', Rule::enum(TipeAngsuran::class)],
            'jatuh_tempo' => ['required', 'date', 'after:today'],
            'hewan_qurban_id' => ['required', 'exists:hewan_qurban,id'],
            'biaya_per_periode' => ['required', 'integer', 'numeric'],
            'sisa_angsuran' => ['required', 'integer', 'numeric']
        ]);

        $data['user_nik'] = Auth::user()->nik;
        $data['total_uang'] = 0;
        $data['status'] = "Sedang Angsuran";

        PembelianQurban::create($data);

        return redirect()->intended('/user/dashboard');
    }

    public function qurbanDialihkanTahunDepan(Request $request) {
        if (Auth::check()) {
            $hewan_qurban = Auth::user()->pembelianQurban()->where('id', $request->integer('id'))->first() ?? false;
    
            if ($hewan_qurban) {
                $hari_raya = HariRayaIdulAdha::find(Carbon::parse($hewan_qurban->jatuh_tempo)->year + 1);
                $hewan_qurban->jatuh_tempo = $hari_raya->tanggal;
                Auth::user()->pembelianQurban()->save($hewan_qurban);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    public function qurbanRefund(Request $request) {
        if (Auth::check()) {
            $hewan_qurban = Auth::user()->pembelianQurban()->where('id', $request->integer('id'))->first() ?? false;
    
            if ($hewan_qurban) {
                $hewan_qurban->status = "Refund";
                Auth::user()->pembelianQurban()->save($hewan_qurban);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    public function paymentHistory() {
        if (!Auth::check()) {
            return redirect('/');
        }
// dd(Auth::user()->pembelianQurban->count());
        return view('paymentHistory', ['title' => Auth::user()->name . ' | Riwayat Pembayaran', 'allHewanQurban' => Auth::user()->pembelianQurban]);
    }

    public function riwayatQurban() {
        if (!Auth::check()) {
            return redirect('/');
        }

        return view('riwayatQurban', ['title' => Auth::user()->name . ' | Riwayat Qurban', 'allHewanQurban' => Auth::user()->pembelianQurban]);
    }
}
