<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/user_login', [UserController::class, 'user_login'])->name('user_login');
Route::post('user_login_success',[UserController::class, 'user_login_success']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['web'])->group(function () {
    Route::get('user_dashboard',[UserController::class, 'user_dashboard'])->name('user_dashboard');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::get('/two_factor_auth/{username}', [UserController::class, 'two_factor_auth'])->name('two_factor_auth');
    Route::post('/two_Step_auth_verification', [UserController::class, 'two_Step_auth_verification'])->name('two_Step_auth_verification');
    Route::get('/manage_investment', [UserController::class, 'manage_investment'])->name('manage_investment');
    Route::post('/delete_investment_success', [UserController::class, 'delete_investment_success'])->name('delete_investment_success');
    Route::get('/add_investment', [UserController::class, 'add_investment'])->name('add_investment');
    Route::post('/add_investment_success', [UserController::class, 'add_investment_success'])->name('add_investment_success');
    Route::get('/edit_investment/{investment_id?}', [UserController::class, 'edit_investment'])->name('edit_investment');
    Route::post('/update_investment_details_success', [UserController::class, 'update_investment_details_success'])->name('update_investment_details_success');
    Route::get('/get_investment_more_details/{investment_id?}', [UserController::class, 'get_investment_more_details'])->name('get_investment_more_details');
    Route::post('/add_investment_premimum', [UserController::class, 'add_investment_premimum'])->name('add_investment_premimum');
    Route::post('/add_investment_document', [UserController::class, 'add_investment_document'])->name('add_investment_document');
    Route::get('/account_settings', [UserController::class, 'account_settings'])->name('account_settings');
    Route::post('/change_password_success', [UserController::class, 'change_password_success'])->name('change_password_success');
    Route::post('/change_two_factor_status', [UserController::class, 'change_two_factor_status'])->name('change_two_factor_status');
    Route::post('/regenerate_qr_code', [UserController::class, 'regenerate_qr_code'])->name('regenerate_qr_code');
});

