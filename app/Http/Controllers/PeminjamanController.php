<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Barang;
use App\Models\Qna;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 

class PeminjamanController extends Controller
{
    // =========================
    // KELOLA BARANG (ADMIN)
    // =========================
    
    // Menampilkan daftar barang
    public function indexBarang()
    {
        $barangs = Barang::all();
        return view('ketersediaan', compact('barangs')); 
    }

    // Menampilkan form tambah barang
    public function createBarang()
    {
        return view('barang_create');
    }

    // Simpan data barang baru
    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required',
            'status'      => 'required'
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang baru berhasil ditambahkan.');
    }

    // Menampilkan form edit barang
    public function editBarang($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang_edit', compact('barang')); 
    }

    // Update data barang
    public function updateBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('admin.barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    // Hapus data barang
    public function destroyBarang($id)
    {
        Barang::findOrFail($id)->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }


    // =========================
    // VERIFIKASI PEMINJAMAN (ADMIN)
    // =========================

    // Daftar pengajuan peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['barang', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_verifikasi', compact('peminjamans'));
    }

    // Setujui peminjaman
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Approved']);

        Barang::where('id', $peminjaman->barang_id)
            ->update(['status' => 'Dipinjam']);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    // Tolak peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_approval' => 'Rejected']);

        return back()->with('success', 'Peminjaman telah ditolak.');
    }


    // =========================
    // FITUR MAHASISWA
    // =========================

    // Halaman dashboard mahasiswa
    public function dashboardMahasiswa()
    { 
        return view('mahasiswa_dashboard'); 
    }

    // Daftar barang yang bisa dipinjam
    public function ketersediaanMahasiswa()
    {
        $barangs = Barang::all();
        return view('mahasiswa_ketersediaan', compact('barangs'));
    }

    // Detail barang
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang_detail', compact('barang')); 
    }

    // Form pengajuan peminjaman
    public function create()
    {
        $barangs = Barang::where('status', 'Tersedia')->get();

        $pending_pinjams = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->where('status_approval', 'Pending')
            ->get();

        return view('peminjaman_create', compact('barangs', 'pending_pinjams'));
    }

    // Simpan pengajuan peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => 'required|exists:barangs,id',
            'nim'         => 'required',
            'nama'        => 'required',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'file_surat'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file_surat')) {
            $path = $request->file('file_surat')
                ->store('surat_peminjaman', 'public');
        }

        $user = User::where('nim', $request->nim)->first();
        $userId = $user ? $user->id : Auth::id();

        Peminjaman::create([
            'user_id'        => $userId,
            'barang_id'      => $request->barang_id,
            'nama'           => $request->nama,
            'nim'            => $request->nim,
            'tgl_pinjam'     => $request->tgl_pinjam,
            'tgl_kembali'    => $request->tgl_kembali,
            'durasi'         => $request->durasi,
            'keperluan'      => $request->keperluan,
            'file_surat'     => $path,
            'status_approval'=> 'Pending',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    // Hapus data peminjaman
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $peminjaman->delete();
            return back()->with('success', 'Data peminjaman berhasil dihapus.');
        }

        return back()->with('error', 'Akses tidak diizinkan.');
    }
    
    // Status pengajuan peminjaman
    public function status()
    {
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('status', compact('peminjamans'));
    }

    // Riwayat peminjaman mahasiswa
    public function riwayatMahasiswa()
    {
        $riwayats = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa_riwayat', compact('riwayats'));
    }

    // QnA mahasiswa
    public function qnaMahasiswa()
    {
        $dataQna = Qna::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('mahasiswa_qna', compact('dataQna'));
    }

    public function storeQna(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
        ]);

        Qna::create([
            'user_id'    => Auth::id(),
            'pertanyaan' => $request->pertanyaan,
            'subjek'     => 'Umum', 
        ]);

        return back()->with('success', 'Pertanyaan berhasil dikirim.');
    }


    // =========================
    // CETAK BUKTI PEMINJAMAN
    // =========================

    public function cetakBukti($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);

        // Batasi akses (pemilik data atau admin)
        if ($peminjaman->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // Bukti hanya bisa dicetak jika sudah disetujui
        if ($peminjaman->status_approval !== 'Approved') {
            return back()->with('error', 'Bukti hanya tersedia untuk peminjaman yang disetujui.');
        }

        $data = [
            'peminjaman' => $peminjaman,
            'tgl_cetak'  => Carbon::now()->translatedFormat('d F Y'),
            'tgl_pinjam' => Carbon::parse($peminjaman->tgl_pinjam)
                                ->translatedFormat('l, d F Y'),
            'tgl_kembali'=> Carbon::parse($peminjaman->tgl_kembali)
                                ->translatedFormat('l, d F Y'),
        ];

        $pdf = Pdf::loadView('peminjaman_pdf', $data);

        return $pdf->download('Bukti_Pinjam_' . $peminjaman->nama . '.pdf');
    }
}
