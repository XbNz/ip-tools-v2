<?php

declare(strict_types=1);

use App\Web\Authentication\Controllers\LoginController;
use App\Web\Authentication\Controllers\RegisterController;
use App\Web\Homepage\Controllers\HomeController;
use App\Web\Subscription\SubscriptionController;
use App\Web\Uptime\Controllers\UptimeController;
use Illuminate\Support\Facades\Route;
use Tests\Feature\Web\Uptime\PingController\PingController;

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


Route::get('/', HomeController::class)->name('home.index');


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

Route::middleware('auth')->group(function () {
    Route::get('/subscribe', [SubscriptionController::class, 'create'])->name('subscription.create');
});


Route::name('uptime.')->group(function () {
    Route::get('/uptime', UptimeController::class)->name('index');

    Route::middleware('auth')->group(function () {
        Route::get('/uptime/ping', [PingController::class, 'index'])->name('ping.index');
    });
});
