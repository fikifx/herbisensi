@extends('layouts.app')

@section('title', 'Tambah Master Gulma')
@section('back', route('master-gulmas.index'))

@section('content_mobile')
    <form action="{{ route('master-gulmas.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom:100px;">
        @csrf
        @include('master-gulmas._form')
        
        <div style="position:fixed; bottom:80px; left:16px; right:16px; z-index:10;">
            <button type="submit" class="btn leaf" style="width:100%;">Simpan Gulma</button>
        </div>
    </form>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Tambah Master Gulma</div>
            <div class="d-section-sub">Buat data referensi gulma baru</div>
        </div>
    </div>

    <div class="d-card">
        <div class="d-card-body">
            <form action="{{ route('master-gulmas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('master-gulmas._form')
                
                <div style="margin-top:24px; display:flex; justify-content:flex-end;">
                    <button type="submit" class="d-btn d-btn-green">Simpan Gulma</button>
                </div>
            </form>
        </div>
    </div>
@endsection
