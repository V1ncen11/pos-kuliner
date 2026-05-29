@extends('layouts.order')
@section('title', 'Seblak Saiton — Pesan Sekarang')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .page-wrapper {
        min-height: 100vh;
        background: url('https://images.unsplash.com/photo-1623341214825-9f4f963727da?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat fixed;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .page-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(15,23,42,0.9) 0%, rgba(37,99,235,0.7) 100%);
        backdrop-filter: blur(4px);
        z-index: 1;
    }
    .page-content {
        position: relative;
        z-index: 10;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 1rem;
    }
    .hero-icon {
        font-size: 4rem;
        margin-bottom: 0.5rem;
        color: #93C5FD;
        filter: drop-shadow(0 0 15px rgba(147,197,253,0.4));
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }
    .input-group { position: relative; margin-bottom: 0.5rem; }
    .input-group i {
        position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
        color: #94A3B8; font-size: 1.2rem; transition: color 0.3s;
    }
    .input-group input {
        width: 100%; padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid #E2E8F0; border-radius: 12px;
        font-family: 'Inter', sans-serif; font-size: 0.95rem;
        transition: all 0.3s; background: #F8FAFC;
    }
    .input-group input:focus {
        outline: none; border-color: #2563EB; background: white;
        box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
    }
    .input-group input:focus + i { color: #2563EB; }
    .input-group input[readonly] { background: #F1F5F9; color: #64748B; cursor: not-allowed; border-color: #E2E8F0; }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-overlay"></div>
    
    <div class="page-content">
        {{-- PROGRESS STEPS --}}
        <div class="progress-steps" style="margin-bottom:2rem; width:100%; max-width:500px; background:rgba(255,255,255,0.95); padding:1rem; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">
            <div class="progress-step active">
                <span class="step-num">1</span> Identifikasi
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step" style="opacity:0.5;">
                <span class="step-num">2</span> Pilih Menu
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step" style="opacity:0.5;">
                <span class="step-num">3</span> Checkout
            </div>
        </div>

        <div style="text-align:center; color:white; margin-bottom:2rem;">
            <div class="hero-icon"><i class="bi bi-fire"></i></div>
            <h1 class="font-poppins" style="font-size:2.2rem;font-weight:800;margin-bottom:0.25rem;">Seblak Saiton</h1>
            <p style="color:#E2E8F0;font-size:1rem;">Pesan langsung dari meja kamu!</p>
        </div>

        <div class="card animate-slide-up" style="width:100%; max-width:500px; padding:2rem; box-shadow:0 20px 40px rgba(0,0,0,0.3);">
            <div class="section-title">Identifikasi Pemesan</div>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('order.menu') }}">
                @csrf
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label" style="font-weight:600;color:#0F172A;">Nama Pemesan</label>
                    <div class="input-group">
                        <input type="text" name="nama_pemesan" placeholder="Masukkan nama lengkap kamu..." value="{{ old('nama_pemesan') }}" required autofocus>
                        <i class="bi bi-person"></i>
                    </div>
                    <p style="font-size:0.75rem;color:#1E40AF;background:#DBEAFE;padding:0.6rem 0.75rem;border-radius:10px;margin-top:0.5rem;line-height:1.4;">
                        <i class="bi bi-info-circle-fill" style="margin-right:4px;"></i>
                        Gunakan <strong>nama lengkap asli</strong> kamu ya, supaya pesanan gampang dipanggil dan tidak tertukar.
                    </p>
                </div>

                <div style="margin-bottom:2rem;">
                    <label class="form-label" style="font-weight:600;color:#0F172A;">Nomor Meja</label>
                    <div class="input-group">
                        <input type="text" value="Meja {{ $nomor_meja }}" readonly>
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <input type="hidden" name="nomor_meja" value="{{ $nomor_meja }}">
                </div>

                <button type="submit" class="btn-primary" style="width:100%;border-radius:12px;padding:1rem;font-size:1rem;font-weight:600;display:flex;align-items:center;justify-content:center;gap:0.5rem;box-shadow:0 8px 20px rgba(37,99,235,0.25);">
                    Mulai Pesan <i class="bi bi-arrow-right-short" style="font-size:1.3rem;"></i>
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:2rem;position:relative;z-index:10;">
            <p style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Powered by Seblak Saiton © {{ date('Y') }}</p>
        </div>
    </div>
</div>
@endsection
