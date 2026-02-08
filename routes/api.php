<?php

use App\Http\Controllers\Api\AssistantController;
use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

Route::get('/healthz', function () {
    return response()->json(['ok' => true]);
});

// One-time DB/bootstrap endpoint for shared hosting (no SSH).
// Visit: /api/_install?token=YOUR_INSTALL_TOKEN
Route::get('/_install', [InstallController::class, 'run']);

Route::prefix('assistant')->group(function () {
    Route::post('/chat', [AssistantController::class, 'chat']);
    Route::post('/transcribe', [AssistantController::class, 'transcribe']);
    Route::post('/speak', [AssistantController::class, 'speak']);
});
