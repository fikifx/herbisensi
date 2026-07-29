@extends('layouts.app')

@section('title', 'Evaluasi AI')
@section('back', route('pekerjaan.riwayat', $block))

@section('content_mobile')
<div style="text-align:center; margin-bottom:16px;">
    <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Evaluasi Efektivitas Blok</div>
    <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--forest);">{{ $block->block_code }}</div>
</div>

<form action="{{ route('pekerjaan.evaluasi.store', $block) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="ai-scan-box" style="margin-bottom:24px;">
        <h3>🤖 Analisis Efektivitas Herbisida</h3>
        <p>Upload foto sebelum dan sesudah aplikasi (H+14) untuk dianalisis oleh Gemini AI.</p>

        <div style="margin-top:16px; margin-bottom:16px;">
            <label style="display:block; font-size:12px; font-weight:700; margin-bottom:6px;">📸 Foto Sebelum Aplikasi</label>
            <label class="photobox" for="m_foto_sebelum" style="border-color: rgba(255,255,255,0.3); background: rgba(0,0,0,0.1); color:#fff; margin-bottom:8px; height: 100px;">
                <svg viewBox="0 0 24 24" stroke="currentColor" style="stroke: #fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <span id="lbl-sebelum-m">Upload Foto Sebelum</span>
            </label>
            <input type="file" id="m_foto_sebelum" name="foto_sebelum" accept="image/*" style="display:none;" onchange="document.getElementById('lbl-sebelum-m').innerText = this.files[0] ? this.files[0].name : 'Upload Foto Sebelum'">
            <img id="m_preview-sebelum" class="photo-preview" style="margin-top:10px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; margin-bottom:6px;">📸 Foto Sesudah Aplikasi (H+14)</label>
            <label class="photobox" for="m_foto_sesudah" style="border-color: rgba(255,255,255,0.3); background: rgba(0,0,0,0.1); color:#fff; margin-bottom:8px; height: 100px;">
                <svg viewBox="0 0 24 24" stroke="currentColor" style="stroke: #fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <span id="lbl-sesudah-m">Upload Foto Sesudah</span>
            </label>
            <input type="file" id="m_foto_sesudah" name="foto_sesudah" accept="image/*" style="display:none;" onchange="document.getElementById('lbl-sesudah-m').innerText = this.files[0] ? this.files[0].name : 'Upload Foto Sesudah'">
            <img id="m_preview-sesudah" class="photo-preview" style="margin-top:10px;">
        </div>
        
        <input type="hidden" name="foto_ai_raw" id="m_foto_ai_raw">
        
        <button type="button" id="m_ai-eval-btn" class="btn ghost" style="margin-top:0;" onclick="aiScanEvaluasi.analyze('m_')">
            🤖 Analisis Perbandingan AI
        </button>
        
        <div id="m_ai-eval-loader" class="ai-loader">
            <div class="spinner"></div>
            <div>Membandingkan kedua foto dengan AI...</div>
        </div>
        
        <div id="m_ai-eval-result" style="display:none; background:rgba(0,0,0,0.15); padding:16px; border-radius:12px; margin-top:16px;">
            <div class="ai-result-badge">✅ Hasil Evaluasi AI Selesai</div>
            
            <div style="text-align:center; margin:14px 0;">
                <div style="font-size:12px; opacity:0.8;">Tingkat Efektivitas</div>
                <div id="m_ai-eval-efektivitas" style="font-family:'Space Grotesk',sans-serif; font-size:36px; font-weight:700; color:var(--leaf-light);">0%</div>
                <div id="m_ai-eval-kategori" style="font-weight:700; background:var(--leaf-light); color:var(--forest); display:inline-block; padding:4px 12px; border-radius:100px; font-size:11px; margin-top:6px;">-</div>
            </div>
            
            <div style="background:rgba(255,255,255,0.1); border-radius:8px; height:8px; overflow:hidden; margin-bottom:14px;">
                <div id="m_ai-eval-bar" style="height:100%; background:var(--leaf-light); width:0%; transition:width 0.5s;"></div>
            </div>
            
            <p id="m_ai-eval-catatan" style="font-size:12px; font-style:italic; line-height:1.5; margin:0; opacity:0.9; text-align:center;"></p>
        </div>
    </div>

    <!-- Hidden form fields to be submitted -->
    <input type="hidden" id="m_efektivitas" name="efektivitas" value="{{ $block->evaluasi->efektivitas ?? '' }}" required>
    <input type="hidden" id="m_kategori" name="kategori" value="{{ $block->evaluasi->kategori ?? '' }}" required>
    <input type="hidden" id="m_catatan" name="catatan" value="{{ $block->evaluasi->catatan ?? '' }}" required>

    <button type="submit" class="btn leaf">Simpan Laporan Evaluasi</button>
</form>
@endsection

@section('content_desktop')
<div class="d-page-2col">
    <div>
        <form action="{{ route('pekerjaan.evaluasi.store', $block) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="ai-scan-box" style="margin-bottom:20px;">
                <h3 style="font-size:18px;">🤖 Evaluasi Efektivitas AI - {{ $block->block_code }}</h3>
                <p style="font-size:13px;">Upload foto sebelum dan sesudah aplikasi herbisida untuk dianalisis oleh AI. AI akan menghitung persentase efektivitas pengendalian gulma.</p>

                <div style="display:flex; flex-wrap:wrap; gap:16px; border-bottom:1px solid rgba(255,255,255,0.1); padding:16px 0; align-items:flex-start;">
                    <div style="flex: 1 1 45%; min-width: 200px;">
                        <label style="display:block; font-size:12px; font-weight:700; margin-bottom:8px;">📸 Foto Sebelum</label>
                        <label class="photobox" for="d_foto_sebelum" style="border-color: rgba(255,255,255,0.3); background: rgba(0,0,0,0.1); color:#fff; margin-bottom:8px; height: 120px;">
                            <svg viewBox="0 0 24 24" stroke="currentColor" style="stroke: #fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span id="lbl-sebelum-d">Upload Foto Sebelum</span>
                        </label>
                        <input type="file" id="d_foto_sebelum" name="foto_sebelum" accept="image/*" style="display:none;" onchange="document.getElementById('lbl-sebelum-d').innerText = this.files[0] ? this.files[0].name : 'Upload Foto Sebelum';">
                        <img id="d_preview-sebelum" class="photo-preview" style="margin-top:12px; max-height:200px; max-width:100%;">
                    </div>
                    <div style="flex: 1 1 45%; min-width: 200px;">
                        <label style="display:block; font-size:12px; font-weight:700; margin-bottom:8px;">📸 Foto Sesudah (H+14)</label>
                        <label class="photobox" for="d_foto_sesudah" style="border-color: rgba(255,255,255,0.3); background: rgba(0,0,0,0.1); color:#fff; margin-bottom:8px; height: 120px;">
                            <svg viewBox="0 0 24 24" stroke="currentColor" style="stroke: #fff;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span id="lbl-sesudah-d">Upload Foto Sesudah</span>
                        </label>
                        <input type="file" id="d_foto_sesudah" name="foto_sesudah" accept="image/*" style="display:none;" onchange="document.getElementById('lbl-sesudah-d').innerText = this.files[0] ? this.files[0].name : 'Upload Foto Sesudah';">
                        <img id="d_preview-sesudah" class="photo-preview" style="margin-top:12px; max-height:200px; max-width:100%;">
                    </div>
                </div>

                <input type="hidden" name="foto_ai_raw" id="d_foto_ai_raw">
                
                <div style="margin-top:20px; text-align:center;">
                    <button type="button" id="d_ai-eval-btn" class="d-btn d-btn-ghost" style="padding:14px 32px; font-size:15px;" onclick="aiScanEvaluasi.analyze('d_')">
                        🤖 Analisis Perbandingan AI
                    </button>
                    
                    <div id="d_ai-eval-loader" class="ai-loader" style="margin-top:16px;">
                        <div class="spinner"></div>
                        <div>AI Gemini sedang menganalisis tingkat kematian gulma...</div>
                    </div>
                </div>
            </div>

            <!-- Fields populated by AI -->
            <div class="d-card" id="d_ai-eval-result" style="display:none; margin-bottom:20px; border-color:var(--leaf);">
                <div class="d-card-header" style="background:var(--leaf-light);">
                    <div class="d-card-title" style="color:var(--forest);">Hasil Analisis Efektivitas</div>
                </div>
                <div class="d-card-body">
                    <div class="d-table-row">
                        <div class="d-table-lbl">Tingkat Efektivitas</div>
                        <div class="d-table-val" id="d_ai-eval-efektivitas" style="font-size:24px; color:var(--forest);">0%</div>
                    </div>
                    <div class="d-table-row">
                        <div class="d-table-lbl">Kategori</div>
                        <div class="d-table-val"><span id="d_ai-eval-kategori" class="d-badge done"></span></div>
                    </div>
                    <div class="d-table-row" style="flex-direction:column; align-items:flex-start;">
                        <div class="d-table-lbl" style="margin-bottom:8px;">Analisis AI</div>
                        <div class="d-table-val" id="d_ai-eval-catatan" style="font-weight:400; line-height:1.5;"></div>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" id="d_efektivitas" name="efektivitas" value="{{ $block->evaluasi->efektivitas ?? '' }}">
            <input type="hidden" id="d_kategori" name="kategori" value="{{ $block->evaluasi->kategori ?? '' }}">
            <input type="hidden" id="d_catatan" name="catatan" value="{{ $block->evaluasi->catatan ?? '' }}">

            <button type="submit" class="d-btn d-btn-green d-btn-full" style="padding:16px; font-size:16px;">
                Simpan Hasil Evaluasi
            </button>
        </form>
    </div>
    
    <div>
        <!-- Info singkat -->
        <div class="d-card">
            <div class="d-card-header"><div class="d-card-title">Info Aplikasi</div></div>
            <div class="d-card-body-0">
                <div class="d-table-row"><div class="d-table-lbl">Afdeling</div><div class="d-table-val">{{ $block->afdeling }}</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Target Gulma</div><div class="d-table-val">{{ $block->gulma }}</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Herbisida</div><div class="d-table-val">{{ $block->herbisida }}</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Pemakaian</div><div class="d-table-val">{{ $block->aktual }} L</div></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="/js/ai-scan.js"></script>
@endpush
