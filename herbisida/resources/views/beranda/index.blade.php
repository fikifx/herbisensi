@extends('layouts.app')

@section('title', 'Beranda')

@section('content_mobile')
    <!-- Banner Glassmorphism Premium -->
    <div style="background: linear-gradient(135deg, #183F30 0%, #2A6A4E 100%); border-radius: 20px; padding: 24px 20px; color: #fff; position: relative; overflow: hidden; margin-top: 10px; box-shadow: 0 10px 30px rgba(24, 63, 48, 0.25);">
        <div style="position: absolute; top: -30px; right: -30px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(124,185,59,0.3) 0%, transparent 70%); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 2;">
            <div style="font-size: 13px; opacity: 0.8; margin-bottom: 4px; font-weight:500;">{{ $greeting }},</div>
            <div style="font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 12px; line-height: 1.2;">{{ auth()->user() ? auth()->user()->name : 'Super Visor' }}</div>
            
            <div style="display: flex; gap: 8px; align-items: center;">
                <span class="badge {{ $belumSelesai > 0 ? 'pending' : 'done' }}" style="background: rgba(255,255,255,0.2); color:#fff; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); padding: 5px 12px;">
                    {{ $belumSelesai > 0 ? $belumSelesai . ' Pekerjaan Pending' : 'Semua Selesai 🎉' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Statistik Premium -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 20px;">
        <div style="background: linear-gradient(135deg, #183F30 0%, #22553F 100%); border-radius: 16px; padding: 16px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 8px 24px rgba(24,63,48,0.2); display: flex; align-items: center; gap: 12px; transition: transform 0.2s;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.1); color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" fill="none" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg>
            </div>
            <div>
                <div style="font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: #fff; line-height:1;">{{ $totalBlok }}</div>
                <div style="font-size: 11.5px; color: rgba(255,255,255,0.8); margin-top: 4px; font-weight:500;">Total Blok</div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #8A5A16 0%, #B57F26 100%); border-radius: 16px; padding: 16px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 8px 24px rgba(138,90,22,0.3); display: flex; align-items: center; gap: 12px; transition: transform 0.2s;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.2); color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div>
                <div style="font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: #fff; line-height:1;">{{ $belumSelesai }}</div>
                <div style="font-size: 11.5px; color: rgba(255,255,255,0.9); margin-top: 4px; font-weight:500;">Pending</div>
            </div>
        </div>
    </div>

    <!-- Tugas Hari Ini -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 12px;">
        <div class="section-title" style="margin: 0;">Tugas Hari Ini</div>
        <a href="{{ route('pekerjaan.index') }}" style="font-size:12px; color:var(--leaf); font-weight:600; text-decoration:none;">Lihat Semua</a>
    </div>

    <div>
        @forelse($recentTasks as $task)
            <a href="{{ route('pekerjaan.show', $task->id) }}" class="joblist-item" style="box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s;">
                <div class="top">
                    <span class="code">{{ $task->block_code }} <span style="font-size:12px; color:var(--ink-soft); font-family:'Inter',sans-serif;">(AFD {{ $task->afdeling }})</span></span>
                    <span class="badge {{ $task->status == 'Selesai' ? 'done' : 'pending' }}">{{ $task->status }}</span>
                </div>
                <div class="meta" style="display:flex; align-items:center; gap:6px; margin-top:8px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2" style="color:var(--leaf);"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    <span>Target: {{ $task->rekomendasi }} L ({{ $task->luas }} Ha)</span>
                </div>
            </a>
        @empty
            <div style="text-align:center; padding:30px 0; color:var(--ink-soft); font-size:13px; background:#fff; border-radius:14px; border:1px dashed var(--line);">
                <div style="font-size:24px; margin-bottom:8px;">🏖️</div>
                Belum ada data tugas.
            </div>
        @endforelse
    </div>
@endsection

@section('content_desktop')
    <div class="d-greet-banner" style="box-shadow: 0 12px 40px rgba(24, 63, 48, 0.2); overflow: hidden; background: linear-gradient(135deg, #183F30 0%, #22553F 50%, #2A6A4E 100%);">
        <div style="position: absolute; right: -50px; top: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(124,185,59,0.2) 0%, transparent 60%); border-radius: 50%;"></div>
        <div style="position: absolute; left: 20%; bottom: -100px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); border-radius: 50%;"></div>
        <div style="position:relative; z-index: 2;">
            <div class="d-greet-sub" style="font-size: 15px;">{{ $greeting }},</div>
            <div class="d-greet-name" style="font-size: 32px; letter-spacing:-0.5px;">{{ auth()->user() ? auth()->user()->name : 'Super Visor' }}</div>
            <div class="d-greet-date" style="font-size: 14px; opacity:0.8; margin-top:8px;">{{ $now }}</div>
        </div>
        <div style="text-align:right; position:relative; z-index: 2;">
            <div class="d-badge {{ $belumSelesai > 0 ? 'pending' : 'done' }}" style="font-size:14px; padding:8px 18px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color:#fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                @if($belumSelesai > 0)
                    <span style="margin-right:6px;">⚠️</span> {{ $belumSelesai }} Pekerjaan Pending
                @else
                    <span style="margin-right:6px;">🎉</span> Semua Selesai
                @endif
            </div>
        </div>
    </div>

    <!-- Metrik yang lebih Pop-out dengan drop shadow elegan -->
    <div class="d-metric-grid">
        <div class="d-metric" style="background: linear-gradient(135deg, #183F30 0%, #22553F 100%); border: 1px solid rgba(255,255,255,0.1); color: #fff; box-shadow: 0 8px 24px rgba(24,63,48,0.25); transition: transform 0.3s; cursor:default;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="d-metric-icon" style="background:rgba(255,255,255,0.1); color:#fff;"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg></div>
            <div class="d-metric-val" style="color:#fff;">{{ $totalBlok }}</div>
            <div class="d-metric-label" style="color:rgba(255,255,255,0.8);">Total Blok Terdaftar</div>
        </div>
        <div class="d-metric" style="background: linear-gradient(135deg, #2A6A4E 0%, #3A7F54 100%); border: 1px solid rgba(255,255,255,0.1); color: #fff; box-shadow: 0 8px 24px rgba(42,106,78,0.25); transition: transform 0.3s; cursor:default;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="d-metric-icon" style="background:rgba(255,255,255,0.15); color:#fff;"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
            <div class="d-metric-val" style="color:#fff;">{{ $selesai }}</div>
            <div class="d-metric-label" style="color:rgba(255,255,255,0.8);">Tugas Selesai</div>
        </div>
        <div class="d-metric" style="background: linear-gradient(135deg, #8A5A16 0%, #B57F26 100%); border: 1px solid rgba(255,255,255,0.1); color: #fff; box-shadow: 0 8px 24px rgba(138,90,22,0.3); transition: transform 0.3s; cursor:default;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="d-metric-icon" style="background:rgba(255,255,255,0.2); color:#fff;"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
            <div class="d-metric-val" style="color:#fff;">{{ $belumSelesai }}</div>
            <div class="d-metric-label" style="color:rgba(255,255,255,0.9);">Tugas Pending</div>
        </div>
        <div class="d-metric" style="background: linear-gradient(135deg, var(--leaf), #5da320); color:#fff; border:none; box-shadow: 0 8px 24px rgba(124,185,59,0.3); transition: transform 0.3s; cursor:default;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='none'">
            <div class="d-metric-icon" style="background:rgba(255,255,255,0.2); color:#fff;"><svg viewBox="0 0 24 24"><path d="M2 20h.01"></path><path d="M7 20v-4"></path><path d="M12 20v-8"></path><path d="M17 20V8"></path><path d="M22 4v16"></path></svg></div>
            <div class="d-metric-val">{{ $efisiensi }}%</div>
            <div class="d-metric-label" style="color:rgba(255,255,255,0.9);">Efisiensi Material</div>
        </div>
    </div>

    <!-- Menampilkan Daftar Pekerjaan langsung di beranda, bukan cuma tombol -->
    <div style="margin-top: 32px; display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:16px;">
        <div>
            <div class="d-section-title">Pekerjaan Hari Ini</div>
            <div class="d-section-sub">Segera selesaikan blok yang tertunda</div>
        </div>
        <a href="{{ route('pekerjaan.index') }}" class="d-btn d-btn-ghost" style="padding: 8px 16px;">Lihat Semua</a>
    </div>

    <div class="d-job-grid" style="grid-template-columns: repeat(3, 1fr);">
        @forelse($recentTasks as $task)
            <a href="{{ route('pekerjaan.show', $task->id) }}" class="d-job-card" style="box-shadow: 0 4px 16px rgba(0,0,0,0.04); border: 1px solid var(--line); transition: all 0.2s;">
                <div class="d-job-top">
                    <div>
                        <div class="d-job-code">{{ $task->block_code }}</div>
                        <div class="d-job-afd">AFD {{ $task->afdeling }}</div>
                    </div>
                    <div class="d-badge {{ $task->status == 'Selesai' ? 'done' : 'pending' }}">
                        {{ $task->status }}
                    </div>
                </div>
                <div class="d-job-gulma">
                    <b>Target:</b> {{ $task->gulma }}<br>
                    <span style="opacity:0.7;">Kerapatan {{ $task->kerapatan }}</span>
                </div>
                <div class="d-job-meta">
                    <div class="d-job-chip">🌿 {{ $task->luas }} Ha</div>
                    <div class="d-job-chip">💧 {{ $task->status == 'Selesai' ? $task->aktual : '0' }} / {{ $task->rekomendasi }} L</div>
                </div>
            </a>
        @empty
            <div style="grid-column: span 3; text-align:center; padding: 60px 20px; background: #fff; border-radius: 16px; border: 1px dashed var(--line); color:var(--ink-soft);">
                <div style="font-size: 36px; margin-bottom: 12px;">🌱</div>
                <div style="font-family:'Space Grotesk',sans-serif; font-size:18px; color:var(--forest); font-weight:700;">Belum Ada Tugas</div>
                <p>Saat ini tidak ada pekerjaan herbisida yang terdaftar.</p>
            </div>
        @endforelse
    </div>
@endsection
