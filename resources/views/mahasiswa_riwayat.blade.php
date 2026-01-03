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
        .badge-approved { background-color: #198754; color: #fff; }
        .badge-rejected { background-color: #dc3545; color: #fff; }
        
        /* Style Bintang */
        .star-rating { direction: rtl; display: inline-block; padding: 10px; }
        .star-rating input { display: none; }
        .star-rating label { color: #bbb; font-size: 2rem; padding: 0; cursor: pointer; transition: 0.3s; }
        .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #f2b600; }
        .text-warning-star { color: #f2b600; }
        
        /* Memastikan komentar panjang terlihat semua */
        .comment-text { 
            white-space: normal; 
            word-wrap: break-word; 
            max-width: 250px; 
            margin: 0 auto;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
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
                <a href="{{ route('peminjaman.status') }}"> <i class="fas fa-info-circle me-2"></i> Status </a>
                <a href="{{ route('mahasiswa.riwayat') }}" class="active"> <i class="fas fa-history me-2"></i> Riwayat </a>
                <a href="{{ route('mahasiswa.qna') }}"> <i class="fas fa-comments me-2"></i> QnA </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-5 border-top">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger text-decoration-none ps-3 pt-3 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="col-md-10 p-0">
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h4 class="m-0 fw-bold text-dark fs-5">Riwayat Peminjaman</h4>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container px-4">
                {{-- Filter & Search --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <form action="{{ route('mahasiswa.riwayat') }}" method="GET" class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">FILTER STATUS</label>
                                <select name="status" class="form-select form-select-sm border-0 bg-light">
                                    <option value="">Semua Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">CARI BARANG</label>
                                <input type="text" name="search" class="form-control form-control-sm border-0 bg-light" placeholder="Nama barang...">
                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill">Terapkan</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Riwayat --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4 border-start border-5 border-success">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-custom">
                                    <tr>
                                        <th class="py-3 ps-3 rounded-start">No</th>
                                        <th>Barang</th>
                                        <th>Durasi Peminjaman</th>
                                        <th>Status Akhir</th>
                                        <th class="py-3 rounded-end text-center">Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayats as $index => $r)
                                    <tr>
                                        <td class="ps-3 fw-bold">{{ $index + 1 }}</td>
                                        <td>
                                            <h6 class="mb-0 fw-bold">{{ $r->barang->nama_barang }}</h6>
                                            <small class="text-muted">ID: #{{ $r->id }}</small>
                                        </td>
                                        <td>
                                            <small class="d-block fw-bold">{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d/m/Y') }}</small>
                                            <small class="text-muted">Hingga {{ \Carbon\Carbon::parse($r->tgl_kembali)->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $r->status_approval == 'Approved' ? 'badge-approved' : 'badge-rejected' }} px-3 py-2 rounded-pill">
                                                {{ $r->status_approval }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($r->status_approval == 'Approved')
                                                @if($r->feedback)
                                                    {{-- Tampilan Feedback Selesai --}}
                                                    <div class="text-warning-star mb-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="{{ $i <= $r->feedback->rating ? 'fas' : 'far' }} fa-star"></i>
                                                        @endfor
                                                    </div>
                                                    {{-- Menampilkan seluruh komentar --}}
                                                    <div class="small text-muted mb-2 comment-text">"{{ $r->feedback->komentar }}"</div>
                                                    
                                                    <div class="d-flex justify-content-center gap-2">
                                                        {{-- d. Update: Tombol Edit --}}
                                                        <button class="btn btn-sm btn-outline-primary border-0" data-bs-toggle="modal" data-bs-target="#editFeedbackModal{{ $r->feedback->id }}">
                                                            <i class="fas fa-edit fa-lg"></i>
                                                        </button>
                                                        {{-- e. Delete: Tombol Hapus --}}
                                                        <form action="{{ route('feedback.destroy', $r->feedback->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus ulasan ini?')">
                                                                <i class="fas fa-trash fa-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    {{-- c. Create: Tombol Beri Ulasan --}}
                                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $r->id }}">
                                                        <i class="fas fa-star me-1"></i> Beri Ulasan
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $riwayats->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL AREA --}}
@foreach($riwayats as $r)
    {{-- Modal Create --}}
    @if($r->status_approval == 'Approved' && !$r->feedback)
    <div class="modal fade" id="feedbackModal{{ $r->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="peminjaman_id" value="{{ $r->id }}">
                    <div class="modal-header border-0 bg-light">
                        <h5 class="fw-bold mb-0">Ulasan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <h6 class="fw-bold">{{ $r->barang->nama_barang }}</h6>
                        <div class="star-rating">
                            @for($i=5; $i>=1; $i--)
                            <input type="radio" id="star{{$i}}-{{$r->id}}" name="rating" value="{{$i}}" required/><label for="star{{$i}}-{{$r->id}}">★</label>
                            @endfor
                        </div>
                        <textarea name="komentar" class="form-control border-0 bg-light mt-2" rows="3" placeholder="Bagaimana kondisi barangnya?"></textarea>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold py-2">Kirim Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- d. Modal Update: Edit Ulasan --}}
    @if($r->feedback)
    <div class="modal fade" id="editFeedbackModal{{ $r->feedback->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('feedback.update', $r->feedback->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header border-0 bg-light">
                        <h5 class="fw-bold mb-0">Perbarui Ulasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <h6 class="fw-bold text-dark">{{ $r->barang->nama_barang }}</h6>
                        <div class="star-rating">
                            @for($i=5; $i>=1; $i--)
                            <input type="radio" id="editstar{{$i}}-{{$r->feedback->id}}" name="rating" value="{{$i}}" {{ $r->feedback->rating == $i ? 'checked' : '' }}/><label for="editstar{{$i}}-{{$r->feedback->id}}">★</label>
                            @endfor
                        </div>
                        <textarea name="komentar" class="form-control border-0 bg-light mt-2" rows="4">{{ $r->feedback->komentar }}</textarea>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>