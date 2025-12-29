<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    // 1. Tampilkan Form Tambah
    public function create()
    {
        return view('barang_create');
    }

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'lokasi' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        Barang::create($request->all());

        return redirect('/ketersediaan')->with('success', 'Barang berhasil ditambahkan!');
    }

    // 3. Tampilkan Form Edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang_edit', compact('barang'));
    }

    // 4. Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'lokasi' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect('/ketersediaan')->with('success', 'Barang berhasil diperbarui!');
    }

    // 5. Hapus Data
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/ketersediaan')->with('success', 'Barang berhasil dihapus!');
    }
}