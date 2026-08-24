<?php

namespace App\Http\Controllers;

use App\Models\MasterGulma;
use Illuminate\Http\Request;

class MasterGulmaController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterGulma::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_gulma', 'like', "%{$search}%");
        }
        $gulmas = $query->paginate(10);
        return view('master-gulmas.index', compact('gulmas'));
    }

    public function create()
    {
        return view('master-gulmas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sampel' => 'nullable|integer',
            'nama_gulma' => 'required|string|max:255',
            'jumlah' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('gulma_fotos', 'public');
        }

        MasterGulma::create($validated);
        return redirect()->route('master-gulmas.index')->with('success', 'Master Gulma berhasil ditambahkan');
    }

    public function show(MasterGulma $masterGulma)
    {
        return view('master-gulmas.show', compact('masterGulma'));
    }

    public function edit(MasterGulma $masterGulma)
    {
        return view('master-gulmas.edit', compact('masterGulma'));
    }

    public function update(Request $request, MasterGulma $masterGulma)
    {
        $validated = $request->validate([
            'sampel' => 'nullable|integer',
            'nama_gulma' => 'required|string|max:255',
            'jumlah' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($masterGulma->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($masterGulma->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($masterGulma->foto);
            }
            $validated['foto'] = $request->file('foto')->store('gulma_fotos', 'public');
        }

        $masterGulma->update($validated);
        return redirect()->route('master-gulmas.index')->with('success', 'Master Gulma berhasil diperbarui');
    }

    public function destroy(MasterGulma $masterGulma)
    {
        if ($masterGulma->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($masterGulma->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($masterGulma->foto);
        }
        $masterGulma->delete();
        return redirect()->route('master-gulmas.index')->with('success', 'Master Gulma berhasil dihapus');
    }
}
