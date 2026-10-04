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
    Route::get('/add_book',[AdminController::class,'add_book'])->name('add_book');
    Route::post('/add_book_success',[AdminController::class,'add_book_success'])->name('add_book_success');
    Route::delete('/delete_book_success',[AdminController::class,'delete_book_success'])->name('delete_book_success');
    Route::get('/edit_book/{book_id}',[AdminController::class,'edit_book'])->name('edit_book');
    Route::put('/update_book_success',[AdminController::class,'update_book_success'])->name('update_book_success');
    Route::get('/add_book_quantity',[AdminController::class,'add_book_quantity'])->name('add_book_quantity');
    Route::post('/add_book_quantity_success',[AdminController::class,'add_book_quantity_success'])->name('add_book_quantity_success');
    
});