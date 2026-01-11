<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;

class RestoreBarangSeeder extends Seeder
{
    public function run()
    {
        // Disable Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Barang::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'nama_barang' => 'Proyektor Epson EB-X51',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gedung A RT 01',
                'spesifikasi' => '3600 Lumens, XGA, HDMI/VGA',
                'status' => 'Tersedia'
            ],
            [
                'nama_barang' => 'Kamera Canon EOS 3000D',
                'kategori' => 'Audio/Video',
                'lokasi' => 'Gedung K (Logistik)',
                'spesifikasi' => 'DSLR, 18MP, Lens Kit 18-55mm',
                'status' => 'Tersedia'
            ],
            [
                'nama_barang' => 'Speaker Portable JBL',
                'kategori' => 'Audio',
                'lokasi' => 'Gedung A',
                'spesifikasi' => 'Bluetooth, Wireless Mic include',
                'status' => 'Tersedia'
            ],
            [
                'nama_barang' => 'Kursi Lipat Chitose',
                'kategori' => 'Fasilitas',
                'lokasi' => 'Gedung C',
                'spesifikasi' => 'Metal, Red Color, 50 Unit',
                'status' => 'Tersedia'
            ],
            [
                'nama_barang' => 'Kabel HDMI 15 Meter',
                'kategori' => 'Elektronik',
                'lokasi' => 'Lemari 2',
                'spesifikasi' => 'High Speed, Gold Plated',
                'status' => 'Tersedia'
            ]
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }

        $this->command->info('Data Barang berhasil dipulihkan (5 item default).');
    }
}
