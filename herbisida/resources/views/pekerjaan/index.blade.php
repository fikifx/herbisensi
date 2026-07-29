@extends('layouts.app')

@section('title', 'Pekerjaan')

@section('content_mobile')
    <input type="text" class="search" placeholder="Cari blok..." id="search-input">
    
    <div class="chips">
        <a href="{{ route('pekerjaan.index', ['filter' => 'semua']) }}" class="chip {{ $filter == 'semua' ? 'active' : '' }}" data-filter="semua">Semua</a>
        <a href="{{ route('pekerjaan.index', ['filter' => 'belum']) }}" class="chip {{ $filter == 'belum' ? 'active' : '' }}" data-filter="belum">Belum Selesai</a>
        <a href="{{ route('pekerjaan.index', ['filter' => 'selesai']) }}" class="chip {{ $filter == 'selesai' ? 'active' : '' }}" data-filter="selesai">Selesai</a>
    </div>

    @foreach($blocks as $block)
        <a href="{{ route('pekerjaan.show', $block) }}" class="joblist-item" data-code="{{ strtolower($block->block_code) }}">
            <div class="top">
                <div class="code">{{ $block->block_code }}</div>
                <div class="badge {{ $block->status == 'Selesai' ? 'done' : 'pending' }}">{{ $block->status }}</div>
            </div>
            <div class="meta">
                Afdeling {{ $block->afdeling }} • Luas: {{ $block->luas }} Ha<br>
                Target: {{ $block->gulma }}<br>
                Progress: {{ $block->aktual }} / {{ $block->rekomendasi }} L
            </div>
        </a>
    @endforeach

    <button class="btn leaf" onclick="openModal('add')" style="position:fixed; bottom:86px; right:16px; width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 6px 20px rgba(124,185,59,0.4); z-index:10; padding:0;">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    </button>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Daftar Pekerjaan</div>
            <div class="d-section-sub">Total {{ $totalBlok }} blok terdaftar</div>
        </div>
        <div>
            <button class="d-btn d-btn-green" onclick="openModal('add')">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Blok
            </button>
        </div>
    </div>

    <div class="d-card" style="margin-bottom:24px;">
        <div class="d-card-body">
            <div style="display:flex; gap:16px; align-items:center;">
                <div style="flex:1;">
                    <input type="text" class="d-search" style="margin:0;" placeholder="Cari kode blok..." id="d-search-input">
                </div>
                <div class="d-chips" style="margin:0;">
                    <a href="{{ route('pekerjaan.index', ['filter' => 'semua']) }}" class="d-chip {{ $filter == 'semua' ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('pekerjaan.index', ['filter' => 'belum']) }}" class="d-chip {{ $filter == 'belum' ? 'active' : '' }}">Belum Selesai</a>
                    <a href="{{ route('pekerjaan.index', ['filter' => 'selesai']) }}" class="d-chip {{ $filter == 'selesai' ? 'active' : '' }}">Selesai</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-job-grid">
        @foreach($blocks as $block)
            <a href="{{ route('pekerjaan.show', $block) }}" class="d-job-card" data-code="{{ strtolower($block->block_code) }}">
                <div class="d-job-top">
                    <div class="d-job-code">{{ $block->block_code }}</div>
                    <div class="d-job-afd">AFD {{ $block->afdeling }}</div>
                </div>
                <div class="d-job-gulma">
                    <b>Gulma:</b> {{ $block->gulma }}<br>
                    <b>Kerapatan:</b> {{ $block->kerapatan }}
                </div>
                <div class="d-job-meta">
                    <div class="d-badge {{ $block->status == 'Selesai' ? 'done' : 'pending' }}">{{ $block->status }}</div>
                    <div class="d-job-chip">{{ $block->aktual }} / {{ $block->rekomendasi }} L</div>
                </div>
            </a>
        @endforeach
    </div>
@endsection

@section('modal_content')
    <form id="crud-form" method="POST" enctype="multipart/form-data" data-store-url="{{ route('pekerjaan.store') }}" data-update-base-url="{{ url('pekerjaan') }}">
        @csrf
        <input type="hidden" name="_method" id="f-method" value="POST">
        
        <!-- Fitur AI Scan -->
        <div class="ai-scan-box">
            <h3>🤖 Deteksi Gulma Otomatis</h3>
            <p>Upload foto gulma, biarkan AI yang mengenali jenis dan merekomendasikan herbisida.</p>
            <label class="photobox" for="ai-foto-input" style="border-color: rgba(255,255,255,0.3); background: rgba(0,0,0,0.1); color:#fff; margin-bottom:8px;">
                <svg viewBox="0 0 24 24" stroke="currentColor" style="stroke: #fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <span id="ai-filename-label">Klik untuk Upload / Ambil Foto</span>
            </label>
            <input type="file" id="ai-foto-input" name="gulma_foto" accept="image/*" style="display:none;" onchange="document.getElementById('ai-filename-label').innerText = this.files[0] ? this.files[0].name : 'Klik untuk Upload / Ambil Foto'">
            <input type="hidden" name="gulma_ai_raw" id="f-gulma_ai_raw">
            
            <img id="ai-foto-preview" class="photo-preview" alt="Preview">
            
            <button type="button" id="ai-analyze-btn" class="btn ghost" style="border:none; margin-top:0; width:100%;" onclick="aiScanGulma.analyze()">
                🤖 Analisis AI
            </button>
            
            <div id="ai-loader" class="ai-loader">
                <div class="spinner"></div>
                <div>Menganalisis foto dengan Gemini AI...</div>
            </div>
            
            <div id="ai-result" style="display:none; background:rgba(0,0,0,0.15); padding:12px; border-radius:10px; margin-top:12px; font-size:12px;">
                <div class="ai-result-badge">✅ Teridentifikasi oleh AI</div>
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="opacity:0.8">Nama Gulma</span>
                    <strong id="ai-nama">-</strong>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="opacity:0.8">Kerapatan</span>
                    <strong id="ai-kerapatan">-</strong>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="opacity:0.8">Rekomendasi Herbisida</span>
                    <strong id="ai-herbisida">-</strong>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="opacity:0.8">Dosis</span>
                    <strong id="ai-dosis">-</strong>
                </div>
                <div style="margin-top:10px; border-top:1px solid rgba(255,255,255,0.1); padding-top:10px;">
                    <span style="opacity:0.8; display:block; margin-bottom:4px;">Akurasi AI (Confidence)</span>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div class="confidence-bar" style="flex:1; margin-right:10px;"><div id="ai-confidence-bar" class="confidence-bar-fill"></div></div>
                        <strong id="ai-confidence">-</strong>
                    </div>
                </div>
                <p id="ai-deskripsi" style="margin:10px 0 0; opacity:0.8; font-style:italic; border-top:1px solid rgba(255,255,255,0.1); padding-top:10px;"></p>
            </div>
        </div>

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
        
        <div class="modal-footer" style="margin: 0 -26px -22px; padding-bottom: 22px; display:flex; gap:12px; align-items:center;">
            <button type="button" class="btn ghost" style="margin:0; flex:1;" onclick="closeModal()">Batal</button>
            <button type="submit" class="btn leaf" style="margin:0; flex:1;">Simpan Blok</button>
        </div>
    </form>
@endsection

@push('js')
<script>
// Pencarian Client-side
['search-input', 'd-search-input'].forEach(id => {
    const input = document.getElementById(id);
    if(input) {
        input.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.joblist-item, .d-job-card').forEach(el => {
                if(el.dataset.code.includes(q)) el.style.display = '';
                else el.style.display = 'none';
            });
        });
    }
});
</script>
<script src="/js/ai-scan.js"></script>
@endpush
