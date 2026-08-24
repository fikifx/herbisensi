<?php

namespace App\Http\Controllers;

use App\Models\MasterBlock;
use Illuminate\Http\Request;

class MasterBlockController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterBlock::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('block_code', 'like', "%{$search}%")
                  ->orWhere('topografi', 'like', "%{$search}%");
        }
        $blocks = $query->paginate(10);
        return view('master-blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('master-blocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_code' => 'required|string|max:20|unique:master_blocks',
            'luas_tanam' => 'nullable|numeric',
            'tahun_tanam' => 'nullable|integer',
            'jumlah_pokok' => 'nullable|integer',
            'topografi' => 'nullable|string|max:50',
            'umur_tanam' => 'nullable|integer',
            'kategori_umur' => 'nullable|string|max:50',
        ]);

        MasterBlock::create($validated);
        return redirect()->route('master-blocks.index')->with('success', 'Master Blok berhasil ditambahkan');
    }

    public function show(MasterBlock $masterBlock)
    {
        return view('master-blocks.show', compact('masterBlock'));
    }

    public function edit(MasterBlock $masterBlock)
    {
        return view('master-blocks.edit', compact('masterBlock'));
    }

    public function update(Request $request, MasterBlock $masterBlock)
    {
        $validated = $request->validate([
            'block_code' => 'required|string|max:20|unique:master_blocks,block_code,' . $masterBlock->id,
            'luas_tanam' => 'nullable|numeric',
            'tahun_tanam' => 'nullable|integer',
            'jumlah_pokok' => 'nullable|integer',
            'topografi' => 'nullable|string|max:50',
            'umur_tanam' => 'nullable|integer',
            'kategori_umur' => 'nullable|string|max:50',
        ]);

        $masterBlock->update($validated);
        return redirect()->route('master-blocks.index')->with('success', 'Master Blok berhasil diperbarui');
    }

    public function destroy(MasterBlock $masterBlock)
    {
        $masterBlock->delete();
        return redirect()->route('master-blocks.index')->with('success', 'Master Blok berhasil dihapus');
    }
}
