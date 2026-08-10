<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Form Peminjaman Buku') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pilih Siswa / Anggota</label>
                        <select name="user_id" class="border-gray-300 rounded-md shadow-sm w-full" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($users as $usr)
                                <option value="{{ $usr->id }}">{{ $usr->name }} ({{ $usr->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pilih Buku (Stok Tersedia)</label>
                        <select name="buku_id" class="border-gray-300 rounded-md shadow-sm w-full" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Batas Pengembalian</label>
                        <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Simpan Peminjaman</button>
                    <a href="{{ route('admin.peminjaman.index') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>