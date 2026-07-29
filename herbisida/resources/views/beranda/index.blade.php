@extends('layouts.app')

@section('title', 'Beranda')

@section('content_mobile')
    <div class="greet">
        {{ $greeting }}, <br><b>Andi (Agronomi)</b>
    </div>

    <!-- Alert -->
    <div style="margin-top:20px;">
        @if($belumSelesai > 0)
            <div class="flash-error" style="background:var(--amber-light); border-color:var(--amber); color:#8A5A16;">
                ⚠️ Anda memiliki {{ $belumSelesai }} pekerjaan yang belum diselesaikan hari ini.
            </div>
        @else
            <div class="flash-success">
                ✅ Semua pekerjaan hari ini sudah selesai!
            </div>
        @endif
    </div>

    <div class="section-title">Ringkasan Hari Ini</div>
    
    <div class="stat-grid">
        <div class="stat">
            <div class="n">{{ $totalBlok }}</div>
            <div class="l">Total Blok</div>
        </div>
        <div class="stat">
            <div class="n" style="color:var(--leaf)">{{ $selesai }}</div>
            <div class="l">Selesai</div>
        </div>
        <div class="stat">
            <div class="n" style="color:var(--amber)">{{ $belumSelesai }}</div>
            <div class="l">Pending</div>
        </div>
        <div class="stat">
            <div class="n" style="{{ $efisiensi < 100 ? 'color:var(--red)' : 'color:var(--forest)' }}">{{ $efisiensi }}%</div>
            <div class="l">Efisiensi</div>
        </div>
    </div>

    <a href="{{ route('pekerjaan.index') }}" class="btn">Mulai Pekerjaan</a>
@endsection

@section('content_desktop')
    <div class="d-greet-banner">
        <div>
            <div class="d-greet-sub">{{ $greeting }},</div>
            <div class="d-greet-name">Andi (Agronomi)</div>
            <div class="d-greet-date">{{ $now }}</div>
        </div>
        <div style="text-align:right">
            <div class="d-badge {{ $belumSelesai > 0 ? 'pending' : 'done' }}" style="font-size:13px; padding:6px 14px">
                {{ $belumSelesai > 0 ? $belumSelesai . ' Pekerjaan Pending' : 'Semua Selesai' }}
            </div>
        </div>
    </div>

    <div class="d-metric-grid">
        <div class="d-metric green">
            <div class="d-metric-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg></div>
            <div class="d-metric-val">{{ $totalBlok }}</div>
            <div class="d-metric-label">Total Blok</div>
        </div>
        <div class="d-metric teal">
            <div class="d-metric-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
            <div class="d-metric-val">{{ $selesai }}</div>
            <div class="d-metric-label">Blok Selesai</div>
        </div>
        <div class="d-metric amber">
            <div class="d-metric-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
            <div class="d-metric-val">{{ $belumSelesai }}</div>
            <div class="d-metric-label">Pending</div>
        </div>
        <div class="d-metric {{ $efisiensi < 100 ? 'red' : 'green' }}">
            <div class="d-metric-icon"><svg viewBox="0 0 24 24"><path d="M2 20h.01"></path><path d="M7 20v-4"></path><path d="M12 20v-8"></path><path d="M17 20V8"></path><path d="M22 4v16"></path></svg></div>
            <div class="d-metric-val">{{ $efisiensi }}%</div>
            <div class="d-metric-label">Efisiensi Material</div>
        </div>
    </div>

    <div class="d-page-2col">
        <div class="d-card">
            <div class="d-card-header">
                <div class="d-card-title">Tugas Hari Ini</div>
            </div>
            <div class="d-card-body">
                <a href="{{ route('pekerjaan.index') }}" class="d-btn d-btn-primary d-btn-full" style="padding:16px; font-size:16px;">
                    Buka Daftar Pekerjaan
                </a>
            </div>
        </div>
    </div>
@endsection
