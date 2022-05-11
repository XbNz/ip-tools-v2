<?php

use App\Web\Authentication\Controllers\LoginController;
use App\Web\Homepage\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Web\Authentication\Controllers\RegisterController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', HomeController::class)->name('home.index');
});


Route::post('/login', [LoginController::class, 'store'])->name('auth.login.store');

Route::name('auth.')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])->name('login.create')
        ->middleware('guest');

    Route::post('/login', [LoginController::class, 'store'])->name('login.store')
        ->middleware('guest', 'throttle:50,1');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('login.destroy')
        ->middleware('auth');

    Route::get('/register', [RegisterController::class, 'create'])->name('register.create')
        ->middleware('guest');

    Route::post('/register', [RegisterController::class, 'store'])->name('register.store')
        ->middleware(['guest', 'throttle:50,1']);
});
