<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Rutas del login */
Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'verify')->name('login.verify');
});

/* Rutas del registro */
Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'index')->name('register.index');
    Route::post('/register', 'store')->name('register.store');
});


Route::get('/', [AppController::class, 'index'])->name('app.index');
