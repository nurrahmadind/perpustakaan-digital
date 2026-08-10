<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query katalog buku dengan fitur pencarian
        $bukus = Buku::where('stok', '>', 0)
                    ->when($search, function ($query, $search) {
                        return $query->where('judul', 'like', "%{$search}%")
                                     ->orWhere('pengarang', 'like', "%{$search}%");
                    })
                    ->get();

        $riwayat = Peminjaman::with('buku')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('dashboard', compact('bukus', 'riwayat', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_kembali' => 'required|date|after:today',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('dashboard')->with('success', 'Berhasil meminjam buku. Silakan ambil buku di perpustakaan.');
    }

    // Fungsi bagi siswa untuk mengembalikan buku mandiri
    public function updateStatus(Peminjaman $peminjaman)
    {
        // Pastikan transaksi ini milik user yang sedang login
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->update(['status' => 'dikembalikan']);
            $peminjaman->buku->increment('stok');

            return redirect()->route('dashboard')->with('success', 'Buku berhasil dikembalikan ke perpustakaan.');
        }

        return redirect()->route('dashboard')->with('error', 'Status buku sudah dikembalikan.');
    }
}