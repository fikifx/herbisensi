@extends('layouts.app')

@section('title', 'Master Gulma')

@section('content_mobile')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <input type="text" class="search" placeholder="Cari gulma..." id="search-input" style="flex:1; margin-bottom:0;">
        <a href="{{ route('master-gulmas.create') }}" class="btn leaf" style="margin-left:12px; height:48px; display:flex; align-items:center; justify-content:center; padding:0 16px;">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </a>
    </div>

    @foreach($gulmas as $gulma)
        <a href="{{ route('master-gulmas.edit', $gulma) }}" class="joblist-item" data-code="{{ strtolower($gulma->nama_gulma) }}" style="display:flex; gap:14px; align-items:center;">
            @if($gulma->foto)
                <img src="{{ Storage::url($gulma->foto) }}" style="width:60px; height:60px; object-fit:cover; border-radius:10px;" onclick="event.preventDefault(); openZoomModal(this.src)">
            @else
                <div style="width:60px; height:60px; background:#EEF2EC; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#5B6B60; font-size:24px;">🌱</div>
            @endif
            <div style="flex:1;">
                <div class="code" style="font-size:14px;">{{ $gulma->nama_gulma }}</div>
                <div class="meta" style="margin-top:2px;">
                    Sampel: {{ $gulma->sampel ?: '-' }} • Jumlah: {{ $gulma->jumlah }}
                </div>
            </div>
        </a>
    @endforeach
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $gulmas->links() }}
    </div>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Master Gulma</div>
            <div class="d-section-sub">Daftar spesies gulma (Master Data)</div>
        </div>
        <div>
            <a href="{{ route('master-gulmas.create') }}" class="d-btn d-btn-green">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Gulma
            </a>
        </div>
    </div>

    <div class="d-card" style="margin-bottom:24px;">
        <div class="d-card-body">
            <input type="text" class="d-search" placeholder="Cari nama gulma..." id="d-search-input">
        </div>
    </div>

    <div class="d-job-grid">
        @foreach($gulmas as $gulma)
            <a href="{{ route('master-gulmas.edit', $gulma) }}" class="d-job-card" data-code="{{ strtolower($gulma->nama_gulma) }}" style="display:flex; flex-direction:column; align-items:center; text-align:center;">
                @if($gulma->foto)
                    <img src="{{ Storage::url($gulma->foto) }}" style="width:100px; height:100px; object-fit:cover; border-radius:14px; margin-bottom:12px; cursor:zoom-in;" onclick="event.preventDefault(); openZoomModal(this.src)">
                @else
                    <div style="width:100px; height:100px; background:#EEF2EC; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#5B6B60; font-size:40px; margin-bottom:12px;">🌱</div>
                @endif
                <div class="d-job-code" style="font-size:15px; margin-bottom:6px;">{{ $gulma->nama_gulma }}</div>
                <div class="d-job-meta" style="justify-content:center;">
                    <div><b>Sampel:</b> {{ $gulma->sampel ?: '-' }}</div>
                    <div><b>Jumlah:</b> {{ $gulma->jumlah }}</div>
                </div>
            </a>
        @endforeach
    </div>
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $gulmas->links() }}
    </div>
@endsection

@push('css')
<style>
.img-zoom-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.8); z-index: 9999;
    display: none; justify-content: center; align-items: center;
}
.img-zoom-overlay img { max-width: 90%; max-height: 90%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
.img-zoom-close { position: absolute; top: 20px; right: 20px; color: white; font-size: 30px; cursor: pointer; font-weight: bold; }
</style>
@endpush

@push('js')
<script>
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

function openZoomModal(src) {
    document.getElementById('zoom-img').src = src;
    document.getElementById('zoom-overlay').style.display = 'flex';
}
function closeZoomModal() {
    document.getElementById('zoom-overlay').style.display = 'none';
}
</script>
@endpush

<div class="img-zoom-overlay" id="zoom-overlay" onclick="closeZoomModal()">
    <span class="img-zoom-close">&times;</span>
    <img id="zoom-img" src="" onclick="event.stopPropagation()">
</div>
