@extends('layouts.app')

@section('title', 'Pemakaian & Riwayat')
@section('back', route('pekerjaan.show', $block))

@section('content_mobile')
    <div style="text-align:center; margin-bottom:16px;">
        <div style="font-size:12px; color:var(--ink-soft); margin-bottom:4px;">Blok Terpilih</div>
        <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700; color:var(--forest);">{{ $block->block_code }}</div>
    </div>

    <!-- Scan Barcode Box -->
    <div class="scanbox" style="background: linear-gradient(135deg, #183F30 0%, #2A6A4E 100%); border-radius:20px; padding:24px 20px; position:relative; overflow:hidden; box-shadow:0 8px 24px rgba(24,63,48,0.2);">
        <div style="position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(124,185,59,0.3) 0%, transparent 60%); border-radius: 50%;"></div>
        <div style="position:relative; z-index:2;">
            <h3 style="margin:0 0 8px; font-family:'Space Grotesk',sans-serif; font-size:18px;">Scanner Barcode</h3>
            
            <div id="scan-video-wrap" style="display:none; margin-bottom:14px;">
                <video id="scan-video" style="width:100%; border-radius:12px; border:2px solid var(--leaf);"></video>
            </div>
            
            <div id="scan-result-batch" style="margin-bottom:14px; font-size:13px; font-weight:600; color:var(--leaf-light); opacity:0.9;">
                Arahkan kamera ke jerigen herbisida
            </div>

            <button type="button" id="start-scan-btn" class="btn ghost" style="margin-top:0; border-radius:100px; padding:10px 24px; display:inline-flex; border:none; background:rgba(255,255,255,0.9); font-weight:700;">
                <svg viewBox="0 0 24 24" width="16" height="16" style="margin-right:8px;"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Buka Kamera
            </button>
            <button type="button" id="stop-scan-btn" class="btn red" style="margin-top:0; border-radius:100px; padding:10px 24px; display:none;">
                Tutup Kamera
            </button>

            <form action="{{ route('pekerjaan.pemakaian', $block) }}" method="POST" onsubmit="submitPemakaian(event)" style="margin-top:20px; background:rgba(255,255,255,0.15); padding:16px; border-radius:16px; text-align:left; border:1px solid rgba(255,255,255,0.2); backdrop-filter:blur(5px);">
                @csrf
                <div style="font-weight:700; margin-bottom:12px; font-size:14px;">Input Manual</div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11.5px; margin-bottom:6px; opacity:0.9;">Nomor Batch</label>
                    <input type="text" id="batch" name="batch" required style="width:100%; padding:12px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-weight:600; color:var(--ink);">
                </div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:11.5px; margin-bottom:6px; opacity:0.9;">Qty (Liter)</label>
                    <input type="number" name="jerigen" value="20" required style="width:100%; padding:12px; border-radius:8px; border:none; font-family:'Inter',sans-serif; font-weight:600; color:var(--ink);">
                </div>
                <button type="submit" class="btn leaf" style="margin-top:0; padding:12px; border-radius:100px;">Simpan Pemakaian</button>
            </form>
        </div>
    </div>

    <!-- Info Selisih -->
    <div style="display:flex; justify-content:space-between; align-items:center; background:#fff; padding:20px; border-radius:16px; border:1px solid var(--line); margin:20px 0; box-shadow:0 4px 12px rgba(0,0,0,0.02);">
        <div>
            <div style="font-size:11.5px; color:var(--ink-soft); margin-bottom:4px; font-weight:500;">Pemakaian Aktual</div>
            <div style="font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700;"><span id="aktual-display-mobile">{{ $block->aktual }}</span><span style="font-size:16px; color:var(--ink-soft);"> L</span></div>
        </div>
        <div style="text-align:right">
            <div style="font-size:11.5px; color:var(--ink-soft); margin-bottom:4px; font-weight:500;">Selisih Target</div>
            @if($selisih > 0)
                <div style="font-size:18px; font-weight:700; color:var(--red);">+{{ $selisih }} L</div>
            @else
                <div style="font-size:18px; font-weight:700; color:var(--leaf);">{{ $selisih }} L</div>
            @endif
        </div>
    </div>

    <!-- Riwayat -->
    <div style="font-size:14px; font-weight:700; color:var(--ink-soft); margin:24px 0 12px; text-transform:uppercase; letter-spacing:0.5px;">Riwayat Scan Terakhir</div>
    <div style="background:#fff; border-radius:16px; border:1px solid var(--line); box-shadow:0 4px 12px rgba(0,0,0,0.02); overflow:hidden;">
        @forelse($block->pemakaians as $p)
            <div style="padding:16px; border-bottom:1px solid #f0f4ef; display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:36px; height:36px; border-radius:10px; background:var(--leaf-light); color:var(--forest); display:flex; align-items:center; justify-content:center;">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-weight:700; font-size:14px; color:var(--ink);">{{ $p->jerigen }} Liter</div>
                        <div style="font-size:11.5px; color:var(--ink-soft); margin-top:2px;">Batch: {{ $p->batch }}</div>
                    </div>
                </div>
                <div style="font-size:12px; color:var(--ink-soft); font-weight:500; text-align:right;">
                    {{ $p->waktu->format('H:i') }}
                </div>
            </div>
        @empty
            <div style="padding:40px 20px; text-align:center; color:var(--ink-soft);">
                <div style="font-size:28px; margin-bottom:8px;">📭</div>
                <div style="font-size:13px; font-weight:500;">Belum ada riwayat pemakaian.</div>
            </div>
        @endforelse
    </div>

    @if($block->status == 'Belum Selesai')
        <form action="{{ route('pekerjaan.selesai', $block) }}" method="POST">
            @csrf
            <button class="btn" style="margin-top:24px; padding:14px; font-size:15px;">Tandai Pekerjaan Selesai</button>
        </form>
    @else
        <div style="margin-top:24px; background:#E7F2DA; border:1px solid #7CB93B; border-radius:14px; padding:16px; display:flex; align-items:center; gap:12px;">
            <div style="width:32px; height:32px; background:#fff; color:#7CB93B; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">✅</div>
            <div>
                <div style="font-weight:700; font-size:14px; color:#1B2A20;">Pekerjaan Selesai</div>
                <div style="font-size:12px; color:#5B6B60; margin-top:2px;">Blok ini telah diselesaikan.</div>
            </div>
        </div>
        <a href="{{ route('pekerjaan.evaluasi', $block) }}" class="btn leaf" style="margin-top:16px; padding:14px; font-size:15px;">Lanjutkan ke Evaluasi AI</a>
    @endif
@endsection

@section('content_desktop')
    <div style="margin-bottom: 24px;">
        <div class="d-section-title">Pemakaian & Riwayat</div>
        <div class="d-section-sub">Kelola pemakaian material untuk blok <b>{{ $block->block_code }}</b></div>
    </div>

    <div class="d-page-2col">
        <!-- Kolom Kiri: Form Scanner Premium -->
        <div>
            <div style="background: linear-gradient(135deg, #183F30 0%, #2A6A4E 100%); border-radius: 20px; padding: 32px; color: #fff; box-shadow: 0 16px 40px rgba(24,63,48,0.25); position: relative; overflow: hidden; margin-bottom: 24px;">
                <div style="position: absolute; right: -40px; top: -40px; width: 160px; height: 160px; background: radial-gradient(circle, rgba(124,185,59,0.2) 0%, transparent 60%); border-radius: 50%;"></div>
                
                <div style="position:relative; z-index:2; text-align: center;">
                    <div style="width:60px; height:60px; background:rgba(255,255,255,0.15); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; border:1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                        <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" fill="none" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    </div>
                    <h3 style="margin:0 0 8px; font-family:'Space Grotesk',sans-serif; font-size:22px; font-weight:700;">Scanner Barcode</h3>
                    <p style="opacity:0.8; font-size:14px; margin:0 0 24px;">Arahkan kamera ke barcode di jerigen material.</p>
                    
                    <div id="scan-video-wrap" style="display:none; max-width:100%; margin:0 auto 20px;">
                        <video id="scan-video" style="width:100%; border-radius:12px; border:3px solid var(--leaf); box-shadow: 0 8px 24px rgba(0,0,0,0.3);"></video>
                    </div>
                    <div id="scan-result-batch" style="margin-bottom:20px; font-weight:600; font-size:15px; color:#C2DFA0; letter-spacing:1px;"></div>

                    <button type="button" id="start-scan-btn" class="d-btn d-btn-ghost" style="border-radius:100px; padding:12px 28px; background:rgba(255,255,255,0.9); color:var(--forest); border:none; font-weight:700; width:auto; display:inline-flex; align-items:center; justify-content:center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"><svg viewBox="0 0 24 24" width="18" height="18" style="margin-right:8px;"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg> Buka Kamera</button>
                    <button type="button" id="stop-scan-btn" class="d-btn d-btn-red" style="border-radius:100px; padding:12px 28px; display:none; width:auto; margin:0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">Tutup Kamera</button>
                </div>
            </div>
            
            <form action="{{ route('pekerjaan.pemakaian', $block) }}" method="POST" onsubmit="submitPemakaian(event)" style="background:#fff; padding:24px; border-radius:20px; box-shadow:0 4px 16px rgba(0,0,0,0.03); border:1px solid var(--line);">
                @csrf
                <div style="font-family:'Space Grotesk',sans-serif; font-size:18px; font-weight:700; margin-bottom:20px;">Input Manual / Hasil Scan</div>
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--ink); margin-bottom:8px;">Nomor Batch</label>
                    <input type="text" id="batch" name="batch" required style="width:100%; padding:14px; border-radius:12px; border:1px solid #DDE6D8; font-family:'Inter',sans-serif; font-size:15px; background:#F7FAF5; outline:none; transition:border 0.2s;" onfocus="this.style.borderColor='var(--leaf)'" onblur="this.style.borderColor='#DDE6D8'">
                </div>
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--ink); margin-bottom:8px;">Qty (Liter)</label>
                    <input type="number" name="jerigen" value="20" required style="width:100%; padding:14px; border-radius:12px; border:1px solid #DDE6D8; font-family:'Inter',sans-serif; font-size:15px; background:#F7FAF5; outline:none; transition:border 0.2s;" onfocus="this.style.borderColor='var(--leaf)'" onblur="this.style.borderColor='#DDE6D8'">
                </div>
                <button type="submit" class="d-btn d-btn-green d-btn-full" style="padding:14px; font-size:15px;">Simpan Pemakaian</button>
            </form>
        </div>
        
        <!-- Kolom Kanan: Riwayat Premium -->
        <div>
            <div class="d-card" style="margin-bottom:20px; border-radius:20px; overflow:hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                <div class="d-card-header" style="padding:20px 24px; background:linear-gradient(90deg, #F9FBF8, #fff);">
                    <div class="d-card-title">Pemakaian vs Rekomendasi</div>
                </div>
                <div class="d-card-body" style="background:#F7FAF5; border-bottom:1px solid var(--line); padding:24px; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-size:13px; color:var(--ink-soft); font-weight:500;">Total Aktual</div>
                        <div style="font-family:'Space Grotesk',sans-serif; font-size:32px; font-weight:700; color:var(--forest); line-height:1.2;"><span id="aktual-display">{{ $block->aktual }}</span><span style="font-size:20px; color:var(--ink-soft);"> L</span></div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:13px; color:var(--ink-soft); font-weight:500;">Selisih Target</div>
                        @if($selisih > 0)
                            <div style="font-size:20px; font-weight:700; color:var(--red);">+{{ $selisih }} L <span style="font-size:14px; opacity:0.8;">({{ $persenSelisih }}%)</span></div>
                        @else
                            <div style="font-size:20px; font-weight:700; color:var(--leaf);">{{ $selisih }} L</div>
                        @endif
                    </div>
                </div>
                
                <div class="d-card-header" style="padding:16px 24px; border-top:1px solid var(--line); border-bottom:1px solid var(--line);">
                    <div class="d-card-title" style="font-size:14px; color:var(--ink-soft);">RIWAYAT SCAN TERAKHIR</div>
                </div>
                <div class="d-card-body-0">
                    @forelse($block->pemakaians as $p)
                        <div class="d-table-row" style="padding:16px 24px; border-bottom:1px solid #f0f4ef; transition:background 0.2s;" onmouseover="this.style.background='#fbfdfa'" onmouseout="this.style.background='none'">
                            <div style="display:flex; align-items:center; gap:16px;">
                                <div style="width:40px; height:40px; border-radius:10px; background:var(--leaf-light); color:var(--forest); display:flex; align-items:center; justify-content:center;">
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                                <div>
                                    <div style="font-weight:700; font-size:15px; color:var(--ink);">{{ $p->jerigen }} Liter</div>
                                    <div style="font-size:12.5px; color:var(--ink-soft); margin-top:2px; font-family:'Space Grotesk',sans-serif;">Batch: {{ $p->batch }}</div>
                                </div>
                            </div>
                            <div style="font-size:13px; color:var(--ink-soft); font-weight:500; text-align:right;">
                                <div>{{ $p->waktu->format('d M Y') }}</div>
                                <div>{{ $p->waktu->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="padding:40px; text-align:center; color:var(--ink-soft);">
                            <div style="font-size:32px; margin-bottom:12px;">📭</div>
                            <div style="font-size:14px; font-weight:500;">Belum ada riwayat scan.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($block->status == 'Belum Selesai')
                <form action="{{ route('pekerjaan.selesai', $block) }}" method="POST">
                    @csrf
                    <button class="d-btn d-btn-primary d-btn-full" style="padding:16px; font-size:16px; border-radius:16px;">Tandai Pekerjaan Selesai</button>
                </form>
            @else
                <div class="d-alert info" style="margin-bottom:16px; border-radius:16px; padding:16px;">
                    <div class="d-alert-icon" style="background:#fff; color:var(--leaf);">✅</div>
                    <div class="d-alert-content">
                        <div class="d-alert-title" style="font-size:15px;">Pekerjaan Selesai</div>
                        <div class="d-alert-sub" style="font-size:13px;">Anda telah menyelesaikan penyemprotan di blok ini.</div>
                    </div>
                </div>
                <a href="{{ route('pekerjaan.evaluasi', $block) }}" class="d-btn d-btn-green d-btn-full" style="padding:16px; font-size:16px; border-radius:16px;">Lanjutkan ke Evaluasi AI</a>
            @endif
        </div>
    </div>
@endsection

@push('js')
<script src="/js/barcode.js"></script>
@endpush
