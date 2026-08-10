<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('admin.peminjaman.create', compact('users', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok buku
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku ini sudah habis!');
        }

        // Simpan transaksi peminjaman
        Peminjaman::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        // Kurangi stok buku
        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Transaksi peminjaman berhasil dicatat.');
    }

    // Fungsi khusus untuk memproses pengembalian buku
    public function updateStatus(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->update(['status' => 'dikembalikan']);
            
            // Kembalikan stok buku
            $peminjaman->buku->increment('stok');

            return redirect()->route('admin.peminjaman.index')->with('success', 'Buku telah dikembalikan dan stok diperbarui.');
        }

        return redirect()->route('admin.peminjaman.index')->with('error', 'Status buku sudah dikembalikan sebelumnya.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Jika dihapus saat status masih dipinjam, kembalikan stok buku
        if ($peminjaman->status === 'dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data transaksi peminjaman berhasil dihapus.');
    }
}