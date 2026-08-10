<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Anggota (User & Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.user.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-black font-semibold px-4 py-2 rounded-md mb-4 inline-block shadow">+ Tambah Anggota</a>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                <table class="w-full border-collapse border border-gray-300 mt-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 p-2">No</th>
                            <th class="border border-gray-300 p-2">Nama</th>
                            <th class="border border-gray-300 p-2">Email</th>
                            <th class="border border-gray-300 p-2">Role</th>
                            <th class="border border-gray-300 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $usr)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 p-2">{{ $usr->name }}</td>
                            <td class="border border-gray-300 p-2">{{ $usr->email }}</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $usr->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($usr->role) }}
                                </span>
                            </td>
                            <td class="border border-gray-300 p-2 text-center">
                                <a href="{{ route('admin.user.edit', $usr->id) }}" class="bg-amber-500 hover:bg-amber-600 text-black font-medium px-3 py-1 rounded text-sm shadow inline-block">Edit</a>
                                <form action="{{ route('admin.user.destroy', $usr->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus anggota ini?')">
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