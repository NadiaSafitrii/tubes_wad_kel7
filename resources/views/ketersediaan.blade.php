<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f4f6f9; 
            overflow-x: hidden; 
        }
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
        .sidebar .active {
            background-color: #b30000;
            color: white !important;
            font-weight: bold;
            border-left: 5px solid #8a0000;
        }
        .sidebar .active:hover {
            color: white !important;
        }
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
                    <img src="{{ asset('images/logo-telu.png') }}" 
                         alt="Logo Tel-U" 
                         class="img-fluid">
                </div>
                
                <h6 class="fw-bold mb-0 text-dark">Logistik Tel-U</h6>
                <small class="text-secondary" style="font-size: 0.75rem;">Administrator Panel</small>
            </div>

            <nav>
                <a href="{{ url('/ketersediaan') }}" class="active">
                    <i class="fas fa-box-open me-2"></i> Kelola Barang
                </a>
                
                <a href="{{ route('admin.verifikasi') }}">
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
                <h4 class="m-0 fw-bold text-dark fs-5">
                    Kelola Barang Logistik
                </h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, Admin</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container-fluid px-4">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Aset & Fasilitas</h6>
                        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm shadow-sm">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Lokasi</th>
                                    <th>Spesifikasi</th>
                                    <th>Status</th>
                                    <th class="text-center" width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barangs as $index => $b)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $b->nama_barang }}</td>
                                    <td>{{ $b->lokasi }}</td>
                                    <td><small class="text-muted">{{ $b->spesifikasi }}</small></td>
                                    <td>
                                        @if($b->status == 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @elseif($b->status == 'Dipinjam')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-danger">Perbaikan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i><br>
                                        Belum ada data barang. Silakan tambah data baru.
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