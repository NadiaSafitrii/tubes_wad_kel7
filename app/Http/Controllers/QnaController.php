<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\User;

class QnaController extends Controller
{
    // --- ADMIN AREA ---

    // 1. Admin melihat daftar pertanyaan
    public function indexAdmin()
    {
        // Ambil pertanyaan, urutkan yang terbaru di atas
        $pertanyaans = Pertanyaan::with('user')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin_qna', compact('pertanyaans'));
    }

    // 2. Admin menjawab pertanyaan
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required'
        ]);

        $qna = Pertanyaan::findOrFail($id);
        $qna->update([
            'jawaban' => $request->jawaban,
            'status'  => 'Dijawab'
        ]);

        return redirect()->route('admin.qna')->with('success', 'Jawaban berhasil dikirim!');
    }

    // 3. Admin menghapus pertanyaan (sesuai proposal CRUD Delete)
    public function destroy($id)
    {
        $qna = Pertanyaan::findOrFail($id);
        $qna->delete();

        return redirect()->route('admin.qna')->with('success', 'Pertanyaan dihapus.');
    }

    // --- USER AREA (SIMULASI UNTUK TES) ---
    
    // 4. User mengirim pertanyaan (Create)
    // Kita buat fungsi ini agar kamu bisa tes input pertanyaan dummy
    public function storeTanya(Request $request)
    {
        Pertanyaan::create([
            'user_id' => 1, // Dummy User ID
            'subjek' => $request->subjek ?? 'Umum',
            'pertanyaan' => $request->pertanyaan,
            'status' => 'Pending'
        ]);
        
        // Kembali ke halaman admin saja biar gampang tesnya
        return redirect()->back()->with('success', 'Pertanyaan dummy berhasil masuk!');
    }
}