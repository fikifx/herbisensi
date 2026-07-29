<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tab    = $request->get('tab', 'utama');
        $blocks = Block::with('pemakaians')->get();

        $totalBlok        = $blocks->count();
        $rekomendasiTotal = $blocks->sum('rekomendasi');
        $pemakaianAktual  = $blocks->sum('aktual');
        $selisih          = $pemakaianAktual - $rekomendasiTotal;
        $efisiensi        = $pemakaianAktual > 0
            ? round(($rekomendasiTotal / $pemakaianAktual) * 100)
            : 100;
        $potensiPemborosan = $selisih > 0 ? $selisih * 80000 : 0;

        // Top 5 blok terboros
        $topBoros = $blocks
            ->where('aktual', '>', 0)
            ->sortByDesc(fn($b) => $b->aktual - $b->rekomendasi)
            ->take(5)
            ->map(fn($b) => [
                'id'     => $b->block_code,
                'liter'  => max(0, $b->aktual - $b->rekomendasi),
                'persen' => $b->rekomendasi > 0
                    ? number_format((($b->aktual - $b->rekomendasi) / $b->rekomendasi) * 100, 1)
                    : '0.0',
            ])->values();

        // Peta efisiensi
        $peta = $blocks->map(fn($b) => [
            'id'     => $b->block_code,
            'status' => $b->aktual == 0 ? 'ok' :
                (($b->aktual / max($b->rekomendasi, 1)) <= 1.1 ? 'ok' :
                (($b->aktual / max($b->rekomendasi, 1)) <= 1.2 ? 'warn' : 'over')),
        ])->values();

        return view('dashboard.index', compact(
            'tab', 'totalBlok', 'rekomendasiTotal', 'pemakaianAktual',
            'selisih', 'efisiensi', 'potensiPemborosan', 'topBoros', 'peta', 'blocks'
        ));
    }
}
