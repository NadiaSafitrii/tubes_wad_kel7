<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Riwayat - Admin Logistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        
        /* Sidebar & Layout */
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        
        /* State Aktif Sidebar - Menyala Merah */
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
        
        /* Tabel Custom */
        .table-custom th { background-color: #b30000; color: white; border: none; font-size: 0.85rem; text-transform: uppercase; padding: 15px; }
        .table td { padding: 15px !important; vertical-align: middle; }

        .badge-approved { background-color: #198754; color: #fff; }
        .badge-rejected { background-color: #dc3545; color: #fff; }
        .text-warning-star { color: #ffc107; }
        .card { border-radius: 8px; border: none; }
        
        /* Utility Buttons */
        .btn-export { font-weight: 600; font-size: 0.8rem; }
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
                <a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.index') ? 'active' : '' }}">
                    <i class="fas fa-box-open me-2"></i> Kelola Barang
                </a>
                <a href="{{ route('admin.verifikasi') }}" class="{{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check me-2"></i> Verifikasi Peminjaman
                </a>
                <a href="{{ route('admin.riwayat.index') }}" class="{{ request()->routeIs('admin.riwayat.index') ? 'active' : '' }}">
                    <i class="fas fa-history me-2"></i> Semua Riwayat
                </a>
                <a href="{{ route('admin.qna') }}" class="{{ request()->routeIs('admin.qna') ? 'active' : '' }}">
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
                <h4 class="m-0 fw-bold text-dark fs-5">Manajemen Log Riwayat</h4>
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

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0">Riwayat Peminjaman</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.riwayat.export') }}" class="btn btn-success btn-sm btn-export shadow-sm">
                            <i class="fas fa-file-excel me-2"></i> EXCEL (CSV)
                        </a>
                        <a href="{{ route('barang.exportPdf') }}" class="btn btn-danger btn-sm btn-export shadow-sm">
                            <i class="fas fa-file-pdf me-2"></i> EXPORT PDF (LPJ)
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-0"> 
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-custom">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">NO</th>
                                        <th style="width: 20%;">MAHASISWA</th>
                                        <th style="width: 20%;">BARANG & ID</th>
                                        <th style="width: 15%;">TANGGAL PINJAM</th>
                                        <th class="text-center" style="width: 10%;">STATUS</th>
                                        <th style="width: 25%;">FEEDBACK/ULASAN</th>
                                        <th class="text-center" style="width: 5%;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayats as $index => $r)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $riwayats->firstItem() + $index }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $r->user->name }}</div>
                                            <small class="text-muted">{{ $r->user->nim ?? 'NIM tidak ada' }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $r->barang->nama_barang }}</div>
                                            <small class="text-muted">Log ID: #{{ $r->id }}</small>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $r->status_approval == 'Approved' ? 'badge-approved' : 'badge-rejected' }} rounded-pill px-3">
                                                {{ $r->status_approval }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($r->feedback)
                                                <div class="d-flex align-items-center mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $r->feedback->rating ? 'text-warning-star' : 'text-muted' }}" style="font-size: 0.75rem;"></i>
                                                    @endfor
                                                    <span class="ms-1 fw-bold small text-dark">({{ $r->feedback->rating }})</span>
                                                </div>
                                                <div class="text-muted small" style="line-height: 1.2;">
                                                    {{ $r->feedback->komentar ? Str::limit($r->feedback->komentar, 50) : 'Tanpa teks' }}
                                                </div>
                                            @else
                                                <small class="text-muted">Belum ada ulasan</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="confirmDelete('{{ $r->id }}')">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                            <form id="delete-form-{{ $r->id }}" action="{{ route('admin.riwayat.destroy', $r->id) }}" method="POST" style="display:none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data riwayat tersedia.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $riwayats->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Log?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        })
    }
</script>
</body>
</html>