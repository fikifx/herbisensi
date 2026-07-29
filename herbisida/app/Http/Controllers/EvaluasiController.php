<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvaluasiController extends Controller
{
    public function create(Block $block)
    {
        $block->load('evaluasi');
        return view('pekerjaan.evaluasi', compact('block'));
    }

    public function store(Request $request, Block $block)
    {
        $data = $request->validate([
            'efektivitas'  => 'required|integer|min:0|max:100',
            'kategori'     => 'required|string|max:50',
            'catatan'      => 'required|string',
            'foto_sebelum' => 'nullable|image|max:5120',
            'foto_sesudah' => 'nullable|image|max:5120',
            'foto_ai_raw'  => 'nullable|string',
        ]);

        $data['block_id'] = $block->id;

        if ($request->hasFile('foto_sebelum')) {
            $data['foto_sebelum'] = $request->file('foto_sebelum')->store('evaluasi', 'public');
        }
        if ($request->hasFile('foto_sesudah')) {
            $data['foto_sesudah'] = $request->file('foto_sesudah')->store('evaluasi', 'public');
        }

        Evaluasi::updateOrCreate(
            ['block_id' => $block->id],
            $data
        );

        return redirect()->route('pekerjaan.hasil', $block)
            ->with('success', 'Evaluasi berhasil disimpan!');
    }
}
