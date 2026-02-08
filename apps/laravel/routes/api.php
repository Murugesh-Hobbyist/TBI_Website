<?php

use App\Http\Controllers\Api\AssistantController;
use Illuminate\Support\Facades\Route;

Route::get('/healthz', function () {
    return response()->json(['ok' => true]);
});

Route::prefix('assistant')->group(function () {
    Route::post('/chat', [AssistantController::class, 'chat']);
    Route::post('/transcribe', [AssistantController::class, 'transcribe']);
    Route::post('/speak', [AssistantController::class, 'speak']);
});

