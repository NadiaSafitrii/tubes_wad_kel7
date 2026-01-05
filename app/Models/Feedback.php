<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    
    protected $table = 'feedbacks';

    
    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'rating',
        'komentar'
    ];

    
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}