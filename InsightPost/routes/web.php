<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', [BlogsController::class, 'main_page']);
Route::get('/home/{page_no?}', [BlogsController::class, 'home']);
Route::get('/search_post', [BlogsController::class, 'search_post']);
Route::get('author_login', [BlogsController::class, 'author_login']);
Route::get('auth/google', [BlogsController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [BlogsController::class, 'handleGoogleCallback']);
Route::get('author_logout', [BlogsController::class, 'author_logout']);

Route::get('create_post', [BlogsController::class, 'create_post']);
Route::post('blog_post_upload', [BlogsController::class, 'blog_post_upload']);
Route::get('blog_post_details/{post_id}', [BlogsController::class, 'blog_post_details']);
Route::post('add_comment_success', [BlogsController::class, 'add_comment_success']);
Route::post('edit_user_comment', [BlogsController::class, 'edit_user_comment']);
Route::post('delete_comment_success', [BlogsController::class, 'delete_comment_success']);
Route::get('my_post/{page_no?}', [BlogsController::class, 'my_post']);
Route::get('edit_post/{post_id}', [BlogsController::class, 'edit_post']);
Route::post('blog_post_update', [BlogsController::class, 'blog_post_update']);
Route::post('delete_post_success', [BlogsController::class, 'delete_post_success']);
