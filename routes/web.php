<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\AuthController;

// --- 1. HALAMAN LOGIN ---
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login'); // Halaman awal jadi login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 2. HALAMAN YANG BUTUH LOGIN (Group Middleware) ---
Route::middleware(['auth'])->group(function () {

    // --- AREA ADMIN ---
    // (Idealnya kita buat middleware 'admin' sendiri, tapi sementara kita gabung dulu)
    
    // Kelola Barang
    Route::get('/ketersediaan', [PeminjamanController::class, 'index'])->name('ketersediaan'); // Dashboard Utama
    
    // CRUD Barang
    Route::get('/barang/tambah', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/hapus/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Verifikasi Peminjaman
    Route::get('/admin/verifikasi', [PeminjamanController::class, 'indexVerifikasi'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/verifikasi/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.reject');

    // QnA Admin
    Route::get('/admin/qna', [QnaController::class, 'indexAdmin'])->name('admin.qna');
    Route::put('/admin/qna/{id}/jawab', [QnaController::class, 'jawab'])->name('admin.jawab');
    Route::delete('/admin/qna/{id}/hapus', [QnaController::class, 'destroy'])->name('admin.hapus');
    
    // 1. Dashboard Utama (Halaman Selamat Datang)
    Route::get('/mahasiswa/dashboard', [PeminjamanController::class, 'dashboardMahasiswa'])->name('mahasiswa.dashboard');
    
    // 2. Cek Ketersediaan (Daftar Barang)
    Route::get('/mahasiswa/ketersediaan', [PeminjamanController::class, 'ketersediaanMahasiswa'])->name('mahasiswa.ketersediaan');

    // 3. Form Peminjaman
    Route::get('/pinjam/ajukan/{barang_id?}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/pinjam/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // 4. Route Halaman Sukses
    Route::get('/pinjam/sukses', [PeminjamanController::class, 'sukses'])->name('peminjaman.sukses');
});