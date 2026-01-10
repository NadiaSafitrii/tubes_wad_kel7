<!DOCTYPE html>
<html>
<head>
    <title>Bukti Peminjaman</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin: 20px; }
        .footer { margin-top: 50px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BUKTI PEMINJAMAN BARANG</h2>
        <p>Telkom University - Fakultas Rekayasa Industri</p>
    </div>

    <div class="content">
        <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama }}</p>
        <p><strong>NIM:</strong> {{ $peminjaman->nim }}</p>
        <p><strong>Barang:</strong> {{ $peminjaman->barang->nama_barang }}</p>
        <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
        <hr>
        <p><strong>Tanggal Pinjam:</strong> {{ $tgl_pinjam }}</p>
        <p><strong>Tanggal Kembali:</strong> {{ $tgl_kembali }}</p>
        <p><strong>Status:</strong> <span style="color: green;">{{ $peminjaman->status_approval }}</span></p>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ $tgl_cetak }}</p>
        <p>Tunjukkan dokumen ini kepada petugas logistik saat pengambilan barang.</p>
    </div>
</body>
</html>