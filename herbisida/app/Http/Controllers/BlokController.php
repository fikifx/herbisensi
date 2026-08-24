<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlokController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $query  = Block::withCount('pemakaians');

        if ($filter === 'belum') {
            $query->where('status', 'Belum Selesai');
        } elseif ($filter === 'selesai') {
            $query->where('status', 'Selesai');
        }

        $blocks    = $query->orderBy('block_code')->get();
        $totalBlok = Block::count();
        $masterBlocks = \App\Models\MasterBlock::orderBy('block_code')->get();

        return view('pekerjaan.index', compact('blocks', 'filter', 'totalBlok', 'masterBlocks'));
    }

    public function show(Block $block)
    {
        $block->load(['pemakaians', 'evaluasi']);
        $masterBlocks = \App\Models\MasterBlock::orderBy('block_code')->get();
        $masterBlockDetail = $masterBlocks->where('block_code', $block->block_code)->first();
        
        $masterDosisDetail = null;
        if (!empty($block->gulma_ai_raw)) {
            $raw = is_array($block->gulma_ai_raw) ? $block->gulma_ai_raw : json_decode($block->gulma_ai_raw, true);
            if ($raw && isset($raw['herbisida'])) {
                $allDosis = \App\Models\MasterDosis::all();
                $masterDosisDetail = $allDosis->first(function($d) use ($raw, $block) {
                    // Coba cocokkan material 1 dan dosis 1
                    return $d->material_1 && stripos($raw['herbisida'], $d->material_1) !== false && $d->dosis_1 == $block->dosis;
                });
            }
        }
        
        // Fallback jika tidak ketemu dari raw
        if (!$masterDosisDetail) {
            $allDosis = \App\Models\MasterDosis::all();
            $masterDosisDetail = $allDosis->first(function($d) use ($block) {
                return $d->material_1 && stripos($block->herbisida, $d->material_1) !== false;
            });
        }

        return view('pekerjaan.show', compact('block', 'masterBlocks', 'masterBlockDetail', 'masterDosisDetail'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'block_code'  => 'required|string|max:10|unique:blocks,block_code',
            'afdeling'    => 'required|string|max:10',
            'luas'        => 'required|numeric|min:0.1',
            'gulma'       => 'required|string|max:255',
            'kerapatan'   => 'required|string',
            'herbisida'   => 'required|string|max:255',
            'dosis'       => 'required|numeric|min:0.1',
            'rekomendasi' => 'required|integer|min:1',
            'status'      => 'required|in:Belum Selesai,Selesai',
            'gulma_foto'  => 'nullable|array|max:10',
            'gulma_foto.*'=> 'image|max:5120',
            'gulma_ai_raw'=> 'nullable|string',
        ]);

        if ($request->hasFile('gulma_foto')) {
            $files = $request->file('gulma_foto');
            if(count($files) > 0) {
                $data['gulma_foto'] = $files[0]->store('gulma', 'public');
            } else {
                unset($data['gulma_foto']);
            }
        } else {
            unset($data['gulma_foto']);
        }

        if (!empty($data['gulma_ai_raw'])) {
            $decoded = json_decode($data['gulma_ai_raw'], true);
            $data['gulma_ai_raw'] = $decoded ? $data['gulma_ai_raw'] : null;
        }

        Block::create($data);

        return redirect()->route('pekerjaan.index')
            ->with('success', "Blok {$data['block_code']} berhasil ditambahkan!");
    }

    public function update(Request $request, Block $block)
    {
        $data = $request->validate([
            'afdeling'    => 'required|string|max:10',
            'luas'        => 'required|numeric|min:0.1',
            'gulma'       => 'required|string|max:255',
            'kerapatan'   => 'required|string',
            'herbisida'   => 'required|string|max:255',
            'dosis'       => 'required|numeric|min:0.1',
            'rekomendasi' => 'required|integer|min:1',
            'status'      => 'required|in:Belum Selesai,Selesai',
            'gulma_foto'  => 'nullable|array|max:10',
            'gulma_foto.*'=> 'image|max:5120',
        ]);

        if ($request->hasFile('gulma_foto')) {
            $files = $request->file('gulma_foto');
            if(count($files) > 0) {
                if ($block->gulma_foto) Storage::disk('public')->delete($block->gulma_foto);
                $data['gulma_foto'] = $files[0]->store('gulma', 'public');
            } else {
                unset($data['gulma_foto']);
            }
        } else {
            unset($data['gulma_foto']);
        }

        $block->update($data);

        return redirect()->route('pekerjaan.show', $block)
            ->with('success', "Blok {$block->block_code} berhasil diperbarui!");
    }

    public function destroy(Block $block)
    {
        $code = $block->block_code;
        if ($block->gulma_foto) Storage::disk('public')->delete($block->gulma_foto);
        $block->delete();

        return redirect()->route('pekerjaan.index')
            ->with('success', "Blok {$code} berhasil dihapus.");
    }

    public function selesai(Block $block)
    {
        $block->update(['status' => 'Selesai']);
        return redirect()->route('pekerjaan.riwayat', $block)
            ->with('success', 'Pemakaian ditandai selesai!');
    }
}
