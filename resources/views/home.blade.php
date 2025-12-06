@extends('layouts.public')

@section('title', 'TABRIKA SHOP')

@section('content')
    <section class="py-12 bg-gradient-to-b from-orange-500 via-orange-400 to-slate-50  mb-5">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            <div class="order-2 md:order-1">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Tabrika <span class="text-white">Shop</span>
                </h1>
                <p class="mt-3 text-sm md:text-base text-white leading-relaxed">
                    Temukan produk terbaik kami dengan informasi stok yang selalu terbaru. TabrikaShop memastikan pengalaman
                    belanja yang jelas dan terpercaya.
                </p>
            </div>


            <div class="order-1 md:order-2 flex justify-center md:justify-end">
                <div class="relative">

                    <div class="absolute inset-0 rounded-full bg-orange-500/40 blur-2xl animate-pulse"></div>

                    <img src="{{ asset('logo/tabrika-logo.png') }}" alt="Logo Tabrika"
                        class="relative h-56 w-56 md:h-64 md:w-64 lg:h-72 lg:w-72
                           object-contain drop-shadow-xl
                           transform hover:scale-105 transition-transform duration-300 ease-out">
                </div>
            </div>

        </div>
    </section>

    <section class="mb-6">
        <div
            class="max-w-6xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm px-5 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="text-sm text-gray-600">
                @if (!empty($search))
                    Menampilkan produk untuk kata kunci:
                    <span class="font-semibold text-gray-900">"{{ $search }}"</span>
                @else
                    Cari produk berdasarkan kode atau nama barang.
                @endif
            </div>

            <form action="{{ route('shop') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kode / nama produk..."
                    class="w-56 md:w-72 rounded-full border-gray-300 text-sm
                               focus:border-orange-500 focus:ring-orange-500">
                <button type="submit"
                    class="px-4 py-2 text-sm rounded-full bg-orange-600 text-white hover:bg-orange-700 transition">
                    Cari
                </button>
                @if (!empty($search))
                    <a href="{{ route('shop') }}"
                        class="px-4 py-2 text-sm rounded-full border border-slate-300 text-gray-600 hover:bg-slate-100 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    <section id="produk" class="pb-10 max-w-6xl mx-auto">
        @if ($produk->count())

            <div class="flex items-center justify-between mb-6 ">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">Produk Tersedia</h2>
                    <p class="text-sm text-gray-500 mt-1">Geser atau biarkan autoplay berjalan.</p>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="scrollProdukCarousel(-1)"
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-slate-300
                                       text-slate-600 hover:bg-slate-100 transition">
                        ‹
                    </button>

                    <button type="button" onclick="scrollProdukCarousel(1)"
                        class="w-9 h-9 flex items-center justify-center rounded-full border border-slate-300
                                       text-slate-600 hover:bg-slate-100 transition">
                        ›
                    </button>
                </div>
            </div>

            {{-- CAROUSEL --}}
            <div id="produkCarousel"
                class="flex gap-5 overflow-x-auto pb-2 scroll-smooth snap-x snap-mandatory whitespace-nowrap no-underline">
                @foreach ($produk as $item)
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden 
                                    w-64 sm:w-72 shrink-0 snap-start no-underline select-none hover:shadow-md transition">

                        {{-- Gambar --}}
                        <div class="h-40 bg-slate-100 flex items-center justify-center">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="h-full object-contain"
                                    alt="{{ $item->namaBarang }}">
                            @else
                                <img src="{{ asset('logo/tabrika-logo.png') }}" class="h-full object-contain"
                                    alt="logo">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-4">
                            <p class="text-xs text-slate-400 uppercase tracking-wide">{{ $item->kode }}</p>

                            <h3 class="font-semibold text-gray-900 text-sm mt-1">
                                {{ $item->namaBarang }}
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                Ukuran: <span class="font-medium">{{ $item->ukuran }}</span>
                            </p>

                            <div class="mt-3 flex items-center justify-between">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if ($item->jumlahBarang == 0) bg-red-100 text-red-700
                                        @elseif($item->jumlahBarang < 5)
                                            bg-yellow-100 text-yellow-700
                                        @else
                                            bg-green-100 text-green-700 @endif
                                    ">
                                    Stok: {{ $item->jumlahBarang }}
                                </span>

                                <a href="{{ route('product.show', $item->id) }}"
                                    class="px-3 py-1.5 text-xs rounded-full border border-orange-600 text-orange-600
                                      hover:bg-orange-600 hover:text-white transition">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-xs text-slate-500">
                Menampilkan {{ $produk->count() }} produk yang tersedia.
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center text-sm text-gray-500">
                Belum ada produk dengan stok tersedia. Silakan tambahkan barang dari dashboard admin.
            </div>
        @endif
    </section>

    {{-- SECTION CTA BAWAH --}}
    <section class="pb-10 max-w-6xl mx-auto">
        <div
            class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-3xl px-8 py-8 text-white flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold mb-2">Data stok selalu ter-update.</h2>
                <p class="text-sm text-orange-100 max-w-md">
                    Setiap perubahan stok di dashboard admin akan langsung tercermin pada halaman penjualan ini.
                </p>
            </div>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2.5 rounded-full bg-white text-orange-700 text-sm font-semibold hover:bg-slate-100 transition">
                    Kelola Stok di Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 rounded-full bg-white text-orange-700 text-sm font-semibold hover:bg-slate-100 transition">
                    Login
                </a>
            @endauth
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let produkCarouselEl = null;
        let autoPlayInterval = null;

        function scrollProdukCarousel(dir) {
            if (!produkCarouselEl) return;
            produkCarouselEl.scrollBy({
                left: 300 * dir,
                behavior: 'smooth'
            });
        }

        function startAutoPlay() {
            if (!produkCarouselEl) return;

            autoPlayInterval = setInterval(() => {
                if (produkCarouselEl.scrollLeft + produkCarouselEl.clientWidth >= produkCarouselEl.scrollWidth -
                    20) {
                    produkCarouselEl.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    produkCarouselEl.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                }
            }, 3000);
        }

        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
                autoPlayInterval = null;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            produkCarouselEl = document.getElementById('produkCarousel');
            if (!produkCarouselEl) return;

            // pause & resume saat user scroll manual
            produkCarouselEl.addEventListener('scroll', () => {
                stopAutoPlay();
                clearTimeout(produkCarouselEl._scrollTimer);
                produkCarouselEl._scrollTimer = setTimeout(() => {
                    startAutoPlay();
                }, 1500);
            });

            startAutoPlay();
        });
    </script>
@endpush
