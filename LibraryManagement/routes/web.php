<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginadmin',[AdminController::class,'loginadmin'])->name('loginadmin');
Route::post('/login_admin_success',[AdminController::class,'login_admin_success'])->name('login_admin_success');
Route::get('/otp_verification/{email}',[AdminController::class,'otp_verification'])->name('otp_verification');
Route::post('verify_otp_success',[AdminController::class,'verify_otp_success'])->name('verify_otp_success');

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/manage_books',[AdminController::class,'manage_books'])->name('manage_books');
});