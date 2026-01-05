<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - {{ $barang->nama_barang }} | Logistik Tel-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { min-height: 100vh; background-color: #ffffff; color: #333; border-right: 1px solid #dee2e6; }
        .sidebar a { color: #555; text-decoration: none; display: block; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; transition: 0.3s; font-weight: 500; }
        .sidebar a:hover { background-color: #f8f9fa; color: #b30000; padding-left: 25px; }
        .sidebar .active { background-color: #b30000; color: white !important; font-weight: bold; border-left: 5px solid #8a0000; }
        .admin-header { background-color: #fff; padding: 15px 20px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6; }
        .detail-card { border: none; border-radius: 15px; overflow: hidden; }
        .spec-item { padding: 12px 0; border-bottom: 1px solid #eee; }
        .spec-item:last-child { border-bottom: none; }
        .calendar-container { background: #fff; border-radius: 15px; padding: 20px; }
        #calendar { max-height: 500px; }
        .fc-event { cursor: pointer; }
        .legend-item { display: inline-flex; align-items: center; margin-right: 20px; }
        .legend-dot { width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; }
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
                <a href="{{ route('mahasiswa.ketersediaan') }}" class="active"> <i class="fas fa-search me-2"></i> Cek Ketersediaan </a>
                <a href="{{ route('peminjaman.create') }}"> <i class="fas fa-file-signature me-2"></i> Ajukan Peminjaman </a>
                <a href="{{ route('peminjaman.status') }}"> <i class="fas fa-info-circle me-2"></i> Status </a>
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
                <div>
                    <a href="{{ route('mahasiswa.ketersediaan') }}" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Barang
                    </a>
                </div>
                <div class="user-info">
                    <span class="me-2 fw-bold small text-dark">Halo, {{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle fa-2x text-secondary align-middle"></i>
                </div>
            </div>

            <div class="container-fluid px-4">
                <div class="row">
                    <!-- Left Column: Detail Info -->
                    <div class="col-md-5 mb-4">
                        <div class="card detail-card shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-box text-primary me-2"></i>
                                        {{ $barang->nama_barang }}
                                    </h5>
                                    <span class="badge {{ $barang->status == 'Tersedia' ? 'bg-success' : ($barang->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill px-3 py-2">
                                        {{ $barang->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Specifications -->
                                <h6 class="fw-bold text-secondary mb-3">
                                    <i class="fas fa-list-ul me-2"></i> Spesifikasi Teknis
                                </h6>
                                
                                <div class="spec-item">
                                    <div class="row">
                                        <div class="col-4 text-muted">Kategori</div>
                                        <div class="col-8 fw-bold">
                                            <span class="badge bg-secondary">{{ $barang->kategori }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="row">
                                        <div class="col-4 text-muted">Lokasi</div>
                                        <div class="col-8">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            {{ $barang->lokasi }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="row">
                                        <div class="col-4 text-muted">Status</div>
                                        <div class="col-8">
                                            @if($barang->status == 'Tersedia')
                                                <i class="fas fa-check-circle text-success me-1"></i> Tersedia untuk dipinjam
                                            @elseif($barang->status == 'Dipinjam')
                                                <i class="fas fa-clock text-warning me-1"></i> Sedang dipinjam
                                            @else
                                                <i class="fas fa-tools text-danger me-1"></i> Dalam perbaikan
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="spec-item">
                                    <div class="row">
                                        <div class="col-4 text-muted">Deskripsi</div>
                                        <div class="col-8">{{ $barang->spesifikasi }}</div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    @if($barang->status == 'Tersedia')
                                        <a href="{{ route('peminjaman.create', ['barang_id' => $barang->id]) }}" class="btn btn-danger btn-lg">
                                            <i class="fas fa-hand-holding me-2"></i> Ajukan Peminjaman Sekarang
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-lg" disabled>
                                            <i class="fas fa-ban me-2"></i> Barang Tidak Tersedia
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('barang.exportPdf', $barang->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-file-pdf me-2"></i> Download Spesifikasi (PDF)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Calendar -->
                    <div class="col-md-7 mb-4">
                        <div class="calendar-container shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-bold text-dark">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    Jadwal Ketersediaan
                                </h5>
                                <div class="legend">
                                    <span class="legend-item">
                                        <span class="legend-dot bg-success"></span> Tersedia
                                    </span>
                                    <span class="legend-item">
                                        <span class="legend-dot bg-danger"></span> Sudah Dibooking
                                    </span>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                Tanggal berwarna <span class="text-danger fw-bold">merah</span> menunjukkan barang sudah di-booking. Pilih tanggal yang tersedia untuk mengajukan peminjaman.
                            </p>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i> Detail Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="text-muted small">Peminjam:</label>
                    <p class="fw-bold mb-0" id="modalPeminjam"></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Tanggal Pinjam:</label>
                    <p class="fw-bold mb-0" id="modalTanggal"></p>
                </div>
                <div>
                    <label class="text-muted small">Keperluan:</label>
                    <p class="mb-0" id="modalKeperluan"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu'
            },
            events: '{{ route("barang.calendar", $barang->id) }}',
            eventClick: function(info) {
                // Show booking detail modal
                document.getElementById('modalPeminjam').textContent = info.event.extendedProps.peminjam || '-';
                document.getElementById('modalKeperluan').textContent = info.event.extendedProps.keperluan || '-';
                
                var startDate = info.event.start ? info.event.start.toLocaleDateString('id-ID') : '-';
                var endDate = info.event.end ? new Date(info.event.end.getTime() - 86400000).toLocaleDateString('id-ID') : startDate;
                document.getElementById('modalTanggal').textContent = startDate + ' s/d ' + endDate;
                
                var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();
            },
            eventDisplay: 'block',
            displayEventTime: false
        });
        calendar.render();
    });
</script>
</body>
</html>
