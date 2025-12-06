<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Ringkasan singkat kondisi stok barang di sistem.
                </p>
            </div>

            <a href="{{ route('barang.index') }}"
               class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm rounded-lg shadow-sm transition">
                Kelola Barang
            </a>
        </div>
    </x-slot>

    <div class="px-4 md:px-8 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- KARTU RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Jenis Barang</p>
                <p class="mt-3 text-3xl font-bold text-gray-800">{{ $totalJenisBarang }}</p>
                <p class="mt-1 text-xs text-gray-400">Jumlah kode / item yang terdaftar.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">Total Stok Barang</p>
                <p class="mt-3 text-3xl font-bold text-gray-800">{{ $totalStokBarang }}</p>
                <p class="mt-1 text-xs text-gray-400">Akumulasi seluruh stok yang tersedia (semua ukuran).</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">Barang Stok Menipis</p>
                <p class="mt-3 text-3xl font-bold text-yellow-500">{{ $stokMenipis }}</p>
                <p class="mt-1 text-xs text-gray-400">Total stok &lt; 5 dan &gt; 0.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase">Barang Stok Habis</p>
                <p class="mt-3 text-3xl font-bold text-red-500">{{ $stokHabis }}</p>
                <p class="mt-1 text-xs text-gray-400">Perlu restock segera.</p>
            </div>
        </div>

        {{-- TABEL BARANG STOK TERENDAH --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Barang dengan Stok Terendah</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        5 barang dengan jumlah stok paling sedikit (di atas 0, akumulasi semua ukuran).
                    </p>
                </div>
                <a href="{{ route('barang.index') }}" class="text-xs text-orange-600 hover:underline">
                    Lihat semua barang
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-xs uppercase tracking-wide">
                            <th class="px-6 py-3 font-semibold">Kode</th>
                            <th class="px-6 py-3 font-semibold">Nama Barang</th>
                            <th class="px-6 py-3 font-semibold">Varian Ukuran</th>
                            <th class="px-6 py-3 font-semibold">Total Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse ($barangStokTerendah as $b)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-600 whitespace-nowrap">{{ $b->kode }}</td>
                                <td class="px-6 py-3 font-medium">{{ $b->namaBarang }}</td>

                                {{-- Varian ukuran + stok per ukuran --}}
                                <td class="px-6 py-3">
                                    @if($b->size->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($b->size as $s)
                                                <span class="px-2 py-0.5 rounded-full border border-gray-200 bg-gray-50 text-xs text-gray-700">
                                                    {{ $s->ukuran }} ({{ $s->jumlah }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">Belum ada data ukuran</span>
                                    @endif
                                </td>

                                {{-- Total stok --}}
                                <td class="px-6 py-3">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            @if($b->total_stok < 5)
                                                bg-yellow-100 text-yellow-700
                                            @else
                                                bg-orange-100 text-orange-700
                                            @endif">
                                        {{ $b->total_stok }} Unit
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500 text-sm">
                                    Belum ada data barang atau stok masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
