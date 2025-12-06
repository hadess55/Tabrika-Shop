<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = Barang::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                ->orWhere('namaBarang', 'like', "%{$search}%");
            });
        }

        // 10 data per halaman
        $barang = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('barang.index', compact('barang', 'search'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'namaBarang' => 'required',
            'ukuran' => 'required',
            'jumlahBarang' => 'required|integer',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('gambar')){
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode' => 'required',
            'namaBarang' => 'required',
            'ukuran' => 'required',
            'jumlahBarang' => 'required|integer',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('gambar')){
            if($barang->gambar){
                unlink(storage_path('app/public/'.$barang->gambar));
            }
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui');
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
        if($barang->gambar){
            unlink(storage_path('app/public/'.$barang->gambar));
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus');
    }
}
