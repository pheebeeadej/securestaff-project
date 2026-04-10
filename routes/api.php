<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\MeController;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', [ApiAuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [MeController::class, 'show']);
    Route::delete('/tokens/current', [ApiAuthController::class, 'destroy']);
});
