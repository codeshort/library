<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthorsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckOutBookController;
use App\Http\Controllers\CheckInBookController;
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

Route::post('/books', [BooksController::class,'store']);
Route::patch('/books/{book}',[BooksController::class,'update']);
Route::delete('/books/{book}',[BooksController::class,'destroy']);
Route::post('author',[AuthorsController:: class,'store']);
Route::post('/checkout/{book}',[CheckOutBookController::class,'store']);
Route::post('/checkin/{book}',[CheckInBookController::class,'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
