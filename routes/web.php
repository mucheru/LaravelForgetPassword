<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout');
});
Route::post('/login2',[ForgotPasswordController::class,'login'])->name('login');


Route::get('forget-password',[ForgotPasswordController::class,'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password',[ForgotPasswordController::class,'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password{token}',[ForgotPasswordController::class,'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
