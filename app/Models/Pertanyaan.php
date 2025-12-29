<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    
    protected $guarded = []; // Izinkan semua kolom diisi

    // Relasi ke User (Penanya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}