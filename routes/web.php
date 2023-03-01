<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', [TestController::class, 'index'])->name('index');
Route::get('/', function () {return view('welcome');});
Route::get('/login', function () {return view('login');});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {return view('register');});
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', function () {return view('forgotpassword');});
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password', function () {return view('resetpassword');});
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::get('/change-password', function () {return view('changepassword');});
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
Route::get('/create-news', function () {return view('createnews');});
Route::get('/detail-news', function () {return view('detailnews');});
Route::put('/update-news', function () {return view('updatenews');});
Route::get('/verify-email', function () {return view('token');});
Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify');






