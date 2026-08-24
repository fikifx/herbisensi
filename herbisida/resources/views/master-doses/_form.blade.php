<div class="f-row-2">
    <div>
        <label class="f-label">Item Pekerjaan</label>
        <input type="text" name="item_pekerjaan" class="f-input" value="{{ old('item_pekerjaan', $dosis->item_pekerjaan ?? '') }}">
    </div>
    <div>
        <label class="f-label">Jenis Gulma</label>
        <input type="text" name="jenis_gulma" class="f-input" value="{{ old('jenis_gulma', $dosis->jenis_gulma ?? '') }}">
    </div>
</div>

<hr style="border:0; border-top:1px dashed var(--line); margin:20px 0;">
<div style="font-weight:700; color:var(--forest); margin-bottom:12px;">Material 1</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Nama Material 1</label>
        <input type="text" name="material_1" class="f-input" value="{{ old('material_1', $dosis->material_1 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Dosis (g/Ha)</label>
        <input type="number" step="0.0001" name="dosis_1" class="f-input" value="{{ old('dosis_1', $dosis->dosis_1 ?? '') }}">
    </div>
</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Volume (L/Ha)</label>
        <input type="number" step="0.0001" name="volume_1" class="f-input" value="{{ old('volume_1', $dosis->volume_1 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Herb Gram/Kap</label>
        <input type="number" step="0.0001" name="herb_kap_1" class="f-input" value="{{ old('herb_kap_1', $dosis->herb_kap_1 ?? '') }}">
    </div>
</div>
<div class="f-row">
    <label class="f-label">Herb Gram/Liter</label>
    <input type="number" step="0.0001" name="herb_ltr_1" class="f-input" value="{{ old('herb_ltr_1', $dosis->herb_ltr_1 ?? '') }}">
</div>

<hr style="border:0; border-top:1px dashed var(--line); margin:20px 0;">
<div style="font-weight:700; color:var(--forest); margin-bottom:12px;">Material 2</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Nama Material 2</label>
        <input type="text" name="material_2" class="f-input" value="{{ old('material_2', $dosis->material_2 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Dosis (g/Ha)</label>
        <input type="number" step="0.0001" name="dosis_2" class="f-input" value="{{ old('dosis_2', $dosis->dosis_2 ?? '') }}">
    </div>
</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Volume (L/Ha)</label>
        <input type="number" step="0.0001" name="volume_2" class="f-input" value="{{ old('volume_2', $dosis->volume_2 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Herb Gram/Kap</label>
        <input type="number" step="0.0001" name="herb_kap_2" class="f-input" value="{{ old('herb_kap_2', $dosis->herb_kap_2 ?? '') }}">
    </div>
</div>
<div class="f-row">
    <label class="f-label">Herb Gram/Liter</label>
    <input type="number" step="0.0001" name="herb_ltr_2" class="f-input" value="{{ old('herb_ltr_2', $dosis->herb_ltr_2 ?? '') }}">
</div>

<hr style="border:0; border-top:1px dashed var(--line); margin:20px 0;">
<div style="font-weight:700; color:var(--forest); margin-bottom:12px;">Material 3</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Nama Material 3</label>
        <input type="text" name="material_3" class="f-input" value="{{ old('material_3', $dosis->material_3 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Dosis (g/Ha)</label>
        <input type="number" step="0.0001" name="dosis_3" class="f-input" value="{{ old('dosis_3', $dosis->dosis_3 ?? '') }}">
    </div>
</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Volume (L/Ha)</label>
        <input type="number" step="0.0001" name="volume_3" class="f-input" value="{{ old('volume_3', $dosis->volume_3 ?? '') }}">
    </div>
    <div>
        <label class="f-label">Herb Gram/Kap</label>
        <input type="number" step="0.0001" name="herb_kap_3" class="f-input" value="{{ old('herb_kap_3', $dosis->herb_kap_3 ?? '') }}">
    </div>
</div>
<div class="f-row">
    <label class="f-label">Herb Gram/Liter</label>
    <input type="number" step="0.0001" name="herb_ltr_3" class="f-input" value="{{ old('herb_ltr_3', $dosis->herb_ltr_3 ?? '') }}">
</div>

<hr style="border:0; border-top:1px dashed var(--line); margin:20px 0;">
<div style="font-weight:700; color:var(--forest); margin-bottom:12px;">Intersprayer</div>
<div class="f-row-2">
    <div>
        <label class="f-label">Kapasitas (L)</label>
        <input type="number" step="0.0001" name="kapasitas_intersprayer" class="f-input" value="{{ old('kapasitas_intersprayer', $dosis->kapasitas_intersprayer ?? '') }}">
    </div>
    <div>
        <label class="f-label">Jumlah / Ha</label>
        <input type="number" step="0.0001" name="jumlah_intersprayer" class="f-input" value="{{ old('jumlah_intersprayer', $dosis->jumlah_intersprayer ?? '') }}">
    </div>
</div>
