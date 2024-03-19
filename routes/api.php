<?php

use App\Http\Controllers\Api\RedirectController;
use App\Http\Controllers\Api\RedirectLogController;
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

Route::apiResource('redirects', RedirectController::class);

Route::get('redirects/{redirect}/logs', RedirectLogController::class)->name('redirects.logs');

