<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // 3c. Create: Menyimpan rating dan ulasan
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'rating'        => 'required|integer|min:1|max:5',
            'ulasan'        => 'nullable|string' // Diubah dari 'komentar' menjadi 'ulasan' agar sinkron
        ]);

        // Proteksi agar tidak ada ulasan ganda untuk satu peminjaman
        $exists = Feedback::where('peminjaman_id', $request->peminjaman_id)->exists();
        if ($exists) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk peminjaman ini.');
        }

        Feedback::create([
            'peminjaman_id' => $request->peminjaman_id,
            'user_id'       => Auth::id(),
            'rating'        => $request->rating,
            'ulasan'        => $request->ulasan, // Diubah menjadi 'ulasan' sesuai yang dipanggil di Blade Admin
        ]);

        return back()->with('success', 'Terima kasih! Feedback Anda telah tersimpan.');
    }

    // 3d. Update: Memperbarui ulasan
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'ulasan'   => 'nullable|string' // Diubah menjadi 'ulasan'
        ]);

        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $feedback->update([
            'rating'   => $request->rating,
            'ulasan'   => $request->ulasan, // Diubah menjadi 'ulasan'
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    // 3e. Delete: Menghapus ulasan
    public function destroy($id)
    {
        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id()) 
                            ->firstOrFail();

        $feedback->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}