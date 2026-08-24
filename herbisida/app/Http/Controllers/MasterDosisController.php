<?php

namespace App\Http\Controllers;

use App\Models\MasterDosis;
use Illuminate\Http\Request;

class MasterDosisController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterDosis::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('jenis_gulma', 'like', "%{$search}%")
                  ->orWhere('item_pekerjaan', 'like', "%{$search}%");
        }
        $doses = $query->paginate(10);
        return view('master-doses.index', compact('doses'));
    }

    public function create()
    {
        return view('master-doses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_pekerjaan' => 'nullable|string|max:255',
            'jenis_gulma' => 'nullable|string|max:255',
            'material_1' => 'nullable|string|max:255',
            'material_2' => 'nullable|string|max:255',
            'material_3' => 'nullable|string|max:255',
            'dosis_1' => 'nullable|numeric',
            'dosis_2' => 'nullable|numeric',
            'dosis_3' => 'nullable|numeric',
            'volume_1' => 'nullable|numeric',
            'volume_2' => 'nullable|numeric',
            'volume_3' => 'nullable|numeric',
            'kapasitas_intersprayer' => 'nullable|numeric',
            'jumlah_intersprayer' => 'nullable|numeric',
            'herb_kap_1' => 'nullable|numeric',
            'herb_kap_2' => 'nullable|numeric',
            'herb_kap_3' => 'nullable|numeric',
            'herb_ltr_1' => 'nullable|numeric',
            'herb_ltr_2' => 'nullable|numeric',
            'herb_ltr_3' => 'nullable|numeric',
        ]);

        MasterDosis::create($validated);
        return redirect()->route('master-doses.index')->with('success', 'Master Dosis berhasil ditambahkan');
    }

    public function show(MasterDosis $masterDose)
    {
        return view('master-doses.show', compact('masterDose'));
    }

    public function edit(MasterDosis $masterDose)
    {
        return view('master-doses.edit', compact('masterDose'));
    }

    public function update(Request $request, MasterDosis $masterDose)
    {
        $validated = $request->validate([
            'item_pekerjaan' => 'nullable|string|max:255',
            'jenis_gulma' => 'nullable|string|max:255',
            'material_1' => 'nullable|string|max:255',
            'material_2' => 'nullable|string|max:255',
            'material_3' => 'nullable|string|max:255',
            'dosis_1' => 'nullable|numeric',
            'dosis_2' => 'nullable|numeric',
            'dosis_3' => 'nullable|numeric',
            'volume_1' => 'nullable|numeric',
            'volume_2' => 'nullable|numeric',
            'volume_3' => 'nullable|numeric',
            'kapasitas_intersprayer' => 'nullable|numeric',
            'jumlah_intersprayer' => 'nullable|numeric',
            'herb_kap_1' => 'nullable|numeric',
            'herb_kap_2' => 'nullable|numeric',
            'herb_kap_3' => 'nullable|numeric',
            'herb_ltr_1' => 'nullable|numeric',
            'herb_ltr_2' => 'nullable|numeric',
            'herb_ltr_3' => 'nullable|numeric',
        ]);

        $masterDose->update($validated);
        return redirect()->route('master-doses.index')->with('success', 'Master Dosis berhasil diperbarui');
    }

    public function destroy(MasterDosis $masterDose)
    {
        $masterDose->delete();
        return redirect()->route('master-doses.index')->with('success', 'Master Dosis berhasil dihapus');
    }
}
