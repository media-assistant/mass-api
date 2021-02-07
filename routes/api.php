<?php

use App\Enums\AppName;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Media\ProxyController;
use App\Http\Controllers\Requests\AdminRequestController;
use App\Http\Controllers\Requests\UserRequestController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::post('/token', [AuthController::class, 'token']);

/*
 * Routes protected by Sanctum tokens.
 */
Route::middleware('auth:sanctum')->group(static function (): void {
    $apps = [
        AppName::RADARR,
        AppName::SONARR,
        AppName::TRANSMISSION,
    ];

    foreach ($apps as $app) {
        Route::any("{$app}/{any?}", [ProxyController::class, $app])->where('any', '.*');
    }

    Route::any('ping', static function (): JsonResponse {
        return response()->json('pong');
    });

    Route::get('user', [AuthController::class, 'user']);

    Route::prefix('requests')->group(static function () {
        Route::middleware('can:requests.user')->group(static function (): void {
            Route::get('', [UserRequestController::class, 'requests']);
            Route::put('', [UserRequestController::class, 'put']);
            Route::delete('{request}', [UserRequestController::class, 'delete']);
        });

        Route::middleware('can:requests.admin')->group(static function (): void {
            Route::patch('{request}/status', [AdminRequestController::class, 'updateStatus']);
        });
    });
});
