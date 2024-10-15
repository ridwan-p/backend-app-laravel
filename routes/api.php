<?php

use App\Http\Controllers\AnnualLeaveController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('annual-leaves', [AnnualLeaveController::class, 'store']);
        Route::get('annual-leaves', [AnnualLeaveController::class, 'index']);
        Route::get('annual-leaves/{id}', [AnnualLeaveController::class, 'show']);
    });
