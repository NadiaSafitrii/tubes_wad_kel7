<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab QnA - Admin Logistik</title>
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
                
                <a href="{{ route('admin.verifikasi') }}">
                    <i class="fas fa-clipboard-check me-2"></i> Verifikasi Peminjaman
                </a>

                <a href="{{ route('admin.qna') }}" class="active">
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
                <h4 class="m-0 fw-bold text-dark fs-5">Tanya Jawab (QnA)</h4>
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

                <div class="row">
                    @forelse($pertanyaans as $q)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge {{ $q->status == 'Dijawab' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $q->status }}
                                    </span>
                                    <strong class="ms-2 text-primary">{{ $q->subjek }}</strong>
                                    <small class="text-muted ms-2">oleh {{ $q->user->name ?? 'User #'.$q->user_id }} | {{ $q->created_at->diffForHumans() }}</small>
                                </div>
                                
                                <form action="{{ route('admin.hapus', $q->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link text-danger p-0" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <div class="card-body">
                                <p class="card-text fw-bold text-dark mb-3">"{{ $q->pertanyaan }}"</p>

                                @if($q->status == 'Dijawab')
                                    <div class="alert alert-info border-0 bg-opacity-10 bg-primary mb-0">
                                        <i class="fas fa-reply me-2"></i> <strong>Jawaban Admin:</strong><br>
                                        {{ $q->jawaban }}
                                    </div>
                                @else
                                    <form action="{{ route('admin.jawab', $q->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="input-group">
                                            <input type="text" name="jawaban" class="form-control" placeholder="Tulis jawaban Anda di sini..." required>
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> Jawab</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                        <h6 class="text-muted">Belum ada pertanyaan masuk.</h6>
                        <small class="text-muted">Daftar pertanyaan dari mahasiswa akan muncul di sini.</small>
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