<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Logistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="m-0">Form Tambah Barang (Admin)</h4>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('barang.store') }}" method="POST">
                            @csrf <div class="mb-3">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Proyektor Epson" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Ruangan">Ruangan</option>
                                        <option value="Audio">Audio</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Lokasi Penyimpanan</label>
                                    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Gedung A" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Spesifikasi</label>
                                <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Jelaskan detail barang..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Status Awal</label>
                                <select name="status" class="form-select">
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Dipinjam">Dipinjam</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ url('/ketersediaan') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Barang</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>