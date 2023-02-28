<?php

use App\Http\Controllers\TestController;
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

Route::get('/', [TestController::class, 'index'])->name('index');
// Route::get('/', function () {return view('welcome');});
Route::get('/login', function () {return view('login');});
Route::get('/register', function () {return view('register');});
Route::get('/forgot-password', function () {return view('forgotpassword');});
Route::get('/change-password', function () {return view('changepassword');});
Route::get('/create-news', function () {return view('createnews');});
Route::get('/detail-news', function () {return view('detailnews');});
Route::put('/update-news', function () {return view('updatenews');});
Route::get('/token', function () {return view('token');});






