<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Manajemen Barang</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola data stok barang dengan mudah dan cepat.</p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <form action="{{ route('barang.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode / nama barang..."
                        class="w-56 md:w-72 rounded-lg border-gray-300 text-sm
                        focus:border-orange-500 focus:ring-orange-500">
                    <button type="submit"
                        class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm rounded-lg transition">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('barang.index') }}"
                            class="px-3 py-2 text-sm rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                            Reset
                        </a>
                    @endif
                </form>
                <a href="{{ route('barang.create') }}"
                    class=" p-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-sm transition">
                    + Tambah Barang
                </a>
            </div>


        </div>
    </x-slot>
    <div class="px-8 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ showConfirm: false, deleteUrl: '' }">



        <div class="bg-white shadow rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">Daftar Barang</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-sm uppercase tracking-wide">
                            <th class="px-6 py-3 font-semibold">Kode</th>
                            <th class="px-6 py-3 font-semibold">Nama Barang</th>
                            <th class="px-6 py-3 font-semibold">Ukuran</th>
                            <th class="px-6 py-3 font-semibold">Jumlah</th>
                            <th class="px-6 py-3 font-semibold">Gambar</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($barang as $b)
                            <tr class="hover:bg-gray-50 border-b border-gray-100">
                                <td class="px-6 py-4">{{ $b->kode }}</td>
                                <td class="px-6 py-4 font-medium">{{ $b->namaBarang }}</td>
                                <td class="px-6 py-4">{{ $b->ukuran }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('barang.updateJumlah', $b->id) }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <input type="number" name="jumlahBarang" value="{{ $b->jumlahBarang }}"
                                            min="0"
                                            class="w-20 rounded-lg border-gray-300 text-sm
                                                focus:border-orange-500 focus:ring-orange-500">

                                        <button type="submit"
                                            class="px-2.5 py-1 text-xs rounded-lg bg-orange-600 text-white hover:bg-orange-700 transition">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($b->gambar)
                                        <img src="{{ asset('storage/' . $b->gambar) }}"
                                            class="h-14 w-auto rounded border border-gray-200">
                                    @else
                                        <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('barang.edit', $b->id) }}"
                                            class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition">
                                            Edit
                                        </a>

                                        {{-- Tombol hapus pakai modal --}}
                                        <button type="button"
                                            @click="showConfirm = true; deleteUrl = '{{ route('barang.destroy', $b->id) }}'"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Menampilkan
                        <span class="font-semibold">
                            {{ $barang->firstItem() ?? 0 }}–{{ $barang->lastItem() ?? 0 }}
                        </span>
                        dari
                        <span class="font-semibold">
                            {{ $barang->total() }}
                        </span>
                        data
                    </div>

                    <div>
                        {{ $barang->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showConfirm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">

            <div class="absolute inset-0 bg-black/40" @click="showConfirm = false"></div>

            <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6" x-transition>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Barang?</h3>
                <p class="text-sm text-gray-600">
                    Tindakan ini tidak dapat dibatalkan. Yakin ingin menghapus barang ini dari sistem?
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button"
                        class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition"
                        @click="showConfirm = false">
                        Batal
                    </button>

                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
