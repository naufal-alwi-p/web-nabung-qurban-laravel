<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Homepage']);
});

Route::get('/user/register', [UserController::class, 'viewUserRegister']);
Route::post('/user/register', [UserController::class, 'userRegisterHandling']);

Route::get('/user/login', [UserController::class, 'viewUserLogin']);
Route::post('/user/login', [UserController::class, 'userLoginHandling']);

Route::get('/user/dashboard', [UserController::class, 'viewUserDashboard']);

Route::post('/user/logout', [UserController::class, 'userLogoutHandling']);

Route::get('/user/daftar-qurban', [PaymentController::class, 'viewPendaftaranQurban']);
Route::post('/user/daftar-qurban', [PaymentController::class, 'pembayaranQurbanHandling']);

Route::post('/get/harga-hewan', [PaymentController::class, 'getHargaHewan']);
Route::post('/get/tanggal-idul-adha', [UserController::class, 'getTanggalIduAdha']);

Route::post('/payment/dialihkan', [PaymentController::class, 'qurbanDialihkanTahunDepan']);
Route::post('/payment/refund', [PaymentController::class, 'qurbanRefund']);
