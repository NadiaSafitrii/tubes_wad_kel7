<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qna; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QnaController extends Controller
{
    // --- Admin Qna ---

    // 1. Admin melihat daftar pertanyaan
    public function indexAdmin()
    {
        // Ambil data dari tabel qnas, urutkan yang terbaru
        $qnaList = Qna::with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Pastikan variabel yang dikirim adalah 'qnaList'
        return view('admin_qna', compact('qnaList'));
    }

    // 2. Admin menjawab pertanyaan
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required'
        ]);

        $qna = Qna::findOrFail($id);
        $qna->update([
            'jawaban' => $request->jawaban,
            'status'  => 'Dijawab' // Status harus sesuai dengan Enum di database
        ]);

        return redirect()->route('admin.qna')->with('success', 'Jawaban berhasil dikirim!');
    }

    // 3. Admin menghapus pertanyaan
    public function destroy($id)
    {
        $qna = Qna::findOrFail($id);
        $qna->delete();

        return redirect()->route('admin.qna')->with('success', 'Pertanyaan dihapus.');
    }

    // --- User Qna ---
    
    public function storeTanya(Request $request)
    {
        $request->validate([
            'subjek' => 'required',
            'pertanyaan' => 'required'
        ]);

        Qna::create([
            'user_id' => Auth::id(), 
            'subjek' => $request->subjek,
            'pertanyaan' => $request->pertanyaan,
            'status' => 'Terkirim'
        ]);
        
        return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim!');
    }
}