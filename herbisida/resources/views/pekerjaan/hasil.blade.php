@extends('layouts.app')

@section('title', 'Hasil Evaluasi')
@section('back', route('pekerjaan.index'))

@section('content_mobile')
<div style="text-align:center; margin-bottom:24px;">
    <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Laporan Efektivitas Blok</div>
    <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--forest);">{{ $block->block_code }}</div>
</div>

<div class="card" style="text-align:center; padding:30px 20px;">
    <div class="donut">
        <svg viewBox="0 0 36 36" style="width:100%; height:100%; position:absolute; top:0; left:0;">
            <!-- Base circle -->
            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--line)" stroke-width="4"></path>
            <!-- Progress circle -->
            @php 
                $ef = $block->evaluasi ? $block->evaluasi->efektivitas : 0; 
                $stroke = $ef >= 80 ? 'var(--leaf)' : ($ef >= 50 ? 'var(--amber)' : 'var(--red)');
            @endphp
            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{{ $stroke }}" stroke-width="4" stroke-dasharray="{{ $ef }}, 100"></path>
        </svg>
        <div class="hole">
            <div class="n">{{ $ef }}<span style="font-size:16px">%</span></div>
            <div class="l">Mati</div>
        </div>
    </div>
    
    <div style="margin-top:16px;">
        <span class="badge {{ $ef >= 75 ? 'done' : 'over' }}" style="font-size:14px; padding:6px 16px;">
            {{ $block->evaluasi->kategori ?? 'Belum ada evaluasi' }}
        </span>
    </div>
</div>

<div class="section-title">Catatan Ahli / AI</div>
<div class="card">
    <p style="font-size:13px; line-height:1.6; color:var(--ink-soft); margin:0;">
        {{ $block->evaluasi->catatan ?? 'Tidak ada catatan.' }}
    </p>
</div>

<a href="{{ route('pekerjaan.index') }}" class="btn leaf" style="margin-top:24px;">Kembali ke Daftar Pekerjaan</a>
@endsection

@section('content_desktop')
<div class="d-page-2col">
    <div>
        <div class="d-card">
            <div class="d-card-header">
                <div class="d-card-title">Hasil Evaluasi Pengendalian Gulma</div>
            </div>
            <div class="d-card-body" style="display:flex; align-items:center; gap:40px;">
                <!-- Donut Chart -->
                <div class="d-donut" style="position:relative;">
                    <svg viewBox="0 0 36 36" style="width:100%; height:100%; position:absolute; top:0; left:0; transform:rotate(-90deg);">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--line)" stroke-width="3"></path>
                        @php 
                            $ef = $block->evaluasi ? $block->evaluasi->efektivitas : 0; 
                            $stroke = $ef >= 80 ? 'var(--leaf)' : ($ef >= 50 ? 'var(--amber)' : 'var(--red)');
                        @endphp
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{{ $stroke }}" stroke-width="3.5" stroke-dasharray="{{ $ef }}, 100" stroke-linecap="round"></path>
                    </svg>
                    <div class="d-donut-hole">
                        <div class="d-donut-n">{{ $ef }}<span style="font-size:14px">%</span></div>
                        <div class="d-donut-l">Efektif</div>
                    </div>
                </div>

                <div style="flex:1;">
                    <div class="d-badge {{ $ef >= 75 ? 'done' : 'over' }}" style="font-size:14px; padding:6px 14px; margin-bottom:12px;">
                        {{ $block->evaluasi->kategori ?? 'Belum ada data' }}
                    </div>
                    <div style="font-size:14px; line-height:1.6; color:var(--ink-soft);">
                        <b>Catatan:</b><br>
                        {{ $block->evaluasi->catatan ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
        
        <div style="margin-top:24px;">
            <a href="{{ route('pekerjaan.index') }}" class="d-btn d-btn-ghost">Kembali ke Daftar Pekerjaan</a>
        </div>
    </div>
    
    <div>
        <div class="d-card">
            <div class="d-card-header"><div class="d-card-title">Data Blok</div></div>
            <div class="d-card-body-0">
                <div class="d-table-row"><div class="d-table-lbl">Blok</div><div class="d-table-val">{{ $block->block_code }} (AFD {{ $block->afdeling }})</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Luas</div><div class="d-table-val">{{ $block->luas }} Ha</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Target Gulma</div><div class="d-table-val">{{ $block->gulma }}</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Herbisida</div><div class="d-table-val">{{ $block->herbisida }}</div></div>
                <div class="d-table-row"><div class="d-table-lbl">Pemakaian</div><div class="d-table-val">{{ $block->aktual }} L</div></div>
            </div>
        </div>
    </div>
</div>
@endsection
