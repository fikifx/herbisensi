@extends('layouts.app')

@section('title', 'Pemakaian & Riwayat')
@section('back', route('pekerjaan.show', $block))

@section('content_mobile')
    <div style="text-align:center; margin-bottom:16px;">
        <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Blok Terpilih</div>
        <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--forest);">{{ $block->block_code }}</div>
    </div>

    <!-- Scan Barcode Box -->
    <div class="scanbox">
        <h3 style="margin:0 0 10px; font-family:'Space Grotesk',sans-serif; font-size:16px;">Scan Barcode Material</h3>
        
        <div id="scan-video-wrap" style="display:none; margin-bottom:14px;">
            <video id="scan-video" style="width:100%; border-radius:12px; border:2px solid var(--leaf);"></video>
        </div>
        
        <div id="scan-result-batch" style="margin-bottom:14px; font-size:13px; font-weight:600; color:var(--leaf-light);">
            Arahkan kamera ke barcode jerigen herbisida
        </div>

        <button type="button" id="start-scan-btn" class="btn ghost" style="margin-top:0; border-radius:100px; padding:10px 24px; display:inline-flex;">
            <svg viewBox="0 0 24 24" width="18" height="18" style="margin-right:8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Buka Kamera Scanner
        </button>
        <button type="button" id="stop-scan-btn" class="btn red" style="margin-top:0; border-radius:100px; padding:10px 24px; display:none;">
            Tutup Kamera
        </button>

        <form action="{{ route('pekerjaan.pemakaian', $block) }}" method="POST" onsubmit="submitPemakaian(event)" style="margin-top:20px; background:rgba(255,255,255,0.1); padding:14px; border-radius:12px; text-align:left;">
            @csrf
            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; opacity:0.8;">No. Batch (Otomatis dari scan / input manual)</label>
                <input type="text" id="batch" name="batch" required style="width:100%; padding:10px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-weight:600;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; margin-bottom:4px; opacity:0.8;">Volume Jerigen (Liter)</label>
                <input type="number" name="jerigen" value="20" required style="width:100%; padding:10px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-weight:600;">
            </div>
            <button type="submit" class="btn leaf" style="margin-top:0; padding:10px;">Tambah Pemakaian</button>
        </form>
    </div>

    <!-- Info Selisih -->
    <div style="display:flex; justify-content:space-between; align-items:center; background:var(--card); padding:16px; border-radius:14px; border:1px solid var(--line); margin:20px 0;">
        <div>
            <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Pemakaian vs Rekomendasi</div>
            <div style="font-family:'Space Grotesk',sans-serif; font-size:18px; font-weight:700;"><span id="aktual-display">{{ $block->aktual }}</span> / {{ $block->rekomendasi }} L</div>
        </div>
        <div style="text-align:right">
            <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Selisih</div>
            @if($selisih > 0)
                <div style="font-size:15px; font-weight:700; color:var(--red);">+{{ $selisih }} L ({{ $persenSelisih }}%)</div>
            @else
                <div style="font-size:15px; font-weight:700; color:var(--leaf);">{{ $selisih }} L</div>
            @endif
        </div>
    </div>

    <!-- Riwayat -->
    <div class="section-title">Riwayat Scan Hari Ini</div>
    <div class="card" style="padding:0; overflow:hidden;">
        @forelse($block->pemakaians as $p)
            <div class="row" style="padding:14px 16px; border-bottom:1px solid var(--line); margin:0;">
                <div>
                    <div style="font-weight:700; font-size:13.5px; color:var(--ink);">{{ $p->jerigen }} Liter</div>
                    <div style="font-size:11.5px; color:var(--ink-soft); margin-top:2px;">Batch: {{ $p->batch }}</div>
                </div>
                <div style="font-size:11.5px; color:var(--ink-soft); font-weight:500;">
                    {{ $p->waktu->format('H:i') }}
                </div>
            </div>
        @empty
            <div style="padding:20px; text-align:center; font-size:12.5px; color:var(--ink-soft);">
                Belum ada riwayat pemakaian
            </div>
        @endforelse
    </div>

    @if($block->status == 'Belum Selesai')
        <form action="{{ route('pekerjaan.selesai', $block) }}" method="POST">
            @csrf
            <button class="btn" style="margin-top:24px;">Tandai Pekerjaan Selesai</button>
        </form>
    @else
        <div class="flash-success" style="margin-top:24px;">Pekerjaan telah ditandai selesai.</div>
        <a href="{{ route('pekerjaan.evaluasi', $block) }}" class="btn leaf">Lakukan Evaluasi AI</a>
    @endif
@endsection

@section('content_desktop')
    <div class="d-page-2col">
        <div>
            <!-- Kamera Scanner Box Desktop -->
            <div class="d-scanbox" style="margin-bottom:24px;">
                <h3 style="margin:0 0 10px; font-family:'Space Grotesk',sans-serif; font-size:20px;">Scanner Barcode Material</h3>
                <p style="opacity:0.8; font-size:13px; margin:0 0 20px;">Arahkan kamera device ke barcode di jerigen material</p>
                
                <div id="scan-video-wrap" style="display:none; max-width:400px; margin:0 auto 20px;">
                    <video id="scan-video" style="width:100%; border-radius:16px; border:3px solid var(--leaf);"></video>
                </div>
                <div id="scan-result-batch" style="margin-bottom:20px; font-weight:600; font-size:15px; color:var(--leaf-light);"></div>

                <button type="button" id="start-scan-btn" class="d-btn d-btn-ghost" style="border-radius:100px; padding:12px 28px;">Buka Kamera Scanner</button>
                <button type="button" id="stop-scan-btn" class="d-btn d-btn-red" style="border-radius:100px; padding:12px 28px; display:none;">Tutup Kamera</button>
                
                <form action="{{ route('pekerjaan.pemakaian', $block) }}" method="POST" onsubmit="submitPemakaian(event)" style="margin-top:24px; background:rgba(255,255,255,0.1); padding:24px; border-radius:16px; text-align:left; max-width:400px; margin-left:auto; margin-right:auto;">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="display:block; font-size:12px; margin-bottom:6px; opacity:0.9;">Nomor Batch</label>
                        <input type="text" id="batch" name="batch" required style="width:100%; padding:12px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-size:15px; font-weight:600;">
                    </div>
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:12px; margin-bottom:6px; opacity:0.9;">Volume (Liter)</label>
                        <input type="number" name="jerigen" value="20" required style="width:100%; padding:12px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-size:15px; font-weight:600;">
                    </div>
                    <button type="submit" class="d-btn d-btn-green d-btn-full" style="margin-top:0;">Simpan Pemakaian</button>
                </form>
            </div>
        </div>
        
        <div>
            <div class="d-card" style="margin-bottom:20px;">
                <div class="d-card-header">
                    <div class="d-card-title">Riwayat Pemakaian - {{ $block->block_code }}</div>
                </div>
                <div class="d-card-body" style="background:#F7FAF5; border-bottom:1px solid var(--line); display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-size:12px; color:var(--ink-soft);">Total Aktual</div>
                        <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700;"><span id="aktual-display">{{ $block->aktual }}</span> L</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:12px; color:var(--ink-soft);">Selisih vs Rekomendasi</div>
                        @if($selisih > 0)
                            <div style="font-size:16px; font-weight:700; color:var(--red);">+{{ $selisih }} L ({{ $persenSelisih }}%)</div>
                        @else
                            <div style="font-size:16px; font-weight:700; color:var(--leaf);">{{ $selisih }} L</div>
                        @endif
                    </div>
                </div>
                <div class="d-card-body-0">
                    @forelse($block->pemakaians as $p)
                        <div class="d-table-row">
                            <div>
                                <div style="font-weight:700; font-size:14px; color:var(--ink);">{{ $p->jerigen }} Liter</div>
                                <div style="font-size:12px; color:var(--ink-soft); margin-top:2px;">Batch: {{ $p->batch }}</div>
                            </div>
                            <div style="font-size:12px; color:var(--ink-soft); font-weight:500;">
                                {{ $p->waktu->format('d M Y H:i') }}
                            </div>
                        </div>
                    @empty
                        <div style="padding:30px; text-align:center; color:var(--ink-soft); font-size:13px;">Belum ada riwayat scan.</div>
                    @endforelse
                </div>
            </div>

            @if($block->status == 'Belum Selesai')
                <form action="{{ route('pekerjaan.selesai', $block) }}" method="POST">
                    @csrf
                    <button class="d-btn d-btn-primary d-btn-full" style="padding:16px;">Tandai Pekerjaan Selesai</button>
                </form>
            @else
                <div class="d-alert info" style="margin-bottom:16px;">
                    <div class="d-alert-icon">✅</div>
                    <div class="d-alert-content">
                        <div class="d-alert-title">Selesai</div>
                        <div class="d-alert-sub">Pekerjaan di blok ini telah selesai.</div>
                    </div>
                </div>
                <a href="{{ route('pekerjaan.evaluasi', $block) }}" class="d-btn d-btn-green d-btn-full" style="padding:16px;">Lanjutkan ke Evaluasi AI</a>
            @endif
        </div>
    </div>
@endsection

@push('js')
<script src="/js/barcode.js"></script>
@endpush
