@extends('layouts.app')

@section('title', 'Akun Saya')

@section('content_mobile')
<div style="display:flex; flex-direction:column; align-items:center; margin-top:20px; margin-bottom:30px;">
    <div class="avatar" style="width:80px; height:80px; font-size:28px; margin-bottom:12px;">AN</div>
    <h2 style="margin:0; font-family:'Space Grotesk',sans-serif; font-size:20px; color:var(--forest);">Andi Setiawan</h2>
    <div style="font-size:13px; color:var(--ink-soft); margin-top:4px;">Supervisor Agronomi • Divisi 1</div>
</div>

<div class="section-title">Informasi Pekerjaan</div>
<div class="card" style="padding:0; overflow:hidden;">
    <div class="row" style="padding:16px; border-bottom:1px solid var(--line); margin:0;">
        <div class="lbl">ID Karyawan</div>
        <div class="val">EMP-2023-0891</div>
    </div>
    <div class="row" style="padding:16px; border-bottom:1px solid var(--line); margin:0;">
        <div class="lbl">Afdeling Pegangan</div>
        <div class="val">OF, OB, OH, OD</div>
    </div>
    <div class="row" style="padding:16px; margin:0;">
        <div class="lbl">Bergabung Sejak</div>
        <div class="val">12 Jan 2021</div>
    </div>
</div>

<div class="section-title">Pengaturan Aplikasi</div>
<div class="card" style="padding:0; overflow:hidden;">
    <a href="#" class="row" style="padding:16px; border-bottom:1px solid var(--line); margin:0; text-decoration:none; color:inherit; display:flex;">
        <div class="val" style="font-weight:600;">Notifikasi</div>
        <div style="color:var(--ink-soft); font-size:16px;">›</div>
    </a>
    <a href="#" class="row" style="padding:16px; margin:0; text-decoration:none; color:inherit; display:flex;">
        <div class="val" style="font-weight:600;">Panduan Penggunaan</div>
        <div style="color:var(--ink-soft); font-size:16px;">›</div>
    </a>
</div>

<button class="btn ghost" style="color:var(--red); border-color:var(--red); margin-top:30px;">Keluar Aplikasi</button>
@endsection

@section('content_desktop')
<div class="d-page-2col">
    <div>
        <div class="d-card" style="text-align:center; padding:40px 20px;">
            <div class="avatar" style="width:100px; height:100px; font-size:36px; margin:0 auto 16px; background:linear-gradient(135deg,var(--leaf),var(--forest-2));">AN</div>
            <h2 style="margin:0; font-family:'Space Grotesk',sans-serif; font-size:24px; color:var(--forest);">Andi Setiawan</h2>
            <div class="d-badge done" style="margin-top:10px; font-size:13px; padding:6px 16px;">Supervisor Agronomi</div>
            <p style="font-size:14px; color:var(--ink-soft); margin-top:16px;">Menangani area Divisi 1 yang meliputi Afdeling OF, OB, OH, dan OD.</p>
            
            <button class="d-btn d-btn-ghost d-btn-full" style="color:var(--red); border-color:var(--red); margin-top:30px;">Log Out</button>
        </div>
    </div>
    
    <div>
        <div class="d-card">
            <div class="d-card-header"><div class="d-card-title">Informasi Detail</div></div>
            <div class="d-card-body-0">
                <div class="d-table-row">
                    <div class="d-table-lbl">ID Karyawan</div>
                    <div class="d-table-val">EMP-2023-0891</div>
                </div>
                <div class="d-table-row">
                    <div class="d-table-lbl">Email</div>
                    <div class="d-table-val">andi.s@company.com</div>
                </div>
                <div class="d-table-row">
                    <div class="d-table-lbl">No. HP</div>
                    <div class="d-table-val">+62 812-3456-7890</div>
                </div>
                <div class="d-table-row">
                    <div class="d-table-lbl">Bergabung Sejak</div>
                    <div class="d-table-val">12 Januari 2021</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
