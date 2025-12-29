<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'peminjamans'; 

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}