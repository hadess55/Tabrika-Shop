<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJenisBarang = Barang::count();
        $totalStokBarang  = Barang::sum('jumlahBarang');

        $stokMenipis = Barang::where('jumlahBarang', '>', 0)
                             ->where('jumlahBarang', '<', 5)
                             ->count();

        $stokHabis   = Barang::where('jumlahBarang', 0)->count();


        $barangStokTerendah = Barang::where('jumlahBarang', '>', 0)
                                    ->orderBy('jumlahBarang', 'asc')
                                    ->take(5)
                                    ->get();

        return view('dashboard', compact(
            'totalJenisBarang',
            'totalStokBarang',
            'stokMenipis',
            'stokHabis',
            'barangStokTerendah'
        ));
    }
}
