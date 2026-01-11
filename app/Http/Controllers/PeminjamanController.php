<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Barang;
use App\Models\User;
use App\Models\Qna;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    // ==========================================
    // 1. KELOLA BARANG (ADMIN)
    // ==========================================
    
    // Menampilkan daftar barang
    public function indexBarang()
    {
        $barangs = Barang::all();
        return view('ketersediaan', compact('barangs')); 
    }

    // Form input barang
    public function createBarang()
    {
        return view('barang_create');
    }

    // Menyimpan ke database
    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required',
            'status'      => 'required'
        ]);
        Barang::create($request->all());
        return redirect()->route('admin.barang.index')->with('success', 'Barang baru berhasil ditambah!');
    }

    // Form edit barang
    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang_edit', compact('barang')); 
    }

    // update
    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect()->route('admin.barang.index')->with('success', 'Data barang sudah diperbarui.');
    }

    // Hapus barang 
    public function destroyBarang($id)
    {
        Barang::findOrFail($id)->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }

    // ==========================================
    // 2. VERIFIKASI PEMINJAMAN (ADMIN)
    // ==========================================

    public function index()
    {
        // Alias for admin verification page
        return $this->indexVerifikasi();
    }

    public function indexVerifikasi()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])
                        ->where('status_approval', 'Pending')
                        ->orderBy('id', 'desc')
                        ->get();

        $approved_pinjams = Peminjaman::with(['barang', 'user'])
                        ->where('status_approval', 'Approved')
                        ->orderBy('id', 'desc')
                        ->get();

        return view('admin_verifikasi', compact('peminjamans', 'approved_pinjams'));
    }

    // Admin Approve
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Approved']);
        
        $barang = Barang::findOrFail($peminjaman->barang_id);
        $barang->update(['status' => 'Dipinjam']);
        
        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan disetujui! Barang kini berstatus Dipinjam.');
    }

    // Admin Reject
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Rejected']);
        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan ditolak.');
    }

    // Admin Selesai (Barang Kembali)
    public function complete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Selesai']);
        
        // Kembalikan status barang jadi Tersedia
        $barang = Barang::findOrFail($peminjaman->barang_id);
        $barang->update(['status' => 'Tersedia']);

        return redirect()->route('admin.verifikasi')->with('success', 'Barang telah dikembalikan dan status menjadi Tersedia.');
    }

    // ==========================================
    // 3. FITUR MAHASISWA
    // ==========================================

    // Beranda dashboard  mahasiswa
    public function dashboardMahasiswa() 
    { 
        return view('mahasiswa_dashboard'); 
    }

    // Daftar barang tersedia
    public function ketersediaanMahasiswa()
    {
        $barangs = Barang::all();
        return view('mahasiswa_ketersediaan', compact('barangs'));
    }

    // Cek status pengajuan (Tracking) 
    public function status()
    {
        $peminjamans = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
        return view('status', compact('peminjamans'));
    }

    public function checkStatusUpdate()
    {
        $peminjamans = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();

        return view('partials.status_list', compact('peminjamans'))->render();
    }

    // Liat riwayat pinjaman 
    public function riwayatMahasiswa()
    {
        $riwayats = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    // Form pengajuan pinjaman
    public function create($barang_id = null)
    {
        $selectedBarang = null;
        if ($barang_id) {
            $selectedBarang = Barang::find($barang_id);
        }
        
        $barangs = Barang::where('status', 'Tersedia')->get();
        
        // Data pengajuan pending untuk ditampilkan di tabel bawah form
        $pending_pinjams = Peminjaman::with('barang')
                            ->where('user_id', Auth::id())
                            ->where('status_approval', 'Pending')
                            ->get();

        return view('peminjaman_create', compact('barangs', 'selectedBarang', 'pending_pinjams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => 'required',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'keperluan'   => 'required',
            'file_surat'  => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $fileName = time() . '_' . $request->file('file_surat')->getClientOriginalName();
        $request->file('file_surat')->move(public_path('uploads'), $fileName);

        Peminjaman::create([
            'user_id'         => Auth::id(),
            'barang_id'       => $request->barang_id,
            'tgl_pinjam'      => $request->tgl_pinjam,
            'tgl_kembali'     => $request->tgl_kembali,
            'keperluan'       => $request->keperluan,
            'file_surat'      => $fileName,
            'status_approval' => 'Pending',
        ]);
         return back()->with('success', 'Berhasil mengajukan pinjaman! Silakan cek menu Status untuk tracking peminjaman.');
    }

    // Hapus/Batal Peminjaman (User)
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $peminjaman->delete();
            return back()->with('success', 'Pengajuan berhasil dibatalkan.');
        }
        return back()->with('error', 'Kamu tidak memiliki akses untuk menghapus.');
    }

    // Fitur QnA mahasiswa
    public function qnaMahasiswa()
    {
        // Ambil data QnA milik user yang sedang login, urutkan dari yang terbaru
        $dataQna = Qna::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('mahasiswa_qna', compact('dataQna'));
    }

    public function storeQna(Request $request)
    {
        $request->validate([
            'subjek' => 'required|max:100',
            'pertanyaan' => 'required',
        ]);

        Qna::create([
            'user_id'    => Auth::id(),
            'subjek'     => $request->subjek,
            'pertanyaan' => $request->pertanyaan,
            'status'     => 'Terkirim'
        ]);

        return back()->with('success', 'Pertanyaan terkirim! Admin akan segera menjawabnya.');
    }
}