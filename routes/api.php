<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VooController;

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

Route::prefix('voo')->group(function () {
    Route::get('/', [VooController::class, 'getVoos']);
    Route::get('/ida', [VooController::class, 'getVoosIda']);
    Route::get('/volta', [VooController::class, 'getVoosVolta']);
    Route::get('/agrupado', [VooController::class, 'getVoosAgrupado']);
});

