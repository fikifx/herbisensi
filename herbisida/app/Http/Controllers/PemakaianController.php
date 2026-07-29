<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Pemakaian;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    public function index(Block $block)
    {
        $block->load('pemakaians');
        $selisih      = $block->aktual - $block->rekomendasi;
        $persenSelisih = $block->rekomendasi > 0
            ? number_format(($selisih / $block->rekomendasi) * 100, 1)
            : '0.0';

        return view('pekerjaan.riwayat', compact('block', 'selisih', 'persenSelisih'));
    }

    public function store(Request $request, Block $block)
    {
        $data = $request->validate([
            'jerigen' => 'required|integer|min:1',
            'batch'   => 'required|string|max:20',
        ]);

        $data['block_id'] = $block->id;
        $data['waktu']    = now();

        Pemakaian::create($data);

        // Update total aktual
        $block->increment('aktual', $data['jerigen']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'aktual'  => $block->fresh()->aktual,
                'message' => "Pemakaian {$data['jerigen']} L batch {$data['batch']} ditambahkan!",
            ]);
        }

        return redirect()->route('pekerjaan.riwayat', $block)
            ->with('success', "Pemakaian {$data['jerigen']} L batch {$data['batch']} ditambahkan!");
    }
}
