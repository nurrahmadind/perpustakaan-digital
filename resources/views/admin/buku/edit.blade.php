<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Data Buku') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Kode Buku</label>
                        <input type="text" name="kode_buku" value="{{ $buku->kode_buku }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Judul Buku</label>
                        <input type="text" name="judul" value="{{ $buku->judul }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pengarang</label>
                        <input type="text" name="pengarang" value="{{ $buku->pengarang }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ $buku->penerbit }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Stok</label>
                        <input type="number" name="stok" value="{{ $buku->stok }}" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded-md">Update</button>
                    <a href="{{ route('admin.buku.index') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>