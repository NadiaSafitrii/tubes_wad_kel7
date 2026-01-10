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
        $peminjamans = Peminjaman::with(['barang', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin_verifikasi', compact('peminjamans'));
    }

    // Admin Approve
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Approved']);
        
        Barang::where('id', $peminjaman->barang_id)->update(['status' => 'Dipinjam']);
        
        return back()->with('success', 'Peminjaman sudah disetujui.');
    }

    // Admin Reject
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Rejected']);
        return back()->with('success', 'Peminjaman telah ditolak.');
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
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('status', compact('peminjamans'));
    }

    // Liat riwayat pinjaman 
    public function riwayatMahasiswa()
    {
        $riwayats = Peminjaman::with('barang')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    // Form pengajuan pinjaman
    public function create()
    {
        $barangs = Barang::where('status', 'Tersedia')->get();
        $pending_pinjams = Peminjaman::with('barang')
                            ->where('user_id', Auth::id())
                            ->where('status_approval', 'Pending')
                            ->get();
        return view('peminjaman_create', compact('barangs', 'pending_pinjams'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Termasuk berkas pendukung sesuai Poin 2b)
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'nim'        => 'required',
            'nama'       => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali'=> 'required|date|after_or_equal:tgl_pinjam',
            'file_surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Poin 2b
        ]);

        // 2. Proses Unggah Berkas Berkas Pendukung (Poin 2b & 3b)
        $path = null;
        if ($request->hasFile('file_surat')) {
            // Berkas disimpan di folder storage/app/public/surat_peminjaman
            $path = $request->file('file_surat')->store('surat_peminjaman', 'public');
        }

        // 3. Simpan ke Database (Rancangan Operasi CRUD Poin 3b)
       Peminjaman::create([
        'user_id' => Auth::id(),
        'barang_id' => $request->barang_id,
        'nama' => $request->nama,
        'nim' => $request->nim,
        'tgl_pinjam' => $request->tgl_pinjam,
        'tgl_kembali' => $request->tgl_kembali, // Pastikan baris ini ada!
        'durasi' => $request->durasi,
        'keperluan' => $request->keperluan,
        'file_surat' => $path,
        'status_approval' => 'Pending',
    ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $peminjaman->delete();
            return back()->with('success', 'Data sudah dihapus dari daftar.');
        }
        return back()->with('error', 'Kamu tidak memiliki akses untuk menghapus.');
    }

    // Fitur QnA mahasiswa
    public function qnaMahasiswa()
    {
        $dataQna = Qna::where('user_id', Auth::id())->latest()->get();
        return view('mahasiswa_qna', compact('dataQna'));
    }

    public function storeQna(Request $request)
{
    // Validasi input
    $request->validate([
        'pertanyaan' => 'required',
    ]);

    \App\Models\Qna::create([
        'user_id'    => Auth::id(),
        'pertanyaan' => $request->pertanyaan,
        'subjek'     => 'Umum', 
    ]);

    return back()->with('success', 'Pertanyaan kamu berhasil dikirim!');
}
}