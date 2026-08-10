<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom pada tabel bukus diizinkan untuk diisi massal
    protected $guarded = ['id'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}