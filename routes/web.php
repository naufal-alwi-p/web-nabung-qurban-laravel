<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/register', [UserController::class, 'viewUserRegister']);

Route::get('/user/login', [UserController::class, 'viewUserLogin']);
Route::post('/user/login', [UserController::class, 'userLoginHandling']);

Route::post('/user/logout', [UserController::class, 'userLogoutHandling']);
