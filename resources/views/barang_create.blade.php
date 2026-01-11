<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Administrator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .sidebar .active:hover { color: white !important; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-0 pt-4">
            <div class="text-center mb-4">
                <div class="p-2 mx-auto mb-3" style="width: 100px;">
                    <!-- Logo dummy/placeholder atau asset jika ada -->
                    <img src="{{ asset('images/logo-telu.png') }}" alt="Logo Tel-U" class="img-fluid">
                </div>
                <h6 class="fw-bold mb-0 text-dark">Logistik Tel-U</h6>
                <small class="text-secondary" style="font-size: 0.75rem;">Administrator Panel</small>
            </div>

            <nav>
                <a href="{{ url('/ketersediaan') }}" class="active"> <i class="fas fa-box-open me-2"></i> Kelola Barang </a>
                <a href="{{ route('admin.verifikasi') }}"> <i class="fas fa-clipboard-check me-2"></i> Verifikasi Peminjaman </a>
                <a href="{{ route('admin.qna') }}"> <i class="fas fa-comments me-2"></i> Jawab QnA </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-5 border-top">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none ps-3 pt-3 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-10 p-0">
            
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h4 class="m-0 fw-bold text-dark fs-5">Kelola Barang</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, Admin</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container px-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow border-0">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="m-0 fw-bold">Form Tambah Barang (Admin)</h5>
                            </div>
                            <div class="card-body p-4">
                                
                                <form action="{{ route('barang.store') }}" method="POST">
                                    @csrf 
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Proyektor Epson" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small">Kategori</label>
                                            <select name="kategori" class="form-select">
                                                <option value="Elektronik">Elektronik</option>
                                                <option value="Ruangan">Ruangan</option>
                                                <option value="Audio">Audio</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small">Lokasi Penyimpanan</label>
                                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Gedung A" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small">Spesifikasi</label>
                                        <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Jelaskan detail barang..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small">Status Awal</label>
                                        <select name="status" class="form-select">
                                            <option value="Tersedia">Tersedia</option>
                                            <option value="Dipinjam">Dipinjam</option>
                                            <option value="Perbaikan">Perbaikan</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ url('/ketersediaan') }}" class="btn btn-secondary px-4">Batal</a>
                                        <button type="submit" class="btn btn-primary px-4">Simpan Barang</button>
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