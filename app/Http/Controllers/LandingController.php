<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $produkQuery = Barang::with('size')
            ->whereHas('size', function ($q) {
                $q->where('jumlah', '>', 0);
            });

        if ($search) {
            $produkQuery->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('namaBarang', 'like', "%{$search}%");
            });
        }

        $produk = $produkQuery
            ->orderBy('namaBarang')
            ->paginate(9)
            ->withQueryString();

        return view('home', compact('produk', 'search'));
    }
}
