<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="m-0">Edit Barang</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="Elektronik" {{ $barang->kategori == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                <option value="Ruangan" {{ $barang->kategori == 'Ruangan' ? 'selected' : '' }}>Ruangan</option>
                                <option value="Audio" {{ $barang->kategori == 'Audio' ? 'selected' : '' }}>Audio</option>
                                <option value="Lainnya" {{ $barang->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ $barang->lokasi }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control" rows="3">{{ $barang->spesifikasi }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Dipinjam" {{ $barang->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Perbaikan" {{ $barang->status == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/ketersediaan') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>