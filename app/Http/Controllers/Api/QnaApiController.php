<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Qna;
use Illuminate\Http\Request;
// Pastikan baris ini tetap ada untuk mengimpor library PDF
use Barryvdh\DomPDF\Facade\Pdf;

class QnaApiController extends Controller
{
    /**
     * [READ & SEARCH] Sesuai Poin 3b & 4: Custom Search API
     * Menggunakan filter untuk pencarian kata kunci pada pertanyaan atau subjek.
     */
    public function index(Request $request)
    {
        $query = Qna::query();

        // Implementasi Poin 4: Custom Search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('pertanyaan', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('subjek', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $qnas = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => $request->has('search') ? 'Hasil Custom Search Q&A' : 'Daftar QnA Berhasil Diambil',
            'data' => $qnas
        ], 200);
    }

    /**
     * [CREATE] Sesuai Poin 3c: Membuat "Tiket Pertanyaan"
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'pertanyaan' => 'required',
            'subjek' => 'required'
        ]);

        $qna = Qna::create([
            'user_id' => $request->user_id,
            'subjek' => $request->subjek,
            'pertanyaan' => $request->pertanyaan,
            'status' => 'Terkirim'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tiket Pertanyaan berhasil dibuat',
            'data' => $qna
        ], 201);
    }

    /**
     * [UPDATE] Sesuai Poin 3d: Admin merespons secara terstruktur
     */
    public function update(Request $request, $id)
    {
        $qna = Qna::find($id);

        if (!$qna) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $qna->update([
            'jawaban' => $request->jawaban,
            'status' => 'Dijawab'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil memberikan respons',
            'data' => $qna
        ], 200);
    }

    /**
     * [DELETE] Sesuai Poin 3e: Menghapus data tidak relevan
     */
    public function destroy($id)
    {
        $qna = Qna::find($id);

        if (!$qna) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $qna->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Q&A berhasil dihapus'
        ], 200);
    }

    /**
     * [EXPORT] Sesuai Poin 5: Generate Buku Panduan Peminjaman (PDF)
     */
    public function exportPdf()
    {
        // Mengecek apakah library DomPDF sudah terinstal dengan benar
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Library PDF belum terinstal. Jalankan: composer require barryvdh/laravel-dompdf'
            ], 500);
        }

        $qnas = Qna::whereNotNull('jawaban')->get();

        $data = [
            'title' => 'Buku Panduan Peminjaman (Kumpulan Q&A)',
            'date' => date('d/m/Y'),
            'qnas' => $qnas
        ];

        // Memuat view pdf_qna (Pastikan file resources/views/pdf_qna.blade.php sudah ada)
        $pdf = Pdf::loadView('pdf_qna', $data);

        return $pdf->download('Buku_Panduan_Peminjaman.pdf');
    }
}