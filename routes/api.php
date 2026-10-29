<?php

use App\Http\Controllers\Api\SessionUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'app' => config('app.name')]);
});

Route::post('/sessions/upload', [SessionUploadController::class, 'upload']);
