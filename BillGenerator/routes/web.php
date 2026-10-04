<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PosAuthController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\PosBilling;


Route::get('/', [HomeController::class, 'home']);
Route::get('/pos_login', [PosAuthController::class, 'pos_login']);
Route::get('/pos_login_success', [PosAuthController::class, 'pos_login_success']);

//Route::middleware('pos_auth')->group(function () {
    Route::get('/pos_dashboard', [PosDashboardController::class, 'pos_dashboard']);

    Route::get('/pos_logout', function () {
        session()->flush();
        return redirect('/pos_login');
    });

    Route::get('/pos_biller', [PosBilling::class, 'pos_biller']);
    Route::post('/pos_get_product', [PosBilling::class, 'get_product']);
    Route::post('/pos_checkout', [PosBilling::class, 'checkout']);
    Route::get('/pos_print_bill/{bill_id}', [PosBilling::class, 'print_bill']);
//});

Route::get('/pos_scanner', [PosBilling::class, 'pos_scanner']);