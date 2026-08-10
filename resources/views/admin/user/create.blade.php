<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Anggota Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Password</label>
                        <input type="password" name="password" class="border-gray-300 rounded-md shadow-sm w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Role / Hak Akses</label>
                        <select name="role" class="border-gray-300 rounded-md shadow-sm w-full" required>
                            <option value="user">User / Siswa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded-md">Simpan</button>
                    <a href="{{ route('admin.user.index') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>