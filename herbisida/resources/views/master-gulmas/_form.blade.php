<div class="f-row">
    <label class="f-label">Nama Gulma *</label>
    <input type="text" name="nama_gulma" class="f-input" value="{{ old('nama_gulma', $gulma->nama_gulma ?? '') }}" required>
    @error('nama_gulma') <small style="color:red">{{ $message }}</small> @enderror
</div>

<div class="f-row-2">
    <div>
        <label class="f-label">Sampel</label>
        <input type="number" name="sampel" class="f-input" value="{{ old('sampel', $gulma->sampel ?? '') }}">
    </div>
    <div>
        <label class="f-label">Jumlah</label>
        <input type="number" step="0.01" name="jumlah" class="f-input" value="{{ old('jumlah', $gulma->jumlah ?? '') }}">
    </div>
</div>

<div class="f-row">
    <label class="f-label">Foto Gulma</label>
    @if(isset($gulma) && $gulma->foto)
        <div style="margin-bottom:10px;">
            <img src="{{ Storage::url($gulma->foto) }}" style="width:120px; height:120px; object-fit:cover; border-radius:10px;">
        </div>
    @endif
    <input type="file" name="foto" class="f-input" accept="image/*">
    <div class="f-hint">Format JPG/PNG, max 2MB.</div>
    @error('foto') <small style="color:red">{{ $message }}</small> @enderror
</div>
