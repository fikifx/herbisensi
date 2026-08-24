@extends('layouts.app')

@section('title', 'Tambah Master Dosis')
@section('back', route('master-doses.index'))

@section('content_mobile')
    <form action="{{ route('master-doses.store') }}" method="POST" style="margin-bottom:100px;">
        @csrf
        @include('master-doses._form')
        
        <div style="position:fixed; bottom:80px; left:16px; right:16px; z-index:10;">
            <button type="submit" class="btn leaf" style="width:100%;">Simpan Dosis</button>
        </div>
    </form>
@endsection

@section('content_desktop')
    <div class="d-section-heading">
        <div>
            <div class="d-section-title">Tambah Master Dosis</div>
            <div class="d-section-sub">Buat data referensi dosis baru</div>
        </div>
    </div>

    <div class="d-card">
        <div class="d-card-body">
            <form action="{{ route('master-doses.store') }}" method="POST">
                @csrf
                @include('master-doses._form')
                
                <div style="margin-top:24px; display:flex; justify-content:flex-end;">
                    <button type="submit" class="d-btn d-btn-green">Simpan Dosis</button>
                </div>
            </form>
        </div>
    </div>
@endsection
