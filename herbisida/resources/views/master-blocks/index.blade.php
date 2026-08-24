@extends('layouts.app')

@section('title', 'Master Blok')

@section('content_mobile')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <input type="text" class="search" placeholder="Cari blok..." id="search-input" style="flex:1; margin-bottom:0;">
        <a href="{{ route('master-blocks.create') }}" class="btn leaf" style="margin-left:12px; height:48px; display:flex; align-items:center; justify-content:center; padding:0 16px;">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </a>
    </div>

    @foreach($blocks as $block)
        <a href="{{ route('master-blocks.edit', $block) }}" class="joblist-item" data-code="{{ strtolower($block->block_code) }}">
            <div class="top">
                <div class="code">{{ $block->block_code }}</div>
                <div class="badge done">Topografi: {{ $block->topografi ?: '-' }}</div>
            </div>
            <div class="meta">
                Luas: {{ $block->luas_tanam }} Ha • Umur: {{ $block->umur_tanam }} ({{ $block->kategori_umur }})<br>
                Tahun Tanam: {{ $block->tahun_tanam }} • Pokok: {{ $block->jumlah_pokok }}
            </div>
        </a>
    @endforeach
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $blocks->links() }}
    </div>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Master Blok</div>
            <div class="d-section-sub">Daftar blok kebun (Master Data)</div>
        </div>
        <div>
            <a href="{{ route('master-blocks.create') }}" class="d-btn d-btn-green">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Blok
            </a>
        </div>
    </div>

    <div class="d-card" style="margin-bottom:24px;">
        <div class="d-card-body">
            <input type="text" class="d-search" placeholder="Cari kode blok..." id="d-search-input">
        </div>
    </div>

    <div class="d-job-grid">
        @foreach($blocks as $block)
            <a href="{{ route('master-blocks.edit', $block) }}" class="d-job-card" data-code="{{ strtolower($block->block_code) }}">
                <div class="d-job-top">
                    <div class="d-job-code">{{ $block->block_code }}</div>
                    <div class="d-job-afd">{{ $block->topografi ?: '-' }}</div>
                </div>
                <div class="d-job-meta">
                    <div><b>Luas:</b> {{ $block->luas_tanam }} Ha</div>
                    <div><b>Thn Tanam:</b> {{ $block->tahun_tanam }}</div>
                    <div><b>Pokok:</b> {{ $block->jumlah_pokok }}</div>
                    <div><b>Umur:</b> {{ $block->umur_tanam }} ({{ $block->kategori_umur }})</div>
                </div>
            </a>
        @endforeach
    </div>
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $blocks->links() }}
    </div>
@endsection

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
</script>
@endpush
