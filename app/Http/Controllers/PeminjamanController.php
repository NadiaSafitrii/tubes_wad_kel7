<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Barang;
use App\Models\Qna;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // ==========================================
    // 1. KELOLA BARANG (KHUSUS ADMIN)
    // ==========================================
    
    // Nampilin tabel daftar barang logistik
    public function indexBarang()
    {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    // Buka form buat input barang baru
    public function createBarang()
    {
        return view('admin.barang.create');
    }

    // Nyimpen barang baru yang diinput admin ke database
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

    // Buka form buat edit data barang
    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    // Proses update data barang setelah diedit
    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect()->route('admin.barang.index')->with('success', 'Data barang sudah diperbarui.');
    }

    // Hapus barang dari sistem logistik
    public function destroyBarang($id)
    {
        Barang::findOrFail($id)->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }


    // ==========================================
    // 2. VERIFIKASI PEMINJAMAN (KHUSUS ADMIN)
    // ==========================================

    // Laman buat admin liat siapa saja yang mau pinjam barang
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin_verifikasi', compact('peminjamans'));
    }

    // Admin klik tombol setuju (Approve)
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Approved']);
        
        // Otomatis ubah status barang jadi 'Dipinjam'
        Barang::where('id', $peminjaman->barang_id)->update(['status' => 'Dipinjam']);
        
        return back()->with('success', 'Peminjaman sudah disetujui.');
    }

    // Admin klik tombol tolak (Reject)
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Rejected']);
        return back()->with('success', 'Peminjaman telah ditolak.');
    }


    // ==========================================
    // 3. FITUR MAHASISWA (USER PANEL)
    // ==========================================

    // Beranda dashboard buat mahasiswa
    public function dashboardMahasiswa() 
    { 
        return view('mahasiswa_dashboard'); 
    }

    // Mahasiswa liat barang apa saja yang tersedia
    public function ketersediaanMahasiswa()
    {
        $barangs = Barang::all();
        return view('mahasiswa_ketersediaan', compact('barangs'));
    }

    // Cek status pengajuan (Tracking) - Ada fitur hapus/silang di sini
    public function status()
    {
        $peminjamans = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('status', compact('peminjamans'));
    }

    // Liat riwayat pinjaman lama. Pake paginate biar ngga error ->links()
    public function riwayatMahasiswa()
    {
        $riwayats = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    // Buka form pengajuan pinjam. $pending_pinjams dikirim biar tabel pembatalan muncul
    public function create()
    {
        $barangs = Barang::where('status', 'Tersedia')->get();
        $pending_pinjams = Peminjaman::with('barang')
                            ->where('user_id', Auth::id())
                            ->where('status_approval', 'Pending')
                            ->get();
        return view('peminjaman_create', compact('barangs', 'pending_pinjams'));
    }

    // Proses kirim form pengajuan pinjaman
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => 'required',
            'tgl_pinjam'  => 'required|date',
            'file_surat'  => 'required|mimes:pdf,jpg,png|max:2048'
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
        return redirect()->route('peminjaman.status')->with('success', 'Berhasil mengajukan pinjaman!');
    }

    // Tombol silang untuk hapus tracking status dari dashboard
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cek apakah yang hapus itu pemilik datanya atau admin
        if ($peminjaman->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $peminjaman->delete();
            return back()->with('success', 'Data sudah dihapus dari daftar.');
        }
        return back()->with('error', 'Kamu nggak punya akses buat hapus ini.');
    }

    // Fitur QnA buat mahasiswa
    public function qnaMahasiswa()
    {
        $dataQna = Qna::where('user_id', Auth::id())->latest()->get();
        return view('mahasiswa_qna', compact('dataQna'));
    }
}