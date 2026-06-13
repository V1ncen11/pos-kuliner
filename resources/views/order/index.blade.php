@extends('layouts.order')
@section('title', 'Resto Cafe — Pesan Sekarang')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .page-wrapper {
        min-height: 100vh;
        background: var(--bg-dark);
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .page-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -30%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(34,197,94,0.12) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }
    .page-wrapper::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(251,191,36,0.08) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
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
        font-size: 3.5rem;
        margin-bottom: 0.5rem;
        display: inline-block;
        animation: float 3s ease-in-out infinite;
        filter: drop-shadow(0 0 20px rgba(34,197,94,0.4));
    }
    .input-group { position: relative; margin-bottom: 0.5rem; }
    .input-group i {
        position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
        color: var(--text-muted); font-size: 1.1rem; transition: color 0.3s;
    }
    .input-group input {
        width: 100%; padding: 0.875rem 1rem 0.875rem 3rem;
        border: 1.5px solid var(--border-color); border-radius: var(--radius-md);
        font-family: 'Inter', sans-serif; font-size: 0.95rem;
        transition: var(--transition); background: var(--bg-input);
        color: var(--text-primary);
    }
    .input-group input:focus {
        outline: none; border-color: var(--primary); background: var(--bg-input);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }
    .input-group input:focus ~ i { color: var(--primary); }
    .input-group input[readonly] { background: var(--bg-elevated); color: var(--text-muted); cursor: not-allowed; border-color: var(--border-color); }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        {{-- PROGRESS STEPS --}}
        <div class="progress-steps" style="margin-bottom:2rem; width:100%; max-width:500px; background:var(--bg-card); padding:1rem; border-radius:var(--radius-md); border:1px solid var(--border-color);">
            <div class="progress-step active">
                <span class="step-num">1</span> Identifikasi
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step" style="opacity:0.4;">
                <span class="step-num">2</span> Pilih Menu
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step" style="opacity:0.4;">
                <span class="step-num">3</span> Checkout
            </div>
        </div>

        <div style="text-align:center; color:var(--text-primary); margin-bottom:2rem;">
            <div class="hero-icon"><i class="bi bi-flower2" style="color:var(--primary);"></i></div>
            <h1 class="font-poppins" style="font-size:2rem;font-weight:800;margin-bottom:0.25rem;background:linear-gradient(135deg, var(--primary), var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Resto Cafe</h1>
            <p style="color:var(--text-secondary);font-size:0.95rem;">Pesan langsung dari meja kamu!</p>
        </div>

        <div class="card animate-slide-up" style="width:100%; max-width:500px; padding:1.75rem;">
            <div class="section-title" style="font-size:1rem;">Identifikasi Pemesan</div>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="GET" action="{{ route('order.menu') }}">
                <div style="margin-bottom:1.5rem;">
                    <label class="form-label">Nama Pemesan</label>
                    <div class="input-group">
                        <input type="text" name="nama_pemesan" placeholder="Masukkan nama lengkap kamu..." value="{{ old('nama_pemesan') }}" required autofocus>
                        <i class="bi bi-person"></i>
                    </div>
                    <p style="font-size:0.72rem;color:var(--primary-light);background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.12);padding:0.55rem 0.75rem;border-radius:var(--radius-sm);margin-top:0.5rem;line-height:1.4;">
                        <i class="bi bi-info-circle-fill" style="margin-right:4px;"></i>
                        Gunakan <strong>nama lengkap asli</strong> kamu ya, supaya pesanan gampang dipanggil.
                    </p>
                </div>

                <div style="margin-bottom:2rem;">
                    <label class="form-label">Nomor Meja</label>
                    <div class="input-group">
                        <input type="text" value="Meja {{ $nomor_meja }}" readonly>
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <input type="hidden" name="nomor_meja" value="{{ $nomor_meja }}">
                </div>

                <button type="submit" class="btn-primary" style="width:100%;padding:1rem;font-size:1rem;font-weight:600;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                    Mulai Pesan <i class="bi bi-arrow-right-short" style="font-size:1.3rem;"></i>
                </button>
            </form>
        </div>

        <div style="text-align:center;margin-top:2rem;position:relative;z-index:10;">
            <p style="color:var(--text-muted);font-size:0.78rem;">Powered by Resto Cafe © {{ date('Y') }}</p>
        </div>
    </div>
</div>
@endsection
