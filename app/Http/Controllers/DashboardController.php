<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class DashboardController extends Controller
{

    public function index()
    {
        $barang = Barang::with('size')->get();


        $totalJenisBarang = $barang->count();

        $totalStokBarang = $barang->sum('total_stok');

        $stokMenipis = $barang
            ->filter(fn($b) => $b->total_stok > 0 && $b->total_stok < 5)
            ->count();

        $stokHabis = $barang
            ->filter(fn($b) => $b->total_stok === 0)
            ->count();

        $barangStokTerendah = $barang
            ->filter(fn($b) => $b->total_stok > 0)
            ->sortBy('total_stok')
            ->take(5);

        return view('dashboard', compact(
            'totalJenisBarang',
            'totalStokBarang',
            'stokMenipis',
            'stokHabis',
            'barangStokTerendah'
        ));
    }
}
