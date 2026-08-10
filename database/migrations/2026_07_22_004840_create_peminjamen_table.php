<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('peminjamans', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users (siapa yang meminjam)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // Relasi ke tabel bukus (buku apa yang dipinjam)
        $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali')->nullable();
        // Status transaksi: dipinjam atau dikembalikan
        $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
