<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $blocks        = Block::with('pemakaians')->get();
        $totalBlok     = $blocks->count();
        $selesai       = $blocks->where('status', 'Selesai')->count();
        $belumSelesai  = $blocks->where('status', 'Belum Selesai')->count();
        $totalRek      = $blocks->sum('rekomendasi');
        $totalAkt      = $blocks->sum('aktual');
        $efisiensi     = $totalAkt > 0 ? round(($totalRek / $totalAkt) * 100) : 100;

        $now   = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $greeting = now()->hour < 12 ? 'Selamat pagi' : (now()->hour < 18 ? 'Selamat siang' : 'Selamat malam');

        return view('beranda.index', compact(
            'totalBlok', 'selesai', 'belumSelesai',
            'totalRek', 'totalAkt', 'efisiensi', 'now', 'greeting'
        ));
    }
}
