<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filter = $request->get('filter');

        $query = Barang::with('size')
            ->withSum('size as total_stok', 'jumlah');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('namaBarang', 'like', "%{$search}%");
            });
        }


        if ($filter === 'menipis') {

            $query->having('total_stok', '>', 0)
                ->having('total_stok', '<', 5);
        } elseif ($filter === 'habis') {
            $query->having('total_stok', '=', 0);
        }

        $barang = $query
            ->orderBy('namaBarang', 'asc')
            ->paginate(5)
            ->withQueryString();

        return view('barang.index', compact('barang', 'search', 'filter'));
    }



    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'       => 'required|string|max:100|unique:barang,kode',
            'namaBarang' => 'required|string|max:255',
            'gambar'     => 'nullable|image',
            'ukuran.*'   => 'nullable|string|max:50',
            'jumlah.*'   => 'nullable|integer|min:0',
        ]);

        $barang = Barang::create([
            'kode'        => $validated['kode'],
            'namaBarang'  => $validated['namaBarang'],
            'gambar'      => $request->file('gambar')
                ? $request->file('gambar')->store('gambar-barang', 'public')
                : null,
            'ukuran'       => null,
            'jumlahBarang' => null,
        ]);

        $ukuranList = $request->input('ukuran', []);
        $jumlahList = $request->input('jumlah', []);

        foreach ($ukuranList as $index => $ukuran) {
            if (!$ukuran && !isset($jumlahList[$index])) {
                continue;
            }

            $barang->size()->create([
                'ukuran' => $ukuran,
                'jumlah' => $jumlahList[$index] ?? 0,
            ]);
        }

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $barang->load('size');
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode'       => 'required|string|max:100|unique:barang,kode,' . $barang->id,
            'namaBarang' => 'required|string|max:255',
            'gambar'     => 'nullable|image',
            'ukuran.*'   => 'nullable|string|max:50',
            'jumlah.*'   => 'nullable|integer|min:0',
        ]);

        $ukuranList = $request->input('ukuran', []);
        $jumlahList = $request->input('jumlah', []);


        $totalStok = 0;
        foreach ($jumlahList as $jml) {
            $totalStok += (int) ($jml ?? 0);
        }

        $ukuranPertama = $ukuranList[0] ?? null;


        $gambarPath = $barang->gambar;
        if ($request->hasFile('gambar')) {

            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $gambarPath = $request->file('gambar')->store('gambar-barang', 'public');
        }

        $barang->update([
            'kode'         => $validated['kode'],
            'namaBarang'   => $validated['namaBarang'],
            'gambar'       => $gambarPath,
            'ukuran'       => $ukuranPertama,
            'jumlahBarang' => $totalStok ?: null,
        ]);

        $barang->size()->delete();

        foreach ($ukuranList as $index => $ukuran) {
            if (!$ukuran && !isset($jumlahList[$index])) {
                continue;
            }

            $barang->size()->create([
                'ukuran' => $ukuran,
                'jumlah' => $jumlahList[$index] ?? 0,
            ]);
        }

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }


    public function updateJumlah(Request $request, Barang $barang)
    {
        $request->validate([
            'jumlahBarang' => 'required|integer|min:0',
        ]);

        $barang->update([
            'jumlahBarang' => $request->jumlahBarang,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Jumlah stok barang berhasil diperbarui');
    }


    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            unlink(storage_path('app/public/' . $barang->gambar));
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus');
    }
}
