<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Ketersediaan - Logistik Telkom University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .header-telkom { background-color: #b30000; color: white; padding: 20px 0; }
        .status-badge { font-size: 0.9em; }
    </style>
</head>
<body>

    <div class="header-telkom mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 class="m-0"><i class="fas fa-boxes"></i> Logistik Telkom University</h3>
            <div>
                <a href="#" class="btn btn-outline-light btn-sm">Login</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary">Daftar Ketersediaan Barang</h5>
            </div>
            <div class="card-body">
                
                @if($barangs->isEmpty())
                    <div class="alert alert-warning">Belum ada data barang.</div>
                @else
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama Barang</th>
                                <th width="15%">Kategori</th>
                                <th width="20%">Lokasi</th>
                                <th width="25%">Spesifikasi</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $index => $barang)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->kategori }}</td>
                                <td><i class="fas fa-map-marker-alt text-danger"></i> {{ $barang->lokasi }}</td>
                                <td class="small text-muted">{{ $barang->spesifikasi }}</td>
                                <td class="text-center">
                                    @if($barang->status == 'Tersedia')
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    @elseif($barang->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark status-badge">
                                            <i class="fas fa-clock"></i> Dipinjam
                                        </span>
                                    @else
                                        <span class="badge bg-danger status-badge">
                                            <i class="fas fa-tools"></i> Perbaikan
                                        </span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>