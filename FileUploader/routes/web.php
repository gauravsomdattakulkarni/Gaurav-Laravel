<?php

use App\Http\Controllers\BucketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BucketController::class, 'images'])->name('images');
Route::post('/upload_images_success', [BucketController::class, 'upload_images_success'])->name('upload_images_success');
Route::delete('/delete_image', [BucketController::class, 'delete_image'])->name('delete_image');