<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Tombol Tambah Buku dengan warna hijau yang kontras -->
                <a href="{{ route('admin.buku.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-black font-semibold px-4 py-2 rounded-md mb-4 inline-block shadow">+ Tambah Buku</a>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                <table class="w-full border-collapse border border-gray-300 mt-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 p-2">No</th>
                            <th class="border border-gray-300 p-2">Kode Buku</th>
                            <th class="border border-gray-300 p-2">Judul</th>
                            <th class="border border-gray-300 p-2">Pengarang</th>
                            <th class="border border-gray-300 p-2">Penerbit</th>
                            <th class="border border-gray-300 p-2">Stok</th>
                            <th class="border border-gray-300 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukus as $index => $buku)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 p-2 text-center font-medium">{{ $buku->kode_buku }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->judul }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->pengarang }}</td>
                            <td class="border border-gray-300 p-2">{{ $buku->penerbit }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $buku->stok }}</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <!-- Tombol Edit dengan warna amber/kuning gelap agar teks terbaca jelas -->
                                <a href="{{ route('admin.buku.edit', $buku->id) }}" class="bg-amber-500 hover:bg-amber-600 text-black font-medium px-3 py-1 rounded text-sm shadow inline-block">Edit</a>
                                
                                <!-- Tombol Hapus dengan warna merah tegas -->
                                <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-black font-medium px-3 py-1 rounded text-sm shadow">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>