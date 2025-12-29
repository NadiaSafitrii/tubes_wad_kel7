<?php

namespace Database\Seeders; 

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Barang;
use Carbon\Carbon;


class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        $barang = Barang::first() ?? Barang::create([
            'nama_barang' => 'Proyektor Epson X400',
            'kategori' => 'Elektronik',
            'lokasi' => 'Gedung Cacuk',
            'spesifikasi' => 'Warna hitam',
            
        ]);

        Peminjaman::create([
            'user_id' => $user->id,
            'barang_id' => $barang->id,
            'tgl_pinjam' => Carbon::now()->addDays(1),
            'tgl_kembali' => Carbon::now()->addDays(2),
            'durasi' => 1,
            'keperluan' => 'Presentasi Tugas Besar Arsitektur',
            'status_approval' => 'Pending', 
        ]);
        Peminjaman::create([
            'user_id' => $user->id,
            'barang_id' => $barang->id,
            'tgl_pinjam' => Carbon::now()->subDays(2),
            'tgl_kembali' => Carbon::now()->subDays(1),
            'durasi' => 1,
            'keperluan' => 'Kegiatan Forum Mahasiswa',
            'status_approval' => 'Approved', 
        ]);
        Peminjaman::create([
            'user_id' => $user->id,
            'barang_id' => $barang->id,
            'tgl_pinjam' => Carbon::now()->addDays(5),
            'tgl_kembali' => Carbon::now()->addDays(6),
            'durasi' => 1,
            'keperluan' => 'Acara Nobar Jurusan',
            'status_approval' => 'Rejected', 
        ]);
    }
}
 