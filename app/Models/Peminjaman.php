<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'peminjamans'; // Memastikan nama tabel benar

    // Relasi: Satu peminjaman dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu peminjaman meminjam satu Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}