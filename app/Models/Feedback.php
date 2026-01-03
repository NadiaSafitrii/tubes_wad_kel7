<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan file migrasi Anda
    protected $table = 'feedbacks';

    // Kolom yang diizinkan untuk diisi (Mass Assignment)
    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'rating',
        'komentar'
    ];

    // Menghubungkan feedback kembali ke data peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}