@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex gap-2 items-center justify-between">

        {{-- Tombol SEBELUMNYA --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex items-center px-4 py-2 text-sm font-medium 
                       text-white bg-orange-300 border border-orange-300 cursor-not-allowed 
                       leading-5 rounded-md">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="inline-flex items-center px-4 py-2 text-sm font-medium 
                      text-white bg-orange-600 border border-orange-600 leading-5 rounded-md
                      hover:bg-orange-700 hover:border-orange-700
                      focus:outline-none focus:ring ring-orange-300 focus:border-orange-300
                      active:bg-orange-700 active:text-white
                      transition ease-in-out duration-150">
                Sebelumnya
            </a>
        @endif

        {{-- Tombol BERIKUTNYA --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="inline-flex items-center px-4 py-2 text-sm font-medium 
                      text-white bg-orange-600 border border-orange-600 leading-5 rounded-md
                      hover:bg-orange-700 hover:border-orange-700
                      focus:outline-none focus:ring ring-orange-300 focus:border-orange-300
                      active:bg-orange-700 active:text-white
                      transition ease-in-out duration-150">
                Berikutnya
            </a>
        @else
            <span
                class="inline-flex items-center px-4 py-2 text-sm font-medium 
                       text-white bg-orange-300 border border-orange-300 cursor-not-allowed
                       leading-5 rounded-md">
                Berikutnya
            </span>
        @endif

    </nav>
@endif
