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

        <div class="bg-white shadow rounded-xl border border-gray-200 ">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">Form Barang</h2>
            </div>

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="namaBarang" value="{{ old('namaBarang') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Ukuran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ukuran" value="{{ old('ukuran') }}"
                            placeholder="Contoh: S, M, L atau ukuran bebas"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlahBarang" value="{{ old('jumlahBarang') }}" min="0"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

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
</x-app-layout>
