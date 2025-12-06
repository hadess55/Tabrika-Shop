<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Manajemen Barang</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola data stok barang dengan mudah dan cepat.</p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 w-full md:w-auto">
                <form action="{{ route('barang.index') }}" method="GET"
                      class="flex gap-2 w-full md:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode / nama barang..."
                        class="flex-1 md:w-72 rounded-lg border-gray-300 text-sm
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
                   class="w-full md:w-auto text-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm rounded-lg shadow-sm transition">
                    + Tambah Barang
                </a>
            </div>
        </div>
    </x-slot>

    <div class="px-4 md:px-8 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8"
         x-data="{ showConfirm: false, deleteUrl: '' }">

        <div class="bg-white shadow rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">Daftar Barang</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-xs md:text-sm uppercase tracking-wide">
                            <th class="px-6 py-3 font-semibold">Kode</th>
                            <th class="px-6 py-3 font-semibold">Nama Barang</th>
                            <th class="px-6 py-3 font-semibold">Varian Ukuran</th>
                            <th class="px-6 py-3 font-semibold">Total Stok</th>
                            <th class="px-6 py-3 font-semibold">Gambar</th>
                            <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($barang as $b)
                            @php
                                $totalStok = $b->size->sum('jumlah');
                            @endphp
                            <tr class="hover:bg-gray-50 border-b border-gray-100">
                                <td class="px-6 py-4 align-top whitespace-nowrap">
                                    {{ $b->kode }}
                                </td>

                                <td class="px-6 py-4 align-top font-medium">
                                    {{ $b->namaBarang }}
                                </td>

                                {{-- Varian ukuran --}}
                                <td class="px-6 py-4 align-top">
                                    @if($b->size->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($b->size as $s)
                                                <span class="px-2 py-0.5 rounded-full border border-gray-200 bg-gray-50 text-xs text-gray-700">
                                                    {{ $s->ukuran }} ({{ $s->jumlah }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Belum ada data ukuran
                                        </span>
                                    @endif
                                </td>

                                {{-- Total stok --}}
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if($totalStok == 0)
                                            bg-red-100 text-red-700
                                        @elseif($totalStok < 5)
                                            bg-yellow-100 text-yellow-700
                                        @else
                                            bg-green-100 text-green-700
                                        @endif
                                    ">
                                        {{ $totalStok }} Unit
                                    </span>
                                </td>

                                {{-- Gambar --}}
                                <td class="px-6 py-4 align-top">
                                    @if ($b->gambar)
                                        <img src="{{ asset('storage/' . $b->gambar) }}"
                                             class="h-14 w-auto rounded border border-gray-200 object-contain">
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak ada</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('barang.edit', $b->id) }}"
                                           class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs md:text-sm rounded-lg transition">
                                            Edit
                                        </a>

                                        <button type="button"
                                            @click="showConfirm = true; deleteUrl = '{{ route('barang.destroy', $b->id) }}'"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm rounded-lg transition">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 text-sm">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-xs text-gray-500">
                    <div>
                        Menampilkan
                        <span class="font-semibold">
                            {{ $barang->firstItem() ?? 0 }}–{{ $barang->lastItem() ?? 0 }}
                        </span>
                        dari
                        <span class="font-semibold">
                            {{ $barang->total() }}
                        </span>
                        produk
                    </div>

                    <div class="self-end md:self-auto">
                        {{ $barang->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal konfirmasi hapus --}}
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
