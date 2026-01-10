<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // API DomPDF

class RiwayatController extends Controller
{
    // Method untuk Dashboard Mahasiswa (Penyebab Error di Gambar)
    public function index()
    {
        $riwayats = Peminjaman::with(['barang', 'feedback'])
            ->where('user_id', Auth::id())
            ->whereIn('status_approval', ['Approved', 'Rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    // Method untuk Dashboard Admin
    public function indexAdmin()
    {
        $riwayats = Peminjaman::with(['barang', 'user', 'feedback'])
            ->whereIn('status_approval', ['Approved', 'Rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin_riwayat', compact('riwayats')); 
    }

    // 4. Sumber API: DomPDF untuk Export PDF (Laporan LPJ)
    public function exportPdf()
    {
        $riwayats = Peminjaman::with(['barang', 'user'])
            ->whereIn('status_approval', ['Approved', 'Rejected'])
            ->get();

        $pdf = Pdf::loadView('pdf_riwayat', compact('riwayats'));
        return $pdf->download('laporan_peminjaman_lpj.pdf');
    }

    // 5. Jenis Keluaran: EXCEL (CSV) - Rapi seperti gambar Excel kamu
    public function export()
    {
        $riwayats = Peminjaman::with(['barang', 'user', 'feedback'])->get();
        $filename = "riwayat_logistik_admin_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($riwayats) {
            $file = fopen('php://output', 'w');
            // Header kolom sesuai gambar Excel kamu
            fputcsv($file, ['NO', 'MAHASISWA', 'NIM', 'BARANG', 'TANGGAL', 'STATUS', 'RATING', 'KOMENTAR']);
            
            foreach ($riwayats as $index => $r) {
                fputcsv($file, [
                    $index + 1, 
                    $r->user->name, 
                    $r->user->nim ?? '-', 
                    $r->barang->nama_barang, 
                    $r->tgl_pinjam, 
                    $r->status_approval,
                    $r->feedback->rating ?? '0', 
                    $r->feedback->komentar ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroyAdmin($id)
    {
        Peminjaman::findOrFail($id)->delete();
        return back()->with('success', 'Riwayat berhasil dihapus.');
    }
}