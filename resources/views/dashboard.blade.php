<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog & Peminjaman Buku Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg shadow">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow">{{ session('error') }}</div>
            @endif

            <!-- Bagian 1: Daftar Katalog Buku Tersedia & Fitur Pencarian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                    <h3 class="text-lg font-bold text-gray-800">📚 Daftar Katalog Buku Tersedia</h3>
                    
                    <!-- Form Pencarian Buku -->
                    <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/pengarang..." class="border-gray-300 rounded-md shadow-sm text-sm px-3 py-1.5 w-full md:w-64">
                        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-black text-sm px-4 py-1.5 rounded-md shadow">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-3 py-1.5 rounded-md flex items-center">Reset</a>
                        @endif
                    </form>
                </div>
                
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 p-2">Kode</th>
                            <th class="border border-gray-300 p-2">Judul Buku</th>
                            <th class="border border-gray-300 p-2">Pengarang</th>
                            <th class="border border-gray-300 p-2">Penerbit</th>
                            <th class="border border-gray-300 p-2">Stok</th>
                            <th class="border border-gray-300 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bukus as $buku)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 text-center font-medium">{{ $buku->kode_buku }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->judul }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->pengarang }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->penerbit }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $buku->stok }}</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <form action="{{ route('user.pinjam') }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                    <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-black font-medium px-3 py-1 rounded text-sm shadow">Pinjam</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-4 text-center text-gray-500">Tidak ada buku ditemukan atau stok habis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bagian 2: Riwayat Peminjaman & Tombol Pengembalian Mandiri -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📖 Riwayat Peminjaman Buku Saya</h3>
                
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 p-2">No</th>
                            <th class="border border-gray-300 p-2">Judul Buku</th>
                            <th class="border border-gray-300 p-2">Tanggal Pinjam</th>
                            <th class="border border-gray-300 p-2">Batas Pengembalian</th>
                            <th class="border border-gray-300 p-2">Status</th>
                            <th class="border border-gray-300 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $r)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 p-2">{{ $r->buku->judul }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $r->tanggal_pinjam }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $r->tanggal_kembali }}</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $r->status === 'dipinjam' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="border border-gray-300 p-2 text-center">
                                @if($r->status === 'dipinjam')
                                    <form action="{{ route('user.kembali', $r->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-medium px-3 py-1 rounded text-sm shadow">Kembalikan</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="border border-gray-300 p-4 text-center text-gray-500">Belum ada riwayat peminjaman buku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>