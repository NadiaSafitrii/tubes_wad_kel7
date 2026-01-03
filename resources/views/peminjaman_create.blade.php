<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
        .table-custom th { background-color: #b30000; color: white; border: none; font-size: 0.85rem; }
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
                <a href="{{ route('peminjaman.create') }}" class="active"> <i class="fas fa-file-signature me-2"></i> Ajukan Peminjaman </a>
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
                <h4 class="m-0 fw-bold text-dark fs-5">Formulir Peminjaman</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container px-4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 border-start border-success border-5">
                                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-secondary">BARANG YANG DIPINJAM</label>
                                                <select name="barang_id" class="form-select bg-light" required>
                                                    <option value="">-- Pilih Barang --</option>
                                                    @foreach($barangs as $b)
                                                        <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->lokasi }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-secondary">KEPERLUAN / KEGIATAN</label>
                                                <textarea name="keperluan" class="form-control bg-light" rows="5" required placeholder="Contoh: Kegiatan UKM kemah bersama..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label fw-bold small text-secondary">TGL MULAI</label>
                                                    <input type="date" name="tgl_pinjam" class="form-control bg-light" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label fw-bold small text-secondary">TGL SELESAI</label>
                                                    <input type="date" name="tgl_kembali" class="form-control bg-light" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-secondary">UPLOAD SURAT (PDF/IMG)</label>
                                                <input type="file" name="file_surat" class="form-control bg-light" accept=".pdf,.jpg,.jpeg,.png" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <button type="submit" class="btn btn-danger px-4 fw-bold rounded-pill">
                                            <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-5">
                            <div class="card-header bg-white border-0 pt-4 ps-4">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-history me-2 text-warning"></i> Pengajuan Terbaru (Status: Pending)
                                </h6>
                                <small class="text-muted">Anda dapat membatalkan pengajuan jika terjadi kesalahan input.</small>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-custom">
                                            <tr>
                                                <th class="ps-3 rounded-start">Barang</th>
                                                <th>Keperluan</th>
                                                <th>Waktu Pinjam</th>
                                                <th class="text-center rounded-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pending_pinjams as $p)
                                            <tr>
                                                <td class="ps-3 fw-bold">{{ $p->barang->nama_barang }}</td>
                                                <td><small class="text-muted">{{ Str::limit($p->keperluan, 40) }}</small></td>
                                                <td><small class="fw-bold text-secondary">{{ $p->tgl_pinjam }}</small></td>
                                                <td class="text-center">
                                                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                                            <i class="fas fa-trash-alt me-1"></i> Batal
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted small">
                                                    <i class="fas fa-info-circle me-1"></i> Belum ada pengajuan aktif yang berstatus Pending.
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
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>