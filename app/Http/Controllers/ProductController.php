<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class ProductController extends Controller
{
    /**
     * Menampilkan seluruh produk dengan pencarian & pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produk = Barang::with('size')   // eager load relasi size
            ->when($search, function ($query) use ($search) {
                $query->where('namaBarang', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            })
            ->orderBy('namaBarang', 'asc')
            ->paginate(8)
            ->withQueryString();

        return view('public.product', [
            'produk' => $produk,
            'search' => $search
        ]);
    }


    /**
     * Menampilkan detail produk tertentu
     */
    public function show($id)
    {
        $produk = Barang::with('size')->findOrFail($id);

        return view('public.product-detail', [
            'produk' => $produk
        ]);
    }
}
