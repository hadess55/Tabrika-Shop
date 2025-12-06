@extends('layouts.public')

@section('title', 'PRODUK')

@section('content')

    <section class="py-10 bg-gradient-to-b from-orange-400 via-orange-300 to-slate-50 border-orange-200">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Semua <span class="text-white">Produk</span>
                </h1>
                <p class="mt-3 text-gray-900 text-sm leading-relaxed">
                    Temukan semua produk yang tersedia pada sistem. Stok selalu terupdate secara otomatis dari dashboard
                    admin.
                </p>
            </div>

            <div class="flex justify-center md:justify-end">
                <img src="{{ asset('logo/tabrika-logo.png') }}" class="h-40 w-40 md:h-52 md:w-52 drop-shadow-lg"
                    alt="Logo">
            </div>

        </div>
    </section>



    {{-- SEARCH BAR --}}
    <section class="py-6">
        <div class="max-w-6xl mx-auto px-4">
            <form method="GET" action="{{ route('product.page') }}" class="flex gap-3">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kode / nama produk..."
                    class="flex-1 rounded-full border-gray-300 text-sm px-4 py-2
                          focus:border-orange-500 focus:ring-orange-500">

                <button class="px-5 py-2 rounded-full bg-orange-600 text-white text-sm hover:bg-orange-700 transition">
                    Cari
                </button>

                @if (request('search'))
                    <a href="{{ route('product.page') }}"
                        class="px-5 py-2 rounded-full border border-slate-300 text-gray-600 text-sm hover:bg-slate-100 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>



    <section class="pb-12">
    <div class="max-w-6xl mx-auto px-4">

        @if ($produk->count())

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($produk as $item)
                    @php
                        $totalStok = $item->total_stok; // dari accessor di model
                    @endphp

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                        {{-- Gambar --}}
                        <div class="h-40 bg-slate-100 rounded-lg flex items-center justify-center mb-3">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     class="h-full object-contain"
                                     alt="{{ $item->namaBarang }}">
                            @else
                                <img src="{{ asset('logo/tabrika-logo.png') }}"
                                     class="h-full object-contain"
                                     alt="logo">
                            @endif
                        </div>

                        {{-- Kode --}}
                        <p class="text-xs text-slate-400 uppercase tracking-wide">
                            {{ $item->kode }}
                        </p>

                        {{-- Nama --}}
                        <h3 class="font-semibold text-gray-900 text-sm mt-1">
                            {{ $item->namaBarang }}
                        </h3>

                        {{-- Ukuran --}}
                        <p class="text-xs text-gray-600 mt-1">
                            Ukuran:
                            @if ($item->size->count())
                                <span class="font-medium">
                                    {{ $item->size->pluck('ukuran')->join(', ') }}
                                </span>
                            @else
                                <span class="font-medium text-gray-400">-</span>
                            @endif
                        </p>

                        <div class="mt-3 flex items-center justify-between">

                            {{-- STOK BADGE (total semua size) --}}
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if ($totalStok == 0)
                                        bg-red-100 text-red-700
                                    @elseif ($totalStok < 5)
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-green-100 text-green-700
                                    @endif
                                ">
                                Stok: {{ $totalStok }}
                            </span>

                            {{-- DETAIL --}}
                            <a href="{{ route('product.show', $item->id) }}"
                               class="px-3 py-1.5 text-xs rounded-full border border-orange-600 text-orange-600
                                      hover:bg-orange-600 hover:text-white transition">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-6 border-t border-gray-100 pt-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-xs text-gray-500">
                    <div>
                        Menampilkan
                        <span class="font-semibold">
                            {{ $produk->firstItem() ?? 0 }}–{{ $produk->lastItem() ?? 0 }}
                        </span>
                        dari
                        <span class="font-semibold">
                            {{ $produk->total() }}
                        </span>
                        produk
                    </div>

                    <div class="self-end md:self-auto">
                        {{ $produk->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>

        @else
            <div class="bg-white border border-slate-200 rounded-xl p-6 text-center text-gray-500">
                Tidak ada produk ditemukan.
            </div>
        @endif

    </div>
</section>


@endsection


@push('scripts')
@endpush
