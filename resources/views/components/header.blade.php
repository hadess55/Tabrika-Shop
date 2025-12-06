<header class="border-b border-slate-200 bg-white">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

        <a href="{{ route('shop') }}" class="flex items-center gap-3">
            <x-application-logo class="w-16 h-16 text-orange-600" />
            <span class="font-semibold text-lg text-gray-800">Tabrika Shop</span>
        </a>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium">

            <a href="{{ route('shop') }}"
                class="relative pb-1 transition
                      {{ request()->routeIs('shop') ? 'text-orange-600 font-semibold' : 'text-gray-700 hover:text-orange-600' }}">
                Home
                @if (request()->routeIs('shop'))
                    <span class="absolute left-0 -bottom-0.5 w-full h-[2px] bg-orange-600 rounded-full"></span>
                @endif
            </a>
            <a href="{{ route('product.page') }}"
                class="relative pb-1 transition
                      {{ request()->routeIs('product.page') ? 'text-orange-600 font-semibold' : 'text-gray-700 hover:text-orange-600' }}">
                Produk
                @if (request()->routeIs('product.page'))
                    <span class="absolute left-0 -bottom-0.5 w-full h-[2px] bg-orange-600 rounded-full"></span>
                @endif
            </a>


            @auth
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 rounded-full border border-orange-600 text-orange-600 hover:bg-orange-50 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="px-4 py-2 rounded-full border border-orange-600 text-orange-600 hover:bg-orange-50 transition">
                    Login
                </a>
            @endauth
        </div>

        <div class="md:hidden" x-data="{ open: false }">

            <button @click="open = !open"
                class="p-2 border rounded-md border-slate-300 text-gray-700 hover:bg-slate-100 transition">
                ☰
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute top-16 right-4 w-48 bg-white border border-slate-200 shadow-lg rounded-xl p-4 flex flex-col gap-3 text-sm z-50">

                <a href="{{ route('shop') }}" class="text-gray-700 hover:text-orange-600 transition">
                    Home
                </a>

                <a href="{{ route('product.page') }}" class="text-gray-700 hover:text-orange-600 transition">
                    Produk
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-orange-600 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
