@extends('layouts.app')

@section('title', 'Dashboard Manajer')

@section('content_mobile')
<div class="pill-tabs" style="margin-top:10px;">
    <a href="{{ route('dashboard', ['tab' => 'utama']) }}" class="pt {{ $tab == 'utama' ? 'active' : '' }}">Ringkasan</a>
    <a href="{{ route('dashboard', ['tab' => 'peta']) }}" class="pt {{ $tab == 'peta' ? 'active' : '' }}">Peta Lahan</a>
    <a href="{{ route('dashboard', ['tab' => 'laporan']) }}" class="pt {{ $tab == 'laporan' ? 'active' : '' }}">Laporan</a>
</div>

@if($tab == 'utama')
    <div class="card" style="background:linear-gradient(135deg,var(--forest),var(--forest-2)); color:#fff; border:none;">
        <div style="font-size:12px; opacity:0.8; margin-bottom:4px;">Total Efisiensi Kebun</div>
        <div style="display:flex; align-items:baseline; gap:8px;">
            <div style="font-family:'Space Grotesk',sans-serif; font-size:36px; font-weight:700; color:var(--leaf);">{{ $efisiensi }}%</div>
            <div style="font-size:12px; opacity:0.8;">Bulan Ini</div>
        </div>
        
        <div style="margin-top:20px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div>
                <div style="font-size:11px; opacity:0.7;">Rekomendasi</div>
                <div style="font-weight:700; font-size:15px; margin-top:2px;">{{ $rekomendasiTotal }} L</div>
            </div>
            <div>
                <div style="font-size:11px; opacity:0.7;">Aktual Pakai</div>
                <div style="font-weight:700; font-size:15px; margin-top:2px; color:var(--leaf-light);">{{ $pemakaianAktual }} L</div>
            </div>
        </div>
    </div>

    @if($selisih > 0)
        <div class="flash-error" style="background:var(--red-light); color:var(--red); border-color:var(--red); margin-top:16px;">
            <div style="font-weight:700; font-size:13px; margin-bottom:4px;">⚠️ Over Budget ({{ $selisih }} L)</div>
            <div style="font-size:11.5px;">Terdapat potensi pemborosan senilai Rp {{ number_format($potensiPemborosan, 0, ',', '.') }}</div>
        </div>
    @endif

    <div class="section-title" style="margin-top:24px;">Top 5 Blok Terboros</div>
    <div class="card" style="padding:0; overflow:hidden;">
        @foreach($topBoros as $i => $t)
            <div class="rank-item" style="padding:12px 16px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="font-size:12px; font-weight:700; color:var(--ink-soft); width:14px;">{{ $i+1 }}</div>
                    <div class="code">{{ $t['id'] }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:13.5px; font-weight:700; color:var(--red);">+{{ $t['liter'] }} L</div>
                    <div style="font-size:10.5px; color:var(--ink-soft);">Over {{ $t['persen'] }}%</div>
                </div>
            </div>
        @endforeach
    </div>

@elseif($tab == 'peta')
    <div class="card">
        <div style="font-size:13px; font-weight:600; text-align:center; margin-bottom:14px; color:var(--forest);">Peta Efisiensi Blok (Divisi 1)</div>
        
        <div class="mapgrid">
            @foreach($peta as $p)
                @php
                    $bg = $p['status'] == 'ok' ? 'var(--leaf)' : ($p['status'] == 'warn' ? 'var(--amber)' : 'var(--red)');
                @endphp
                <div class="mapcell" style="background:{{ $bg }};">{{ $p['id'] }}</div>
            @endforeach
        </div>
        
        <div class="legend">
            <div class="li"><div class="sw" style="background:var(--leaf);"></div> Efisien / Tepat</div>
            <div class="li"><div class="sw" style="background:var(--amber);"></div> Over &lt;20%</div>
            <div class="li"><div class="sw" style="background:var(--red);"></div> Over &gt;20%</div>
        </div>
    </div>
    <div class="note">Blok merah menandakan pemakaian herbisida melebihi dosis rekomendasi lebih dari 20%. Diperlukan kalibrasi alat semprot (sprayer).</div>
@endif
@endsection

@section('content_desktop')
<div class="d-tabs">
    <a href="{{ route('dashboard', ['tab' => 'utama']) }}" class="d-tab {{ $tab == 'utama' ? 'active' : '' }}">Ringkasan Utama</a>
    <a href="{{ route('dashboard', ['tab' => 'peta']) }}" class="d-tab {{ $tab == 'peta' ? 'active' : '' }}">Pemetaan Lahan</a>
    <a href="{{ route('dashboard', ['tab' => 'laporan']) }}" class="d-tab {{ $tab == 'laporan' ? 'active' : '' }}">Laporan Lengkap</a>
</div>

@if($tab == 'utama')
    <div class="d-metric-grid">
        <div class="d-metric green" style="grid-column: span 2;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <div class="d-metric-icon" style="margin-bottom:8px;"><svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div>
                    <div class="d-metric-val">Rp {{ number_format($potensiPemborosan, 0, ',', '.') }}</div>
                    <div class="d-metric-label">Potensi Pemborosan (Rp)</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:42px; font-weight:700; color:var(--leaf); font-family:'Space Grotesk',sans-serif; line-height:1;">{{ $efisiensi }}%</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.7); margin-top:6px;">Tingkat Efisiensi</div>
                </div>
            </div>
        </div>
        <div class="d-metric teal">
            <div class="d-metric-val">{{ $rekomendasiTotal }} L</div>
            <div class="d-metric-label">Total Rekomendasi</div>
        </div>
        <div class="d-metric {{ $selisih > 0 ? 'red' : 'green' }}">
            <div class="d-metric-val">{{ $pemakaianAktual }} L</div>
            <div class="d-metric-label">Aktual Terpakai</div>
            @if($selisih > 0)
                <div class="d-metric-sub" style="color:#FFB4A9; font-weight:700;">+{{ $selisih }} L Over Budget</div>
            @else
                <div class="d-metric-sub" style="color:var(--leaf-light); font-weight:700;">Sesuai Budget</div>
            @endif
        </div>
    </div>

    <div class="d-page-2col">
        <div class="d-card">
            <div class="d-card-header"><div class="d-card-title">Top 5 Blok Terboros</div></div>
            <div class="d-card-body-0">
                @foreach($topBoros as $i => $t)
                    <div class="d-rank-row">
                        <div class="d-rank-num {{ $i < 3 ? 'top' : '' }}">{{ $i+1 }}</div>
                        <div class="d-rank-code">{{ $t['id'] }}</div>
                        <div class="d-rank-bar-wrap">
                            <div class="d-rank-bar" style="width: {{ min(100, $t['persen']) }}%"></div>
                        </div>
                        <div class="d-rank-val" style="width:60px; text-align:right;">+{{ $t['liter'] }} L</div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="d-card">
            <div class="d-card-header"><div class="d-card-title">Peta Efisiensi (Heatmap)</div></div>
            <div class="d-card-body">
                <div class="d-mapgrid">
                    @foreach($peta as $p)
                        @php
                            $bg = $p['status'] == 'ok' ? 'var(--leaf)' : ($p['status'] == 'warn' ? 'var(--amber)' : 'var(--red)');
                        @endphp
                        <div class="d-mapcell" style="background:{{ $bg }};" title="Blok {{ $p['id'] }}">{{ $p['id'] }}</div>
                    @endforeach
                </div>
                
                <div class="legend" style="margin-top:20px; justify-content:center;">
                    <div class="li"><div class="sw" style="background:var(--leaf);"></div> Efisien</div>
                    <div class="li"><div class="sw" style="background:var(--amber);"></div> Over &lt;20%</div>
                    <div class="li"><div class="sw" style="background:var(--red);"></div> Over &gt;20%</div>
                </div>
            </div>
        </div>
    </div>
@elseif($tab == 'peta')
    <!-- Tampilan peta full yang mirip -->
    <div class="d-card" style="padding:40px;">
        <h2 style="text-align:center; font-family:'Space Grotesk',sans-serif; color:var(--forest); margin-bottom:30px;">Peta Lahan Keseluruhan</h2>
        <div class="d-mapgrid" style="grid-template-columns:repeat(10,1fr); gap:12px; max-width:800px; margin:0 auto;">
            @foreach($peta as $p)
                @php
                    $bg = $p['status'] == 'ok' ? 'var(--leaf)' : ($p['status'] == 'warn' ? 'var(--amber)' : 'var(--red)');
                @endphp
                <div class="d-mapcell" style="background:{{ $bg }}; padding:20px 0; font-size:14px; border-radius:12px;" title="Blok {{ $p['id'] }}">{{ $p['id'] }}</div>
            @endforeach
        </div>
    </div>
@endif
@endsection
