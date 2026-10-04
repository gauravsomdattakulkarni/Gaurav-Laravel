<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\QuizCategoryController;


Route::get('/loginadmin',[AdminController::class,'loginadmin'])->name('loginadmin');
Route::post('/login_admin_success',[AdminController::class,'login_admin_success'])->name('login_admin_success');
Route::get('/otp_verification/{email}',[AdminController::class,'otp_verification'])->name('otp_verification');
Route::post('verify_otp_success',[AdminController::class,'verify_otp_success'])->name('verify_otp_success');

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/manage_quiz',[QuizController::class,'manage_quiz'])->name('manage_quiz');
    Route::get('/add_quiz',[QuizController::class,'add_quiz'])->name('add_quizss');
    Route::post('/add_quiz_success',[QuizController::class,'add_quiz_success'])->name('add_quiz_success');
    Route::get("change_quiz_status/{quiz_id}",[QuizController::class,'change_quiz_status'])->name('add_quizss');
    Route::delete("delete_quiz_success",[QuizController::class,'delete_quiz_success'])->name('delete_quiz_success');
    Route::get("edit_quiz_details/{quiz_id}", [QuizController::class, "edit_quiz"])->name("edit_quiz");
    Route::post("update_quiz", [QuizController::class, "update_quiz"])->name("update_quiz");
    Route::get("manage_quiz_questions/{quiz_id}", [QuizQuestionController::class, "manage_quiz_questions"])->name("manage_qiuz_questions");
    Route::get("add_quiz_questions/{quiz_id}", [QuizQuestionController::class, "add_quiz_questions"])->name("add_quiz_questions");
    Route::post("add_quiz_question_success", [QuizQuestionController::class, "add_quiz_question_success"])->name("add_quiz_question_success");
    Route::delete("delete_quetion_success", [QuizQuestionController::class, "delete_quetion_success"])->name("delete_quetion_success");
    Route::get("edit_quiz_question/{question_id}", [QuizQuestionController::class, "edit_quiz_question"])->name("edit_quiz_question");
    Route::post("update_quiz_question", [QuizQuestionController::class, "update_quiz_question"])->name("update_quiz_question");
    Route::resource('quiz-categories', QuizCategoryController::class);
    Route::get('change_category_status/{id}', [QuizCategoryController::class, 'toggleStatus'])->name('quiz-categories.toggle-status');
    Route::post('add_quiz_category', [QuizCategoryController::class, 'store']);
    Route::put('update_quiz_category/{id}', [QuizCategoryController::class, 'update']);
    Route::delete('delete_quiz_category/{id}', [QuizCategoryController::class, 'destroy']);
});

Route::get('/user_authentication', [UserAuthController::class, 'user_authentication']);
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::get('/account_verification/{user_id}', [UserAuthController::class, 'account_verification']);

Route::get('/', [HomeController::class,'home'])->name('home');
Route::get('/quizes', [QuizController::class, 'quizes'])->name('quizes');
