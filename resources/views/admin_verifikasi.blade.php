<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Peminjaman - Admin Logistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            color: #333;
            border-right: 1px solid #dee2e6;
        }
        .sidebar a {
            color: #555;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: 0.3s;
            font-weight: 500;
        }
        .sidebar a:hover {
            background-color: #f8f9fa;
            color: #b30000;
            padding-left: 25px; 
        }
        /* Menu Aktif Merah */
        .sidebar .active {
            background-color: #b30000;
            color: white !important;
            font-weight: bold;
            border-left: 5px solid #8a0000;
        }
        .sidebar .active:hover { color: white !important; }
        .admin-header {
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
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
                <small class="text-secondary" style="font-size: 0.75rem;">Administrator Panel</small>
            </div>

            <nav>
                <a href="{{ url('/ketersediaan') }}">
                    <i class="fas fa-box-open me-2"></i> Kelola Barang
                </a>
                
                <a href="{{ route('admin.verifikasi') }}" class="active">
                    <i class="fas fa-clipboard-check me-2"></i> Verifikasi Peminjaman
                </a>

                <a href="{{ route('admin.qna') }}">
                    <i class="fas fa-comments me-2"></i> Jawab QnA
                </a>

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
                <h4 class="m-0 fw-bold text-dark fs-5">Verifikasi Peminjaman</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, Admin</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container-fluid px-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">Permintaan Masuk (Pending)</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Barang</th>
                                    <th>Jadwal</th>
                                    <th>Keperluan</th>
                                    <th>Bukti</th>
                                    <th class="text-center">Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $p)
                                <tr>
                                    <td>
                                        <strong>{{ $p->user->name ?? 'User #'.$p->user_id }}</strong><br>
                                        <small class="text-muted">NIM: {{ $p->user->nim ?? '-' }}</small>
                                    </td>
                                    <td>{{ $p->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                                    <td>
                                        <small class="d-block text-muted">Pinjam: {{ $p->tgl_pinjam }}</small>
                                        <small class="d-block text-muted">Kembali: {{ $p->tgl_kembali }}</small>
                                    </td>
                                    <td><small>{{ $p->keperluan }}</small></td>
                                    <td>
                                        <a href="{{ asset('uploads/'.$p->file_surat) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-file-pdf"></i> Cek
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('admin.approve', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.reject', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak peminjaman ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i><br>
                                        Tidak ada pengajuan baru saat ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>