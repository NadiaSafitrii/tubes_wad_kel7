<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RiwayatController; 

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
    Route::get('/barang/tambah', [PeminjamanController::class, 'createBarang'])->name('barang.create');
    Route::post('/barang/store', [PeminjamanController::class, 'storeBarang'])->name('barang.store');
    Route::get('/barang/edit/{id}', [PeminjamanController::class, 'editBarang'])->name('barang.edit');
    Route::put('/barang/update/{id}', [PeminjamanController::class, 'updateBarang'])->name('barang.update');
    Route::delete('/barang/hapus/{id}', [PeminjamanController::class, 'destroyBarang'])->name('barang.destroy');

    Route::get('/admin/verifikasi', [PeminjamanController::class, 'index'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/verifikasi/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.reject');

    Route::get('/admin/qna', [QnaController::class, 'indexAdmin'])->name('admin.qna');
    Route::put('/admin/qna/{id}/jawab', [QnaController::class, 'jawab'])->name('admin.jawab');
    Route::delete('/admin/qna/{id}/hapus', [QnaController::class, 'destroy'])->name('admin.hapus');

    // VERIFIKASI ADMIN
    Route::post('/admin/peminjaman/approve/{id}', [App\Http\Controllers\PeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
    Route::post('/admin/peminjaman/reject/{id}', [App\Http\Controllers\PeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
    
    // RIWAYAT ADMIN
    Route::get('/admin/riwayat', [RiwayatController::class, 'indexAdmin'])->name('admin.riwayat.index'); 
    Route::delete('/admin/riwayat/hapus/{id}', [RiwayatController::class, 'destroyAdmin'])->name('admin.riwayat.destroy');

    // JENIS KELUARAN: EXCEL (CSV)
    Route::get('/admin/export-riwayat', [RiwayatController::class, 'export'])->name('admin.riwayat.export');

    // SUMBER API: DomPDF untuk Export PDF
    Route::get('/admin/export-pdf', [RiwayatController::class, 'exportPdf'])->name('barang.exportPdf');

    // ==========================================
    // BAGIAN MAHASISWA 
    // ==========================================
    Route::get('/mahasiswa/dashboard', [PeminjamanController::class, 'dashboardMahasiswa'])->name('mahasiswa.dashboard');

    // 1. Dashboard 
    Route::get('/mahasiswa/dashboard', [PeminjamanController::class, 'dashboardMahasiswa'])->name('mahasiswa.dashboard');
    
    // 2. Cek Ketersediaan (Daftar Barang dengan Search/Filter)
    Route::get('/mahasiswa/ketersediaan', [BarangController::class, 'search'])->name('mahasiswa.ketersediaan');
    
    // 3. Detail Barang dengan Kalender
    Route::get('/mahasiswa/barang/{id}', [PeminjamanController::class, 'show'])->name('barang.show');
    
    // 4. API Kalender Booking (JSON)
    Route::get('/mahasiswa/barang/{id}/calendar', [BarangController::class, 'getBookingSchedule'])->name('barang.calendar');

    // 5. Pengajuan Pinjam & Status 
    Route::get('/pinjam/ajukan', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/pinjam/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/mahasiswa/status', [PeminjamanController::class, 'status'])->name('peminjaman.status');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::get('/peminjaman/cetak/{id}', [App\Http\Controllers\PeminjamanController::class, 'cetakBukti'])->name('peminjaman.cetak');

    // 6. Fitur Riwayat Mahasiswa
    Route::get('/mahasiswa/riwayat', [RiwayatController::class, 'index'])->name('mahasiswa.riwayat');
    Route::get('/mahasiswa/riwayat/export', [RiwayatController::class, 'exportPdf'])->name('riwayat.export');
    
    // 7. QnA & Feedback
    Route::get('/mahasiswa/qna', [PeminjamanController::class, 'qnaMahasiswa'])->name('mahasiswa.qna');
    Route::post('/mahasiswa/qna/store', [PeminjamanController::class, 'storeQna'])->name('qna.store');

    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('/feedback/update/{id}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/delete/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
});