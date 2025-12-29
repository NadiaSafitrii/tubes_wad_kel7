<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    
    // protected $guarded = []; artinya semua kolom boleh diisi (mass assignment)
    protected $guarded = []; 
}