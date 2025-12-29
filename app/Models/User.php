<?php

namespace App\Models;

// PENTING: Jangan pakai 'use Illuminate\Database\Eloquent\Model;'
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Pastikan semua kolom ini boleh diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
    ];

    // Sembunyikan password agar tidak tampil di output JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Fitur baru Laravel agar password otomatis di-hash
    ];
}