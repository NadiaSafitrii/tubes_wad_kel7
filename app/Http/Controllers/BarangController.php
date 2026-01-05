<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    // 1. Tampilkan Form Tambah
    public function create()
    {
        return view('barang_create');
    }

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'lokasi' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        Barang::create($request->all());

        return redirect('/ketersediaan')->with('success', 'Barang berhasil ditambahkan!');
    }

    // 3. Tampilkan Form Edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang_edit', compact('barang'));
    }

    // 4. Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'lokasi' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect('/ketersediaan')->with('success', 'Barang berhasil diperbarui!');
    }

    // 5. Hapus Data
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/ketersediaan')->with('success', 'Barang berhasil dihapus!');
    }

    // 6. Tampilkan Detail Barang dengan Kalender Booking
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Get approved bookings for this item
        $bookings = Peminjaman::where('barang_id', $id)
            ->where('status_approval', 'Approved')
            ->get();
        
        return view('barang_detail', compact('barang', 'bookings'));
    }

    // 7. API untuk mendapatkan jadwal booking (untuk FullCalendar)
    public function getBookingSchedule($id)
    {
        $bookings = Peminjaman::with('user')
            ->where('barang_id', $id)
            ->where('status_approval', 'Approved')
            ->get();

        // Format untuk FullCalendar
        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => 'Dipinjam: ' . ($booking->user->name ?? 'User'),
                'start' => $booking->tgl_pinjam,
                'end' => date('Y-m-d', strtotime($booking->tgl_kembali . ' +1 day')), // FullCalendar end date is exclusive
                'color' => '#dc3545', // Red color for booked dates
                'extendedProps' => [
                    'keperluan' => $booking->keperluan,
                    'peminjam' => $booking->user->name ?? 'User'
                ]
            ];
        });

        return response()->json($events);
    }

    // 8. Pencarian dan Filter Barang
    public function search(Request $request)
    {
        $query = Barang::query();

        // Filter by search keyword (nama_barang)
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $barangs = $query->get();

        // Get unique locations for filter dropdown
        $lokasiList = Barang::select('lokasi')->distinct()->pluck('lokasi');

        return view('mahasiswa_ketersediaan', compact('barangs', 'lokasiList'));
    }

    // 9. Export PDF Spesifikasi Barang
    public function exportPdf($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Get booking history
        $bookings = Peminjaman::with('user')
            ->where('barang_id', $id)
            ->where('status_approval', 'Approved')
            ->orderBy('tgl_pinjam', 'desc')
            ->take(10)
            ->get();

        $pdf = Pdf::loadView('barang_pdf', compact('barang', 'bookings'));
        
        return $pdf->download('spesifikasi_' . str_replace(' ', '_', $barang->nama_barang) . '.pdf');
    }
}