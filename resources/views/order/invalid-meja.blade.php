@extends('layouts.order')
@section('title', 'Seblak Saiton — Meja Tidak Valid')
@section('content')
<div class="container-order" style="display:flex;align-items:center;justify-content:center;min-height:100vh;text-align:center;">
    <div class="card animate-slide-up" style="max-width:360px;width:100%;">
        <div style="font-size:4rem;margin-bottom:1rem;color:#E63946;"><i class="bi bi-x-circle"></i></div>
        <h2 class="font-poppins" style="margin-bottom:0.5rem;">Akses Ditolak</h2>
        <p style="color:var(--text-muted);margin-bottom:1.5rem;">{{ $message ?? 'Nomor meja tidak valid. Silakan scan ulang QR code di meja kamu ya!' }}</p>
        <a href="/" class="btn-primary" style="text-decoration:none;">Kembali ke Beranda</a>
    </div>
</div>
@endsection
