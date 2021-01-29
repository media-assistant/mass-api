<?php

use App\Enums\AppName;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Media\ProxyController;
use Illuminate\Support\Facades\Route;

Route::post('/token', [AuthController::class, 'token']);

$apps = [
    AppName::RADARR,
    AppName::SONARR,
    AppName::TRANSMISSION,
];

foreach ($apps as $app) {
    Route::any("{$app}/{any?}", [ProxyController::class, $app])->where('any', '.*');
}
