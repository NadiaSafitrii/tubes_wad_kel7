<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Spesifikasi {{ $barang->nama_barang }}</title>
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            padding: 30px;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #b30000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #b30000;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #b30000;
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table tr td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-table tr td:first-child {
            width: 35%;
            color: #666;
            font-weight: bold;
        }
        .info-table tr td:last-child {
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }
        .status-tersedia { background-color: #28a745; }
        .status-dipinjam { background-color: #ffc107; color: #333; }
        .status-perbaikan { background-color: #dc3545; }
        
        .booking-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .booking-table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }
        .booking-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .note-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .note-box p {
            margin: 0;
            color: #856404;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LOGISTIK TELKOM UNIVERSITY</h1>
        <p>Dokumen Spesifikasi Barang/Fasilitas</p>
    </div>

    <!-- Detail Barang -->
    <div class="section">
        <div class="section-title">
            <i class="fas fa-box"></i> INFORMASI BARANG
        </div>
        <table class="info-table">
            <tr>
                <td>Nama Barang</td>
                <td><strong>{{ $barang->nama_barang }}</strong></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>{{ $barang->kategori }}</td>
            </tr>
            <tr>
                <td>Lokasi Penyimpanan</td>
                <td>{{ $barang->lokasi }}</td>
            </tr>
            <tr>
                <td>Status Saat Ini</td>
                <td>
                    <span class="status-badge status-{{ strtolower($barang->status) }}">
                        {{ $barang->status }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Spesifikasi Teknis -->
    <div class="section">
        <div class="section-title">
            SPESIFIKASI TEKNIS
        </div>
        <table class="info-table">
            <tr>
                <td>Deskripsi</td>
                <td>{{ $barang->spesifikasi }}</td>
            </tr>
        </table>
    </div>

    <!-- Riwayat Peminjaman -->
    @if($bookings->count() > 0)
    <div class="section">
        <div class="section-title">
            RIWAYAT PEMINJAMAN TERAKHIR
        </div>
        <table class="booking-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Keperluan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tgl_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tgl_kembali)->format('d M Y') }}</td>
                    <td>{{ Str::limit($booking->keperluan, 50) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Note -->
    <div class="note-box">
        <p><strong>Catatan:</strong> Dokumen ini dicetak untuk keperluan lampiran proposal kegiatan mahasiswa. 
        Untuk melakukan peminjaman, silakan mengajukan melalui sistem Logistik Tel-U.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis pada {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
        <p>Sistem Logistik Telkom University &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
