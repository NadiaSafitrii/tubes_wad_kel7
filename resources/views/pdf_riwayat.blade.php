<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN RIWAYAT PEMINJAMAN LOGISTIK</h2>
        <p>Universitas Telkom - Administrator Panel</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mahasiswa</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $index => $r)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $r->user->name }} ({{ $r->user->nim ?? '-' }})</td>
                <td>{{ $r->barang->nama_barang }}</td>
                <td>{{ \Carbon\Carbon::parse($r->tgl_pinjam)->format('d M Y') }}</td>
                <td>{{ $r->status_approval }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d M Y H:i') }}</p>
    </div>
</body>
</html>