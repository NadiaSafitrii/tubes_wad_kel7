<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'rating'        => 'required|integer|min:1|max:5',
            'ulasan'        => 'nullable|string' 
        ]);

        $exists = Feedback::where('peminjaman_id', $request->peminjaman_id)->exists();
        if ($exists) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk peminjaman ini.');
        }

        Feedback::create([
            'peminjaman_id' => $request->peminjaman_id,
            'user_id'       => Auth::id(),
            'rating'        => $request->rating,
            'ulasan'        => $request->ulasan, 
        ]);

        return back()->with('success', 'Terima kasih! Feedback Anda telah tersimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'ulasan'   => 'nullable|string' 
        ]);

        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $feedback->update([
            'rating'   => $request->rating,
            'ulasan'   => $request->ulasan, 
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::where('id', $id)
                            ->where('user_id', Auth::id()) 
                            ->firstOrFail();

        $feedback->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}