<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Frontend\Auth\LoginController;
// use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

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
Route::group(['middleware' => ['guest']], function() {
    // Route::get('/', function () {return view('welcome');});
    Route::match(['GET','POST'],'/',[LoginController::class, 'register'])->name('frontend.register');
    Route::post('/login',[LoginController::class, 'login'])->name('frontend.login');

    Route::get('/email-verification/{token}',[LoginController::class, 'emailverification'])->name('frontend.emailverification');
});
Route::group(['middleware' => ['user']], function() {
    
    Route::match(['get','post'],'/profile',[ProfileController::class, 'profile'])->name('frontend.profile');
    Route::get('/logout',[ProfileController::class, 'logout'])->name('frontend.logout');
});
