<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Barang;
use App\Models\User;
use App\Models\Qna;
use Illuminate\Support\Facades\Auth; 

class PeminjamanController extends Controller
{
    // 1. Menampilkan Halaman Utama Admin (Kelola Barang)
    public function index()
    {
        $barangs = Barang::all();
        return view('ketersediaan', compact('barangs'));
    }

    // 2. Menampilkan Form Peminjaman (User)
    public function create($barang_id = null)
    {
        $selectedBarang = null;
        if ($barang_id) {
            $selectedBarang = Barang::find($barang_id);
        }
        
        $barangs = Barang::where('status', 'Tersedia')->get();
        return view('peminjaman_create', compact('barangs', 'selectedBarang'));
    }

    // 3. Proses Simpan Peminjaman (User)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'barang_id'   => 'required',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'keperluan'   => 'required',
            'file_surat'  => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload File
        $fileName = time() . '_' . $request->file('file_surat')->getClientOriginalName();
        $request->file('file_surat')->move(public_path('uploads'), $fileName);

        // Simpan ke Database
        Peminjaman::create([
            'user_id'         => Auth::id(), 
            'barang_id'       => $request->barang_id,
            'tgl_pinjam'      => $request->tgl_pinjam,
            'tgl_kembali'     => $request->tgl_kembali,
            'keperluan'       => $request->keperluan,
            'file_surat'      => $fileName,
            'status_approval' => 'Pending',
        ]);

        // Tampilkan pesan sukses
        return back()->with('success', 'Permintaan berhasil dikirim! Silakan isi lagi jika ingin meminjam barang lain.');
    }

    // 4. Menampilkan Halaman Verifikasi (Admin)
    public function indexVerifikasi()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])
                        ->where('status_approval', 'Pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin_verifikasi', compact('peminjamans'));
    }

    // 5. Logika Menyetujui (Approve)
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Approved']);

        $barang = Barang::findOrFail($peminjaman->barang_id);
        $barang->update(['status' => 'Dipinjam']);

        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan disetujui! Barang kini berstatus Dipinjam.');
    }

    // 6. Logika Menolak (Reject)
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Rejected']);
        
        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan ditolak.');
    }

    // 7. Dashboard Utama Mahasiswa
    public function dashboardMahasiswa()
    {
        return view('mahasiswa_dashboard');
    }

    // 8. Halaman Cek Ketersediaan
    public function ketersediaanMahasiswa()
    {
        $barangs = Barang::all();
        return view('mahasiswa_ketersediaan', compact('barangs'));
    }

    // 9. Tampilkan Halaman QnA (List Pertanyaan Saya)
    public function qnaMahasiswa()
    {
        // Ambil data QnA milik user yang sedang login, urutkan dari yang terbaru
        $dataQna = Qna::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        return view('mahasiswa_qna', compact('dataQna'));
    }

    // 10. Proses Kirim Pertanyaan
    public function storeQna(Request $request)
    {
        $request->validate([
            'subjek' => 'required|max:100',
            'pertanyaan' => 'required',
        ]);

        Qna::create([
            'user_id' => Auth::id(),
            'subjek' => $request->subjek,
            'pertanyaan' => $request->pertanyaan,
            'status' => 'Terkirim'
        ]);

        return back()->with('success', 'Pertanyaan terkirim! Admin akan segera menjawabnya.');
    }

    // Ambil data peminjaman milik user login, beserta data barangnya
    public function riwayatMahasiswa()
    {
        $riwayats = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    
}