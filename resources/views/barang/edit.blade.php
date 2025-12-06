<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Edit Barang</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Ubah informasi barang kemudian simpan untuk memperbarui data di sistem.
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
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
                <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700">Form Edit Barang</h2>
                <span class="text-xs text-gray-400">
                    Kode: <span class="font-mono">{{ $barang->kode }}</span>
                </span>
            </div>

            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">

                    {{-- KODE BARANG --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode', $barang->kode) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- NAMA BARANG --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="namaBarang" value="{{ old('namaBarang', $barang->namaBarang) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- UKURAN --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Ukuran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ukuran" value="{{ old('ukuran', $barang->ukuran) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- JUMLAH --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlahBarang"
                            value="{{ old('jumlahBarang', $barang->jumlahBarang) }}" min="0"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
                    </div>

                    {{-- GAMBAR --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Barang (opsional)
                        </label>

                        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                            <div>
                                <input type="file" name="gambar"
                                    class="block w-full text-sm text-gray-700
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-orange-50 file:text-orange-700
                                              hover:file:bg-orange-100">
                                <p class="text-xs text-gray-500 mt-1">
                                    Jika tidak diisi, gambar lama akan tetap digunakan. Maks 2MB (JPG, JPEG, PNG).
                                </p>
                            </div>

                            @if ($barang->gambar)
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500 mb-1">Gambar saat ini:</span>
                                    <img src="{{ asset('storage/' . $barang->gambar) }}"
                                        class="h-20 w-auto rounded border border-gray-200 shadow-sm">
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('barang.index') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm rounded-lg shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
