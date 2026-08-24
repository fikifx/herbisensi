@extends('layouts.app')

@section('title', 'Edit Master Gulma')
@section('back', route('master-gulmas.index'))

@section('content_mobile')
    <form action="{{ route('master-gulmas.update', $masterGulma) }}" method="POST" enctype="multipart/form-data" style="margin-bottom:100px;">
        @csrf
        @method('PUT')
        @include('master-gulmas._form', ['gulma' => $masterGulma])
        
        <div style="position:fixed; bottom:80px; left:16px; right:16px; z-index:10; display:flex; gap:12px;">
            <button type="button" class="btn ghost" style="flex:1; border:1px solid #FF3B30; color:#FF3B30;" onclick="confirmDelete()">Hapus</button>
            <button type="submit" class="btn leaf" style="flex:2;">Simpan Perubahan</button>
        </div>
    </form>

    <form id="delete-form" action="{{ route('master-gulmas.destroy', $masterGulma) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Edit Master Gulma</div>
            <div class="d-section-sub">Ubah data referensi gulma</div>
        </div>
    </div>

    <div class="d-card">
        <div class="d-card-body">
            <form action="{{ route('master-gulmas.update', $masterGulma) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('master-gulmas._form', ['gulma' => $masterGulma])
                
                <div style="margin-top:24px; display:flex; justify-content:space-between; align-items:center;">
                    <button type="button" class="d-btn ghost" style="color:#FF3B30; border:1px solid #FF3B30;" onclick="confirmDelete()">Hapus Gulma</button>
                    <button type="submit" class="d-btn d-btn-green">Simpan Perubahan</button>
                </div>
            </form>
            
            <form id="delete-form-desk" action="{{ route('master-gulmas.destroy', $masterGulma) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
function confirmDelete() {
    if(confirm('Apakah Anda yakin ingin menghapus data master gulma ini?')) {
        document.getElementById('delete-form').submit();
        document.getElementById('delete-form-desk').submit();
    }
}
</script>
@endpush
