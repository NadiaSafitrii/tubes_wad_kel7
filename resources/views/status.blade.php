<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2 sidebar p-0 pt-4">
            <div class="text-center mb-4">
                <div class="p-2 mx-auto mb-3" style="width: 100px;">
                    <img src="{{ asset('images/logo-telu.png') }}" alt="Logo Tel-U" class="img-fluid">
                </div>
                <h6 class="fw-bold mb-0 text-dark">Logistik Tel-U</h6>
                <small class="text-secondary" style="font-size: 0.75rem;">Mahasiswa Panel</small>
            </div>

            <nav>
                <a href="{{ route('mahasiswa.dashboard') }}"> <i class="fas fa-home me-2"></i> Dashboard </a>
                <a href="{{ route('mahasiswa.ketersediaan') }}"> <i class="fas fa-search me-2"></i> Cek Ketersediaan </a>
                <a href="{{ route('peminjaman.create') }}"> <i class="fas fa-file-signature me-2"></i> Ajukan Peminjaman </a>
                <a href="#" class="active"> <i class="fas fa-info-circle me-2"></i> Status </a>
                <a href="#"> <i class="fas fa-history me-2"></i> Riwayat </a>
                <a href="#"> <i class="fas fa-comments me-2"></i> QnA </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-5 border-top">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none ps-3 pt-3 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <div class="col-md-10 p-0">
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h4 class="m-0 fw-bold text-dark fs-5">Status Peminjaman</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container px-4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="mb-4">
                            <h3 class="fw-bold text-dark">Status Peminjaman</h3>
                            <p class="text-muted small">Berikut adalah notifikasi status persetujuan peminjaman Anda secara real-time.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Notifikasi Terbaru</h5>
                                
                                <div id="status-container">
                                    @if($peminjamans->isEmpty())
                                        <div class="text-center py-4">
                                            <p class="text-muted">Belum ada data peminjaman.</p>
                                        </div>
                                    @else
                                        @foreach($peminjamans as $item)
                                            @php
                                                $alertClass = 'alert-primary'; 
                                                $statusText = 'Menunggu Persetujuan';
                                                
                                                if($item->status_approval == 'Approved') {
                                                    $alertClass = 'alert-success'; 
                                                    $statusText = 'DISETUJUI';
                                                } elseif($item->status_approval == 'Rejected') {
                                                    $alertClass = 'alert-danger'; 
                                                    $statusText = 'DITOLAK';
                                                }
                                            @endphp

                                            <div class="alert {{ $alertClass }} border-0 shadow-sm mb-3 d-flex align-items-center p-3">
                                                <i class="fas fa-info-circle fa-lg me-3"></i>
                                                <div class="flex-grow-1">
                                                    Permintaan peminjaman <strong>{{ $item->barang->nama_barang }}</strong> 
                                                    untuk tanggal <strong>{{ $item->tgl_pinjam }}</strong> telah <strong>{{ $statusText }}</strong> oleh Admin.
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>