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
            <input type="file" id="foto_sebelum" name="foto_sebelum" accept="image/*" style="font-size:11px;">
            <img id="preview-sebelum" class="photo-preview" style="margin-top:10px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; margin-bottom:6px;">📸 Foto Sesudah Aplikasi (H+14)</label>
            <input type="file" id="foto_sesudah" name="foto_sesudah" accept="image/*" style="font-size:11px;">
            <img id="preview-sesudah" class="photo-preview" style="margin-top:10px;">
        </div>
        
        <input type="hidden" name="foto_ai_raw" id="foto_ai_raw">
        
        <button type="button" id="ai-eval-btn" class="btn ghost" style="margin-top:0;" onclick="aiScanEvaluasi.analyze()">
            🤖 Analisis Perbandingan AI
        </button>
        
        <div id="ai-eval-loader" class="ai-loader">
            <div class="spinner"></div>
            <div>Membandingkan kedua foto dengan AI...</div>
        </div>
        
        <div id="ai-eval-result" style="display:none; background:rgba(0,0,0,0.15); padding:16px; border-radius:12px; margin-top:16px;">
            <div class="ai-result-badge">✅ Hasil Evaluasi AI Selesai</div>
            
            <div style="text-align:center; margin:14px 0;">
                <div style="font-size:12px; opacity:0.8;">Tingkat Efektivitas</div>
                <div id="ai-eval-efektivitas" style="font-family:'Space Grotesk',sans-serif; font-size:36px; font-weight:700; color:var(--leaf-light);">0%</div>
                <div id="ai-eval-kategori" style="font-weight:700; background:var(--leaf-light); color:var(--forest); display:inline-block; padding:4px 12px; border-radius:100px; font-size:11px; margin-top:6px;">-</div>
            </div>
            
            <div style="background:rgba(255,255,255,0.1); border-radius:8px; height:8px; overflow:hidden; margin-bottom:14px;">
                <div id="ai-eval-bar" style="height:100%; background:var(--leaf-light); width:0%; transition:width 0.5s;"></div>
            </div>
            
            <p id="ai-eval-catatan" style="font-size:12px; font-style:italic; line-height:1.5; margin:0; opacity:0.9; text-align:center;"></p>
        </div>
    </div>

    <!-- Hidden form fields to be submitted -->
    <input type="hidden" id="efektivitas" name="efektivitas" value="{{ $block->evaluasi->efektivitas ?? '' }}" required>
    <input type="hidden" id="kategori" name="kategori" value="{{ $block->evaluasi->kategori ?? '' }}" required>
    <input type="hidden" id="catatan" name="catatan" value="{{ $block->evaluasi->catatan ?? '' }}" required>

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

                <div class="d-table-row" style="padding:16px 0; border-bottom:1px solid rgba(255,255,255,0.1); align-items:flex-start;">
                    <div style="flex:1;">
                        <label style="display:block; font-size:12px; font-weight:700; margin-bottom:8px;">📸 Foto Sebelum</label>
                        <input type="file" id="foto_sebelum" name="foto_sebelum" accept="image/*" style="font-size:12px; width:100%;">
                        <img id="preview-sebelum" class="photo-preview" style="margin-top:12px; max-height:200px; max-width:100%;">
                    </div>
                    <div style="flex:1; padding-left:16px;">
                        <label style="display:block; font-size:12px; font-weight:700; margin-bottom:8px;">📸 Foto Sesudah (H+14)</label>
                        <input type="file" id="foto_sesudah" name="foto_sesudah" accept="image/*" style="font-size:12px; width:100%;">
                        <img id="preview-sesudah" class="photo-preview" style="margin-top:12px; max-height:200px; max-width:100%;">
                    </div>
                </div>

                <input type="hidden" name="foto_ai_raw" id="foto_ai_raw">
                
                <div style="margin-top:20px; text-align:center;">
                    <button type="button" id="ai-eval-btn" class="d-btn d-btn-ghost" style="padding:14px 32px; font-size:15px;" onclick="aiScanEvaluasi.analyze()">
                        🤖 Analisis Perbandingan AI
                    </button>
                    
                    <div id="ai-eval-loader" class="ai-loader" style="margin-top:16px;">
                        <div class="spinner"></div>
                        <div>AI Gemini sedang menganalisis tingkat kematian gulma...</div>
                    </div>
                </div>
            </div>

            <!-- Fields populated by AI -->
            <div class="d-card" id="ai-eval-result" style="display:none; margin-bottom:20px; border-color:var(--leaf);">
                <div class="d-card-header" style="background:var(--leaf-light);">
                    <div class="d-card-title" style="color:var(--forest);">Hasil Analisis Efektivitas</div>
                </div>
                <div class="d-card-body">
                    <div class="d-table-row">
                        <div class="d-table-lbl">Tingkat Efektivitas</div>
                        <div class="d-table-val" id="ai-eval-efektivitas" style="font-size:24px; color:var(--forest);">0%</div>
                    </div>
                    <div class="d-table-row">
                        <div class="d-table-lbl">Kategori</div>
                        <div class="d-table-val"><span id="ai-eval-kategori" class="d-badge done"></span></div>
                    </div>
                    <div class="d-table-row" style="flex-direction:column; align-items:flex-start;">
                        <div class="d-table-lbl" style="margin-bottom:8px;">Analisis AI</div>
                        <div class="d-table-val" id="ai-eval-catatan" style="font-weight:400; line-height:1.5;"></div>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" id="efektivitas" name="efektivitas" value="{{ $block->evaluasi->efektivitas ?? '' }}">
            <input type="hidden" id="kategori" name="kategori" value="{{ $block->evaluasi->kategori ?? '' }}">
            <input type="hidden" id="catatan" name="catatan" value="{{ $block->evaluasi->catatan ?? '' }}">

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
