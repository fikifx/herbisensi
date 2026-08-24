@extends('layouts.app')

@section('title', 'Master Dosis')

@section('content_mobile')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <input type="text" class="search" placeholder="Cari item/gulma..." id="search-input" style="flex:1; margin-bottom:0;">
        <a href="{{ route('master-doses.create') }}" class="btn leaf" style="margin-left:12px; height:48px; display:flex; align-items:center; justify-content:center; padding:0 16px;">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" fill="none" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </a>
    </div>

    @foreach($doses as $dosis)
        <a href="{{ route('master-doses.edit', $dosis) }}" class="joblist-item" data-code="{{ strtolower($dosis->item_pekerjaan . ' ' . $dosis->jenis_gulma) }}">
            <div class="top">
                <div class="code" style="font-size:14px;">{{ $dosis->item_pekerjaan ?: 'N/A' }}</div>
                <div class="badge done">Mat: {{ collect([$dosis->material_1, $dosis->material_2, $dosis->material_3])->filter()->count() }}</div>
            </div>
            <div class="meta" style="margin-top:6px; color:var(--forest); font-weight:600;">{{ $dosis->jenis_gulma ?: 'Semua' }}</div>
            <div class="meta" style="margin-top:4px; display:flex; gap:10px;">
                <span>V.Semprot: {{ $dosis->volume_1 ?? $dosis->volume_2 ?? $dosis->volume_3 ?? '-' }}L</span>
                <span>Intersprayer: {{ $dosis->jumlah_intersprayer ?? '-' }}</span>
            </div>
        </a>
    @endforeach
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $doses->links() }}
    </div>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Master Dosis</div>
            <div class="d-section-sub">Daftar referensi dosis herbisida (Master Data)</div>
        </div>
        <div>
            <a href="{{ route('master-doses.create') }}" class="d-btn d-btn-green">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Dosis
            </a>
        </div>
    </div>

    <div class="d-card" style="margin-bottom:24px;">
        <div class="d-card-body">
            <input type="text" class="d-search" placeholder="Cari item pekerjaan atau jenis gulma..." id="d-search-input">
        </div>
    </div>

    <div class="d-job-grid">
        @foreach($doses as $dosis)
            <a href="{{ route('master-doses.edit', $dosis) }}" class="d-job-card" data-code="{{ strtolower($dosis->item_pekerjaan . ' ' . $dosis->jenis_gulma) }}">
                <div class="d-job-top">
                    <div class="d-job-code" style="font-size:15px;">{{ $dosis->item_pekerjaan ?: 'N/A' }}</div>
                    <div class="d-job-afd">Mat: {{ collect([$dosis->material_1, $dosis->material_2, $dosis->material_3])->filter()->count() }}</div>
                </div>
                <div class="d-job-gulma" style="font-weight:600; color:#183F30; margin-bottom:10px;">{{ $dosis->jenis_gulma ?: 'Semua Gulma' }}</div>
                
                <div style="font-size:11.5px; color:#5B6B60; background:#EEF2EC; padding:8px 10px; border-radius:8px; margin-bottom:10px;">
                    @if($dosis->material_1) <div>• {{ $dosis->material_1 }} ({{ $dosis->dosis_1 ?: '-' }}g/ha)</div> @endif
                    @if($dosis->material_2) <div>• {{ $dosis->material_2 }} ({{ $dosis->dosis_2 ?: '-' }}g/ha)</div> @endif
                    @if($dosis->material_3) <div>• {{ $dosis->material_3 }} ({{ $dosis->dosis_3 ?: '-' }}g/ha)</div> @endif
                </div>

                <div class="d-job-meta">
                    <div class="d-job-chip">Vol: {{ $dosis->volume_1 ?? $dosis->volume_2 ?? $dosis->volume_3 ?? '-' }}L</div>
                    <div class="d-job-chip">Jml IS: {{ $dosis->jumlah_intersprayer ?? '-' }}</div>
                </div>
            </a>
        @endforeach
    </div>
    
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $doses->links() }}
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
