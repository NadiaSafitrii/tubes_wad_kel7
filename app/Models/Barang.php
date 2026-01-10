<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    
    protected $guarded = []; 
    public $timestamps = false; 

    /**
     * Get peminjaman/booking records for this barang
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}