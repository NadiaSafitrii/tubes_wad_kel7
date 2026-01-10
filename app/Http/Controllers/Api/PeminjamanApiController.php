<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Mengambil dari tabel users sebagai simulasi
use Illuminate\Http\Request;

class PeminjamanApiController extends Controller
{
    /**
     * [SIMULASI SSO] Mengambil data identitas peminjam (Poin 4)
     */
    public function getIdentitas($nim)
    {
        // Simulasi mencari data mahasiswa berdasarkan NIM
        $user = User::where('nim', $nim)->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $user->name,
                    'nim'  => $user->nim,
                    'prodi' => $user->prodi ?? 'Sistem Informasi'
                ]
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data mahasiswa tidak ditemukan'
        ], 404);
    }
}
