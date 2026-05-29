@extends('layouts.admin')
@section('title', 'QR Code Meja — Seblak Saiton')
@section('content')
<div class="admin-topbar no-print">
    <h1><i class="bi bi-qr-code"></i> QR Code Meja</h1>
    <button onclick="window.print()" class="btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak Semua</button>
</div>

<div class="no-print" style="margin-bottom: 2rem; background: #FFF3CD; color: #856404; padding: 1rem; border-radius: 8px; font-size: 0.9rem;">
    <i class="bi bi-info-circle"></i> <strong>Tips:</strong> Pastikan Anda membuka halaman ini lewat link Ngrok (bukan localhost) sebelum mencetak, agar QR Code yang dihasilkan berisi link Ngrok yang bisa diakses HP pelanggan. Klik tombol <strong>Cetak Semua</strong> (atau Ctrl+P) untuk mem-print.
</div>

<div class="qr-grid">
    @for($i = 1; $i <= 9; $i++)
    <div class="qr-card">
        <h2 style="font-family:'Poppins',sans-serif;font-weight:800;font-size:2rem;margin-bottom:0.5rem;">Meja {{ $i }}</h2>
        <div class="qr-image-wrapper">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url('/order?meja='.$i)) }}" alt="QR Code Meja {{ $i }}" style="width:100%;max-width:200px;border-radius:12px;">
        </div>
        <p style="margin-top:1rem;font-size:0.8rem;color:#666;">Scan untuk memesan</p>
        <div style="margin-top:0.5rem;font-weight:700;font-size:0.9rem;">Seblak Saiton</div>
    </div>
    @endfor
</div>

<style>
    .qr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    .qr-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 2px dashed #E0E0E0;
    }
    .qr-image-wrapper {
        background: #F8F9FA;
        padding: 1rem;
        border-radius: 16px;
        display: inline-block;
    }
    
    @media print {
        body { background: white; }
        .no-print, .admin-sidebar, .mobile-header { display: none !important; }
        .admin-main { margin: 0 !important; padding: 0 !important; }
        .qr-grid { 
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .qr-card {
            width: 45%;
            border: 2px dashed #CCC;
            box-shadow: none;
            page-break-inside: avoid;
            margin-bottom: 2rem;
        }
    }
</style>
@endsection
