@extends('layouts.app')

@section('title', 'Detail Pekerjaan')
@section('back', route('pekerjaan.index'))

@section('content_mobile')
    <div class="row" style="margin-top:10px;">
        <div>
            <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--forest);">{{ $block->block_code }}</div>
            <div class="badge {{ $block->status == 'Selesai' ? 'done' : 'pending' }}" style="margin-top:4px;">{{ $block->status }}</div>
        </div>
        <div style="text-align:right">
            <div style="font-size:12px; color:var(--ink-soft); font-weight:600;">Afdeling</div>
            <div style="font-size:20px; font-weight:700; font-family:'Space Grotesk',sans-serif; color:var(--leaf);">{{ $block->afdeling }}</div>
        </div>
    </div>

    <div class="section-title">Kebutuhan Material</div>
    <div class="card">
        <div class="row"><div class="lbl">Rekomendasi Total</div><div class="val">{{ $block->rekomendasi }} L</div></div>
        <div class="row"><div class="lbl">Pemakaian Aktual</div><div class="val" id="aktual-display" style="color:var(--forest);">{{ $block->aktual }} L</div></div>
        
        <div class="progress-wrap" style="background:var(--line); border-radius:6px; height:8px; margin-top:14px; overflow:hidden;">
            @php $pct = $block->rekomendasi > 0 ? min(100, ($block->aktual / $block->rekomendasi) * 100) : 0; @endphp
            <div style="height:100%; border-radius:6px; background:linear-gradient(90deg,var(--leaf),#5da320); width:{{ $pct }}%;"></div>
        </div>
    </div>

    <div class="section-title">Informasi Lahan</div>
    <div class="card">
        <div class="row"><div class="lbl">Luas Blok</div><div class="val">{{ $block->luas }} Ha</div></div>
        <div class="row"><div class="lbl">Target Gulma</div><div class="val">{{ $block->gulma }}</div></div>
        <div class="row"><div class="lbl">Tingkat Kerapatan</div><div class="val">{{ $block->kerapatan }}</div></div>
        <div class="row"><div class="lbl">Herbisida</div><div class="val">{{ $block->herbisida }}</div></div>
        <div class="row"><div class="lbl">Dosis Rekomendasi</div><div class="val">{{ $block->dosis }} L/Ha</div></div>
    </div>

    <div style="display:flex; gap:10px; margin-top:20px;">
        <button class="btn ghost" style="margin-top:0; padding:12px;" onclick="openModal('edit', {{ $block->id }})">
            Edit Blok
        </button>
        <button class="btn red" style="margin-top:0; padding:12px;" onclick="confirmDelete('{{ route('pekerjaan.destroy', $block) }}', '{{ $block->block_code }}')">
            Hapus
        </button>
    </div>

    <a href="{{ route('pekerjaan.riwayat', $block) }}" class="btn">Mulai Pekerjaan & Scan</a>
@endsection

@section('content_desktop')
    <div class="d-page-2col">
        <div>
            <div class="d-card" style="margin-bottom:20px;">
                <div class="d-card-header">
                    <div class="d-card-title">Informasi Lahan - {{ $block->block_code }}</div>
                    <div class="d-badge {{ $block->status == 'Selesai' ? 'done' : 'pending' }}">{{ $block->status }}</div>
                </div>
                <div class="d-card-body-0">
                    <div class="d-table-row"><div class="d-table-lbl">Afdeling</div><div class="d-table-val">{{ $block->afdeling }}</div></div>
                    <div class="d-table-row"><div class="d-table-lbl">Luas Blok</div><div class="d-table-val">{{ $block->luas }} Ha</div></div>
                    <div class="d-table-row"><div class="d-table-lbl">Target Gulma</div><div class="d-table-val">{{ $block->gulma }}</div></div>
                    <div class="d-table-row"><div class="d-table-lbl">Kerapatan</div><div class="d-table-val">{{ $block->kerapatan }}</div></div>
                    <div class="d-table-row"><div class="d-table-lbl">Herbisida</div><div class="d-table-val">{{ $block->herbisida }}</div></div>
                    <div class="d-table-row"><div class="d-table-lbl">Dosis Rek.</div><div class="d-table-val">{{ $block->dosis }} L/Ha</div></div>
                </div>
            </div>
            
            <div style="display:flex; gap:10px;">
                <button class="d-btn d-btn-ghost" onclick="openModal('edit', {{ $block->id }})">Edit Data Blok</button>
                <button class="d-btn d-btn-red" onclick="confirmDelete('{{ route('pekerjaan.destroy', $block) }}', '{{ $block->block_code }}')">Hapus Blok</button>
            </div>
        </div>

        <div>
            <div class="d-card" style="background:linear-gradient(135deg,#183F30,#22553F); color:#fff; border:none; margin-bottom:20px;">
                <div class="d-card-body">
                    <div style="font-size:12px; opacity:0.8; margin-bottom:6px;">Rekomendasi Material</div>
                    <div style="font-family:'Space Grotesk',sans-serif; font-size:32px; font-weight:700;">{{ $block->rekomendasi }} L</div>
                    
                    <div style="margin-top:20px; font-size:12px; opacity:0.8; margin-bottom:6px;">Aktual Terpakai</div>
                    <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--leaf);">{{ $block->aktual }} L</div>
                    
                    <div class="d-progress-wrap" style="background:rgba(255,255,255,0.2);">
                        @php $pct = $block->rekomendasi > 0 ? min(100, ($block->aktual / $block->rekomendasi) * 100) : 0; @endphp
                        <div class="d-progress" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
            </div>

            <a href="{{ route('pekerjaan.riwayat', $block) }}" class="d-btn d-btn-green d-btn-full" style="padding:16px;">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2"><path d="M5 3v18l7-3 7 3V3z"></path></svg>
                Scan Pemakaian & Riwayat
            </a>
        </div>
    </div>
@endsection

@section('modal_content')
    <form id="crud-form" method="POST" enctype="multipart/form-data" data-store-url="{{ route('pekerjaan.store') }}" data-update-base-url="{{ url('pekerjaan') }}">
        @csrf
        <input type="hidden" name="_method" id="f-method" value="POST">
        
        <!-- Form Manual -->
        <div class="f-row-2">
            <div>
                <label class="f-label">Kode Blok</label>
                <input type="text" name="block_code" id="f-block-code" class="f-input" placeholder="Misal: A15" required>
            </div>
            <div>
                <label class="f-label">Afdeling</label>
                <select name="afdeling" id="f-afdeling" class="f-select">
                    <option value="OF">OF</option>
                    <option value="OB">OB</option>
                    <option value="OH">OH</option>
                    <option value="OD">OD</option>
                </select>
            </div>
        </div>
        
        <div class="f-row">
            <label class="f-label">Jenis Gulma</label>
            <input type="text" name="gulma" id="f-gulma" class="f-input" required>
        </div>

        <div class="f-row-2">
            <div>
                <label class="f-label">Kerapatan</label>
                <select name="kerapatan" id="f-kerapatan" class="f-select">
                    <option value="Rendah">Rendah</option>
                    <option value="Sedang" selected>Sedang</option>
                    <option value="Tinggi">Tinggi</option>
                </select>
            </div>
            <div>
                <label class="f-label">Herbisida</label>
                <input type="text" name="herbisida" id="f-herbisida" class="f-input" required>
            </div>
        </div>

        <div class="f-row-2">
            <div>
                <label class="f-label">Luas (Ha)</label>
                <input type="number" step="0.01" name="luas" id="f-luas" class="f-input" oninput="autoCalcRek()" required>
            </div>
            <div>
                <label class="f-label">Dosis (L/Ha)</label>
                <input type="number" step="0.01" name="dosis" id="f-dosis" class="f-input" oninput="autoCalcRek()" required>
            </div>
        </div>

        <div class="f-row-2">
            <div>
                <label class="f-label">Rek. Total (L)</label>
                <input type="number" name="rekomendasi" id="f-rekomendasi" class="f-input" readonly style="background:#F4F7F1">
            </div>
            <div>
                <label class="f-label">Status</label>
                <select name="status" id="f-status" class="f-select">
                    <option value="Belum Selesai">Belum Selesai</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
        </div>
        
        <div class="modal-footer" style="margin: 0 -26px -22px; padding-bottom: 22px;">
            <button type="button" class="d-btn d-btn-ghost" onclick="closeModal()">Batal</button>
            <button type="submit" class="d-btn d-btn-primary">Simpan Blok</button>
        </div>
    </form>
@endsection
