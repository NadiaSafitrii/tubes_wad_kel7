@foreach($peminjamans as $item)
    @php
        $alertClass = 'alert-info'; 
        $statusLabel = 'Pending';

        if($item->status_approval == 'Approved') {
            $alertClass = 'alert-success'; 
            $statusLabel = 'Disetujui';
        } elseif($item->status_approval == 'Rejected') {
            $alertClass = 'alert-danger';
            $statusLabel = 'Ditolak';
        }
    @endphp

    <div class="alert {{ $alertClass }} border-0 shadow-sm mb-3 d-flex align-items-center p-3" role="alert" style="border-left: 5px solid currentColor !important;">
        <div class="me-3 fs-4">
            @if($item->status_approval == 'Pending') ⏳ 
            @elseif($item->status_approval == 'Approved') ✅ 
            @else ❌ @endif
        </div>
        <div>
            Permintaan untuk <strong>"{{ $item->barang->nama_barang }}"</strong> 
            dari {{ $item->tgl_pinjam }} sampai {{ $item->tgl_kembali }} 
            <strong>{{ $statusLabel }}</strong> oleh admin.
        </div>
    </div>
@endforeach