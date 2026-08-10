<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan blok kode ini ada di dalam function run()
        User::create([
            'name' => 'Administrator Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@perpus.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        Buku::create([
            'kode_buku' => 'BK-001',
            'judul' => 'Pemrograman Web Laravel Dasar',
            'pengarang' => 'Eko Kurniawan',
            'penerbit' => 'Media Ilmu',
            'stok' => 5,
        ]);
    }
}