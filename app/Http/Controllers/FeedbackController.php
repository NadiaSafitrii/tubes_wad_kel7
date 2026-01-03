<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * c. Create: User memberikan rating dan review kondisi barang
     */
    public function store(Request $request)
    {
        // Validasi input rating 1-5 dan komentar
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'rating'        => 'required|integer|min:1|max:5',
            'komentar'      => 'nullable|string'
        ]);

        // Simpan ke database
        Feedback::create([
            'peminjaman_id' => $request->peminjaman_id,
            'user_id'       => Auth::id(),
            'rating'        => $request->rating,
            'komentar'      => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih! Feedback Anda telah tersimpan.');
    }

    /**
     * d. Update: Memperbarui data feedback jika user ingin mengedit ulasan
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string'
        ]);

        // Temukan feedback milik user yang sedang login
        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        // Proses update
        $feedback->update([
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    /**
     * e. Delete: Menghapus ulasan (Log)
     */
    public function destroy($id)
    {
        // Temukan feedback dan hapus
        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id()) // Pastikan hanya pemilik yang bisa hapus
                            ->firstOrFail();
        
        $feedback->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}