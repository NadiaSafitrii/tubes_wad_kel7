<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
        .table-custom th { background-color: #b30000; color: white; border: none; }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-approved { background-color: #198754; color: #fff; }
        .badge-rejected { background-color: #dc3545; color: #fff; }
        .badge-returned { background-color: #0d6efd; color: #fff; }
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
                <a href="#"> <i class="fas fa-info-circle me-2"></i> Status </a>
                
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
                <h4 class="m-0 fw-bold text-dark fs-5">Riwayat Peminjaman</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container px-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        
                        @if($riwayats->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-secondary">Belum ada riwayat peminjaman.</h5>
                                <a href="{{ route('peminjaman.create') }}" class="btn btn-danger btn-sm mt-2 rounded-pill px-4">Ajukan Peminjaman</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-custom">
                                        <tr>
                                            <th class="py-3 ps-3 rounded-start">No</th>
                                            <th class="py-3">Barang</th>
                                            <th class="py-3">Tgl Pinjam</th>
                                            <th class="py-3">Tgl Kembali</th>
                                            <th class="py-3">Keperluan</th>
                                            <th class="py-3 rounded-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayats as $index => $r)
                                        <tr>
                                            <td class="ps-3 fw-bold text-secondary">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded p-2 me-2 text-danger">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $r->barang->nama_barang }}</h6>
                                                        <small class="text-muted" style="font-size: 0.75rem;">Lokasi: {{ $r->barang->lokasi }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($r->tgl_kembali)->format('d M Y') }}</td>
                                            <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $r->keperluan }}</span></td>
                                            <td>
                                                @if($r->status_approval == 'Pending')
                                                    <span class="badge badge-pending px-3 py-2 rounded-pill"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                                @elseif($r->status_approval == 'Approved')
                                                    <span class="badge badge-approved px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Disetujui</span>
                                                @elseif($r->status_approval == 'Rejected')
                                                    <span class="badge badge-rejected px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $r->status_approval }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>