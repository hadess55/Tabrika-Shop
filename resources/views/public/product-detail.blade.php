@extends('layouts.public')

@section('title', 'Detail Produk - ' . $produk->namaBarang)

@section('content')

    <section class="py-8 bg-gradient-to-b from-orange-300 via-orange-200 to-slate-50 border-orange-200">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs text-orange-500 font-semibold tracking-wide mb-1">
                    Kode: {{ $produk->kode }}
                </p>
                <h1 class="text-4xl lg:text-3xl font-bold text-gray-900">
                    {{ $produk->namaBarang }}
                </h1>
            </div>

            <div class="flex items-center gap-3 justify-start md:justify-end">
                <a href="{{ route('product.page') }}"
                    class="px-4 py-2 rounded-full border-orange-600 bg-orange-500 text-white
                           hover:bg-orange-600 hover:text-white transition">
                    ← Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-center">
                <div class="relative">
                    <div class="absolute inset-0 rounded-3xl bg-orange-400/30 blur-2xl"></div>

                    <div
                        class="relative bg-slate-50 rounded-2xl border border-slate-100 h-64 md:h-80 w-64 md:w-80 flex items-center justify-center overflow-hidden">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->namaBarang }}"
                                class="h-full object-contain transform transition-transform duration-300 hover:scale-105">
                        @else
                            <img src="{{ asset('logo/tabrika-logo.png') }}" alt="logo"
                                class="h-full object-contain transform transition-transform duration-300 hover:scale-105">
                        @endif
                    </div>
                </div>
            </div>

 
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        {{ $produk->namaBarang }}
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Kode Produk: {{ $produk->kode }}
                    </p>
                </div>

                <div class="text-sm text-gray-700">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Pilihan Ukuran</h3>

                    @if ($produk->size->count())
                        <table class="w-full text-xs text-left border border-slate-200 rounded-lg overflow-hidden">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 border-b text-gray-600">Ukuran</th>
                                    <th class="px-3 py-2 border-b text-gray-600">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk->size as $s)
                                    <tr>
                                        <td class="px-3 py-2 border-b">{{ $s->ukuran }}</td>
                                        <td class="px-3 py-2 border-b">{{ $s->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-xs text-gray-500">
                            Belum ada data ukuran untuk produk ini.
                        </p>
                    @endif
                </div>

     
                @php
                    $totalStok = $produk->total_stok;
                @endphp

                <div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if ($totalStok == 0)
                                bg-red-100 text-red-700
                            @elseif($totalStok < 5)
                                bg-yellow-100 text-yellow-700
                            @else
                                bg-green-100 text-green-700
                            @endif
                        ">
                        @if ($totalStok == 0)
                            Stok Habis
                        @else
                            Total Stok: {{ $totalStok }}
                        @endif
                    </span>
                </div>


                <div class="pt-2 flex justify-end">
                    <button onclick="history.back()"
                        class="px-4 py-2 rounded-full border border-orange-600 text-orange-600
                               hover:bg-orange-600 hover:text-white transition">
                        Kembali
                    </button>
                </div>

            </div>
        </div>
    </section>

@endsection
