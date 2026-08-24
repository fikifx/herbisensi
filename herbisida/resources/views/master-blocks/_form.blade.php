<div class="f-row">
    <label class="f-label">Kode Blok *</label>
    <input type="text" name="block_code" class="f-input" value="{{ old('block_code', $block->block_code ?? '') }}" required>
    @error('block_code') <small style="color:red">{{ $message }}</small> @enderror
</div>

<div class="f-row-2">
    <div>
        <label class="f-label">Luas Tanam (Ha)</label>
        <input type="number" step="0.01" name="luas_tanam" class="f-input" value="{{ old('luas_tanam', $block->luas_tanam ?? '') }}">
    </div>
    <div>
        <label class="f-label">Topografi</label>
        <input type="text" name="topografi" class="f-input" value="{{ old('topografi', $block->topografi ?? '') }}">
    </div>
</div>

<div class="f-row-2">
    <div>
        <label class="f-label">Tahun Tanam</label>
        <input type="number" name="tahun_tanam" class="f-input" value="{{ old('tahun_tanam', $block->tahun_tanam ?? '') }}">
    </div>
    <div>
        <label class="f-label">Jumlah Pokok</label>
        <input type="number" name="jumlah_pokok" class="f-input" value="{{ old('jumlah_pokok', $block->jumlah_pokok ?? '') }}">
    </div>
</div>

<div class="f-row-2">
    <div>
        <label class="f-label">Umur Tanam</label>
        <input type="number" name="umur_tanam" class="f-input" value="{{ old('umur_tanam', $block->umur_tanam ?? '') }}">
    </div>
    <div>
        <label class="f-label">Kategori Umur</label>
        <input type="text" name="kategori_umur" class="f-input" value="{{ old('kategori_umur', $block->kategori_umur ?? '') }}">
    </div>
</div>
