<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketersediaan Barang - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
        .card-barang { border: none; border-radius: 15px; transition: 0.3s; overflow: hidden; }
        .card-barang:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .search-section { background: linear-gradient(135deg, #b30000 0%, #8a0000 100%); padding: 25px; border-radius: 15px; margin-bottom: 25px; }
        .search-section .form-control, .search-section .form-select { border: none; border-radius: 10px; }
        .badge-kategori { font-size: 0.7rem; padding: 5px 10px; }
        .status-badge { position: absolute; top: 15px; right: 15px; }
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
                <a href="{{ route('mahasiswa.ketersediaan') }}" class="active"> <i class="fas fa-search me-2"></i> Cek Ketersediaan </a>
                <a href="{{ route('peminjaman.create') }}"> <i class="fas fa-file-signature me-2"></i> Ajukan Peminjaman </a>
                <a href="{{ route('peminjaman.status') }}"> <i class="fas fa-info-circle me-2"></i> Status </a>
                <a href="{{ route('mahasiswa.riwayat') }}"> <i class="fas fa-history me-2"></i> Riwayat </a>
                <a href="{{ route('mahasiswa.qna') }}"> <i class="fas fa-comments me-2"></i> QnA </a>

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
                <h4 class="m-0 fw-bold text-dark fs-5">Cek Ketersediaan Barang</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container-fluid px-4">
                <!-- Search & Filter Section -->
                <div class="search-section shadow">
                    <form action="{{ route('mahasiswa.ketersediaan') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label text-white fw-bold"><i class="fas fa-search me-1"></i> Cari Barang</label>
                                <input type="text" name="search" class="form-control" placeholder="Nama barang..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white fw-bold"><i class="fas fa-tags me-1"></i> Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="Elektronik" {{ request('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Ruangan" {{ request('kategori') == 'Ruangan' ? 'selected' : '' }}>Ruangan</option>
                                    <option value="Audio" {{ request('kategori') == 'Audio' ? 'selected' : '' }}>Audio</option>
                                    <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Lokasi</label>
                                <select name="lokasi" class="form-select">
                                    <option value="">Semua</option>
                                    @if(isset($lokasiList))
                                        @foreach($lokasiList as $lok)
                                            <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>{{ $lok }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white fw-bold"><i class="fas fa-check-circle me-1"></i> Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="Perbaikan" {{ request('status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-light w-100 fw-bold">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Count -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted mb-0">
                        <i class="fas fa-box me-1"></i> Menampilkan <strong>{{ $barangs->count() }}</strong> barang
                    </p>
                    @if(request()->hasAny(['search', 'kategori', 'lokasi', 'status']))
                        <a href="{{ route('mahasiswa.ketersediaan') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>

                <!-- Barang Cards -->
                <div class="row">
                    @forelse($barangs as $b)
                    <div class="col-md-4 mb-4">
                        <div class="card card-barang shadow-sm h-100 position-relative">
                            <!-- Status Badge -->
                            <span class="status-badge badge {{ $b->status == 'Tersedia' ? 'bg-success' : ($b->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-3">
                                {{ $b->status }}
                            </span>
                            
                            <div class="card-body pt-4">
                                <!-- Kategori Badge -->
                                <span class="badge bg-secondary badge-kategori mb-2">
                                    <i class="fas fa-tag me-1"></i> {{ $b->kategori }}
                                </span>
                                
                                <h5 class="fw-bold mb-1 text-dark">{{ $b->nama_barang }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $b->lokasi }}
                                </p>
                                <p class="text-secondary small" style="min-height: 40px;">
                                    {{ Str::limit($b->spesifikasi, 80) }}
                                </p>
                                
                                <hr>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('barang.show', $b->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                    </a>
                                    @if($b->status == 'Tersedia')
                                        <a href="{{ route('peminjaman.create', ['barang_id' => $b->id]) }}" class="btn btn-danger btn-sm flex-grow-1">
                                            <i class="fas fa-hand-holding me-1"></i> Pinjam
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                            <i class="fas fa-ban me-1"></i> Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada barang ditemukan</h5>
                                <p class="text-secondary">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
                                <a href="{{ route('mahasiswa.ketersediaan') }}" class="btn btn-primary">
                                    <i class="fas fa-redo me-1"></i> Reset Pencarian
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>