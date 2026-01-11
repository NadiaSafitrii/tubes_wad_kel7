<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Admin Logistik</title>
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
                <small class="text-secondary" style="font-size: 0.75rem;">Administrator Panel</small>
            </div>

            <nav>
                <a href="{{ url('/ketersediaan') }}" class="{{ request()->is('ketersediaan*') || request()->is('barang*') ? 'active' : '' }}">
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
                <h4 class="m-0 fw-bold text-dark fs-5">Edit Data Barang</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, Admin</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header bg-warning">
                                <h4 class="m-0 text-dark"><i class="fas fa-edit me-2"></i>Edit Barang</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') 
                                    
                                    <div class="mb-3">
                                        <label class="fw-bold">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="fw-bold">Kategori</label>
                                            <select name="kategori" class="form-select">
                                                <option value="Elektronik" {{ $barang->kategori == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                                <option value="Ruangan" {{ $barang->kategori == 'Ruangan' ? 'selected' : '' }}>Ruangan</option>
                                                <option value="Audio" {{ $barang->kategori == 'Audio' ? 'selected' : '' }}>Audio</option>
                                                <option value="Lainnya" {{ $barang->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="fw-bold">Lokasi</label>
                                            <input type="text" name="lokasi" class="form-control" value="{{ $barang->lokasi }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Spesifikasi</label>
                                        <textarea name="spesifikasi" class="form-control" rows="3">{{ $barang->spesifikasi }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Dipinjam" {{ $barang->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="Perbaikan" {{ $barang->status == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <a href="{{ url('/ketersediaan') }}" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary px-4">Update Data</button>
                                    </div>
                                </form>
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