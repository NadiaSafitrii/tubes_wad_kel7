<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'peminjamans'; 

    // Relasi ke User (Mahasiswa yang meminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Barang yang dipinjam
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // TAMBAHKAN INI: Relasi One-to-One ke Feedback
    public function feedback()
    {
        // Satu data peminjaman hanya bisa memiliki satu feedback
        return $this->hasOne(Feedback::class, 'peminjaman_id');
    }
}