<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::name('ip.')->middleware(['throttle:9999999999,1'])->group(function () {
    Route::post('/ip', \App\Api\IpAddressInfo\Controllers\IpAddressInfoController::class)->name('show');
    Route::post('/ip/advanced', \App\Api\IpAddressInfo\Controllers\AdvancedIpAddressInfoController::class)->name('advanced.show');
    //TODO: Add throttling for these routes (10/min/ip BUT respond to redis-cached IP requests)
});

