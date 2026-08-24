@extends('layouts.app')

@section('title', 'Edit Master Blok')
@section('back', route('master-blocks.index'))

@section('content_mobile')
    <form action="{{ route('master-blocks.update', $masterBlock) }}" method="POST" style="margin-bottom:100px;">
        @csrf
        @method('PUT')
        @include('master-blocks._form', ['block' => $masterBlock])
        
        <div style="position:fixed; bottom:80px; left:16px; right:16px; z-index:10; display:flex; gap:12px;">
            <button type="button" class="btn ghost" style="flex:1; border:1px solid #FF3B30; color:#FF3B30;" onclick="confirmDelete()">Hapus</button>
            <button type="submit" class="btn leaf" style="flex:2;">Simpan Perubahan</button>
        </div>
    </form>

    <form id="delete-form" action="{{ route('master-blocks.destroy', $masterBlock) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Edit Master Blok</div>
            <div class="d-section-sub">Ubah data referensi blok</div>
        </div>
    </div>

    <div class="d-card">
        <div class="d-card-body">
            <form action="{{ route('master-blocks.update', $masterBlock) }}" method="POST">
                @csrf
                @method('PUT')
                @include('master-blocks._form', ['block' => $masterBlock])
                
                <div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center;">
                    <button type="button" class="d-btn ghost" style="color:#FF3B30; border:1px solid #FF3B30;" onclick="confirmDelete()">Hapus Blok</button>
                    <button type="submit" class="d-btn d-btn-green">Simpan Perubahan</button>
                </div>
            </form>
            
            <form id="delete-form-desk" action="{{ route('master-blocks.destroy', $masterBlock) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
function confirmDelete() {
    if(confirm('Apakah Anda yakin ingin menghapus data master blok ini?')) {
        document.getElementById('delete-form').submit();
        document.getElementById('delete-form-desk').submit();
    }
}
</script>
@endpush
