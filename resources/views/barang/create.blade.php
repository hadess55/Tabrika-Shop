<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Tambah Barang</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Lengkapi form di bawah untuk menambahkan data barang ke dalam sistem.
                </p>
            </div>

            <a href="{{ route('barang.index') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg border border-gray-200 text-sm transition">
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="px-8 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-5 bg-red-100 border border-red-100 text-red-700 text-sm rounded-lg px-4 py-3">
                <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">Form Barang</h2>
            </div>

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data"
                  class="p-6 space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">

                    {{-- Kode --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="namaBarang" value="{{ old('namaBarang') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- MULTI SIZE + JUMLAH --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ukuran & Jumlah Stok <span class="text-red-500">*</span>
                        </label>

                        <p class="text-xs text-gray-500 mb-2">
                            Tambahkan beberapa ukuran untuk barang ini. Setiap ukuran memiliki jumlah stok masing-masing.
                        </p>

                        @php
                            $oldUkurans = old('ukuran', ['']);
                            $oldJumlahs = old('jumlah', ['']);
                        @endphp

                        <div id="size-container" class="space-y-2">

                            @foreach($oldUkurans as $index => $ukuran)
                                <div class="flex flex-col md:flex-row gap-2 size-row">
                                    <div class="flex-1">
                                        <input type="text" name="ukuran[]"
                                               value="{{ $ukuran }}"
                                               placeholder="Ukuran (mis. S, M, L, 40, 41)"
                                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    </div>
                                    <div class="w-full md:w-40">
                                        <input type="number" name="jumlah[]"
                                               value="{{ $oldJumlahs[$index] ?? '' }}"
                                               min="0"
                                               placeholder="Jumlah"
                                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                                    </div>
                                    <div class="flex items-center">
                                        <button type="button"
                                                class="remove-size-row px-3 py-2 text-xs rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition
                                                       {{ $loop->first ? 'hidden' : '' }}">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <button type="button" id="add-size-row"
                                class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg border border-dashed border-orange-400 text-xs text-orange-600 hover:bg-orange-50 transition">
                            + Tambah Ukuran
                        </button>
                    </div>

                    {{-- Gambar --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Barang (opsional)
                        </label>
                        <input type="file" name="gambar"
                               class="block w-full text-sm text-gray-700
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-orange-50 file:text-orange-700
                                      hover:file:bg-orange-100">
                        <p class="text-xs text-gray-500 mt-1">
                            Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 2MB.
                        </p>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('barang.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm rounded-lg shadow-sm transition">
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Script sederhana untuk tambah/hapus baris ukuran --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('size-container');
            const addBtn = document.getElementById('add-size-row');

            function bindRemoveButtons() {
                container.querySelectorAll('.remove-size-row').forEach(btn => {
                    btn.onclick = function () {
                        const row = this.closest('.size-row');
                        row.remove();
                        updateFirstRowDeleteButton();
                    };
                });
            }

            function updateFirstRowDeleteButton() {
                const rows = container.querySelectorAll('.size-row');
                rows.forEach((row, index) => {
                    const btn = row.querySelector('.remove-size-row');
                    if (!btn) return;
                    btn.classList.toggle('hidden', index === 0);
                });
            }

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'flex flex-col md:flex-row gap-2 size-row';
                row.innerHTML = `
                    <div class="flex-1">
                        <input type="text" name="ukuran[]" placeholder="Ukuran (mis. S, M, L, 40, 41)"
                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    <div class="w-full md:w-40">
                        <input type="number" name="jumlah[]" min="0" placeholder="Jumlah"
                               class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>
                    <div class="flex items-center">
                        <button type="button"
                                class="remove-size-row px-3 py-2 text-xs rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </div>
                `;
                container.appendChild(row);
                bindRemoveButtons();
                updateFirstRowDeleteButton();
            });

            bindRemoveButtons();
            updateFirstRowDeleteButton();
        });
    </script>

</x-app-layout>
