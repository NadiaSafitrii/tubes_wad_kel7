<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QnaApiController;
use App\Http\Controllers\Api\PeminjamanApiController;

// Peminjaman
Route::get('/peminjaman/identitas/{nim}', [PeminjamanApiController::class, 'getIdentitas']);

// QNA
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('qna')->group(function () {
    
    Route::get('/', [QnaApiController::class, 'index']);
    
    Route::post('/', [QnaApiController::class, 'store']);
    
    Route::put('/{id}', [QnaApiController::class, 'update']);
    
    Route::delete('/{id}', [QnaApiController::class, 'destroy']);
    
    Route::get('/export-pdf', [QnaApiController::class, 'exportPdf']);
});