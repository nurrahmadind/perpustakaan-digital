<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit agar tidak keliru dibaca 'peminjaman'
    protected $table = 'peminjamans';

    // Mengizinkan mass assignment untuk semua kolom kecuali id
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}