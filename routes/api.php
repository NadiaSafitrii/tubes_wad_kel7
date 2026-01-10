<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QnaApiController;
use App\Http\Controllers\Api\PeminjamanApiController;

// Peminjaman
// 1. Endpoint untuk mengambil data identitas peminjam secara otomatis
Route::get('/peminjaman/identitas/{nim}', [PeminjamanApiController::class, 'getIdentitas']);

// QNA
// 1. Rute Default Laravel (Mendapatkan data user yang sedang login)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/// 2. RESTful QnA API
// Menggunakan standar HTTP Methods: GET (Read), POST (Create), PUT (Update), DELETE (Delete)
Route::prefix('qna')->group(function () {
    
    // [READ] Menampilkan list Q&A & Fitur Pencarian (Sesuai poin 3b & 4)
    Route::get('/', [QnaApiController::class, 'index']);
    
    // [CREATE] User mengirim pertanyaan baru (Sesuai poin 3c)
    Route::post('/', [QnaApiController::class, 'store']);
    
    // [UPDATE] Admin menjawab atau mengedit Q&A (Sesuai poin 3d)
    Route::put('/{id}', [QnaApiController::class, 'update']);
    
    // [DELETE] Menghapus pertanyaan/Q&A tidak relevan (Sesuai poin 3e)
    Route::delete('/{id}', [QnaApiController::class, 'destroy']);
    
    // [EXPORT] Mencetak panduan Q&A ke PDF (Sesuai poin 5)
    Route::get('/export-pdf', [QnaApiController::class, 'exportPdf']);
});