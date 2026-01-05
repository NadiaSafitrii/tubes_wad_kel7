<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AuthController;

// --- 1. HALAMAN LOGIN ---
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {

    // ==========================================
    // BAGIAN ADMIN
    // ==========================================
    
    Route::get('/ketersediaan', [PeminjamanController::class, 'indexBarang'])->name('admin.barang.index'); 
    
    // Rute CRUD Barang 
    Route::get('/barang/tambah', [PeminjamanController::class, 'createBarang'])->name('barang.create');
    Route::post('/barang/store', [PeminjamanController::class, 'storeBarang'])->name('barang.store');
    Route::get('/barang/edit/{id}', [PeminjamanController::class, 'editBarang'])->name('barang.edit');
    Route::put('/barang/update/{id}', [PeminjamanController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/barang/hapus/{id}', [PeminjamanController::class, 'destroyBarang'])->name('barang.destroy');

    // Verifikasi Peminjaman
    Route::get('/admin/verifikasi', [PeminjamanController::class, 'index'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/verifikasi/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.reject');

    // QnA Admin
    Route::get('/admin/qna', [QnaController::class, 'indexAdmin'])->name('admin.qna');
    Route::put('/admin/qna/{id}/jawab', [QnaController::class, 'jawab'])->name('admin.jawab');
    Route::delete('/admin/qna/{id}/hapus', [QnaController::class, 'destroy'])->name('admin.hapus');
    
    
    // ==========================================
    // BAGIAN MAHASISWA 
    // ==========================================

    // Dashboard & Cek Ketersediaan Barang
    Route::get('/mahasiswa/dashboard', [PeminjamanController::class, 'dashboardMahasiswa'])->name('mahasiswa.dashboard');
    Route::get('/mahasiswa/ketersediaan', [PeminjamanController::class, 'ketersediaanMahasiswa'])->name('mahasiswa.ketersediaan');

    // Form Pengajuan Pinjam
    Route::get('/pinjam/ajukan', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/pinjam/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // Status Tracking
    Route::get('/mahasiswa/status', [PeminjamanController::class, 'status'])->name('peminjaman.status');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Riwayat & QnA Mahasiswa
    Route::get('/mahasiswa/riwayat', [PeminjamanController::class, 'riwayatMahasiswa'])->name('mahasiswa.riwayat');
    Route::get('/mahasiswa/qna', [PeminjamanController::class, 'qnaMahasiswa'])->name('mahasiswa.qna');
    Route::post('/mahasiswa/qna/store', [PeminjamanController::class, 'storeQna'])->name('qna.store');

    // Feedback
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('/feedback/update/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/delete/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});