<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScanResultController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/scan-results', [ScanResultController::class, 'store']);

Route::post('/scan-results', [ScanResultController::class, 'store']); 
