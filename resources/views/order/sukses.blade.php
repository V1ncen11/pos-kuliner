@extends('layouts.order')
@section('title', 'Pesanan Berhasil — Resto Cafe')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;position:relative;overflow:hidden;">
    {{-- Ambient glow --}}
    <div style="position:absolute;top:-100px;left:-50px;width:300px;height:300px;background:radial-gradient(circle, rgba(34,197,94,0.1) 0%, transparent 70%);border-radius:50%;pointer-events:none;"></div>
    <div style="position:absolute;bottom:-80px;right:-30px;width:250px;height:250px;background:radial-gradient(circle, rgba(34,197,94,0.08) 0%, transparent 70%);border-radius:50%;pointer-events:none;"></div>

    <div class="container-order" style="width:100%;position:relative;z-index:1;">
        <div class="card animate-slide-up" style="text-align:center;">
            <div class="success-icon">✓</div>
            <h2 class="font-poppins" style="font-size:1.35rem;margin-bottom:0.25rem;color:var(--text-primary);">Pesanan Berhasil! 🎉</h2>
            <p style="color:var(--text-secondary);margin-bottom:1.5rem;font-size:0.9rem;">Terima kasih, {{ $pesanan->nama_pemesan }}!</p>

            {{-- KODE PESANAN --}}
            <div style="background:linear-gradient(135deg, var(--primary), var(--primary-dark));color:white;padding:1rem;border-radius:var(--radius-md);margin-bottom:1.5rem;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-20px;right:-20px;width:80px;height:80px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
                <p style="font-size:0.75rem;opacity:0.85;font-weight:600;letter-spacing:0.5px;">KODE PESANAN</p>
                <p class="font-poppins" style="font-size:1.5rem;font-weight:800;">{{ $pesanan->kode_pesanan }}</p>
            </div>

            {{-- DETAIL --}}
            <div style="text-align:left;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                    <div style="background:var(--bg-elevated);padding:0.75rem;border-radius:var(--radius-sm);border:1px solid var(--border-color);">
                        <p style="font-size:0.7rem;color:var(--text-muted);">Meja</p>
                        <p class="font-poppins" style="font-weight:700;font-size:0.95rem;color:var(--text-primary);">{{ $pesanan->nomor_meja }}</p>
                    </div>
                    <div style="background:var(--bg-elevated);padding:0.75rem;border-radius:var(--radius-sm);border:1px solid var(--border-color);">
                        <p style="font-size:0.7rem;color:var(--text-muted);">Status</p>
                        <p class="font-poppins" style="font-weight:700;font-size:0.95rem;color:var(--text-primary);">{{ $pesanan->status_label }}</p>
                    </div>
                </div>

                {{-- ITEMS --}}
                <div class="section-title" style="font-size:0.9rem;">Detail Pesanan</div>
                <div style="background:var(--bg-elevated);padding:0.75rem;border-radius:var(--radius-sm);margin-bottom:0.75rem;border:1px solid var(--border-color);">
                    @foreach($pesanan->detailPesanans as $detail)
                    <div style="padding:0.5rem 0;border-bottom:1px dashed var(--border-color);">
                        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.2rem;">
                            <span style="font-weight:600;color:var(--text-primary);">{{ $detail->menu->nama_menu }} x{{ $detail->jumlah }}</span>
                            <span style="font-weight:600;color:var(--primary);">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($detail->catatan)
                            <div style="font-size:0.72rem;color:var(--text-muted);font-style:italic;">Catatan: {{ $detail->catatan }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div style="display:flex;justify-content:space-between;padding:0.75rem 0;font-family:'Poppins',sans-serif;">
                    <span style="font-weight:700;font-size:1rem;color:var(--text-primary);">Total</span>
                    <span style="font-weight:800;font-size:1.15rem;color:var(--primary);">{{ $pesanan->total_harga_format }}</span>
                </div>

                {{-- INSTRUKSI --}}
                @if($pesanan->metode_bayar === 'cash')
                <div style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.15);padding:1rem;border-radius:var(--radius-md);text-align:center;">
                    <p style="font-size:1.35rem;"><i class="bi bi-cash" style="color:#FBBF24;"></i></p>
                    <p style="font-weight:600;color:#FBBF24;font-size:0.9rem;">Segera bayar ke kasir agar pesanan langsung diproses!</p>
                    <p style="font-size:0.8rem;color:var(--text-secondary);margin-top:0.2rem;">Sebutkan kode pesanan kamu saat membayar.</p>
                </div>
                @else
                <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.15);padding:1rem;border-radius:var(--radius-md);text-align:center;">
                    <p style="font-size:1.35rem;"><i class="bi bi-phone" style="color:#22C55E;"></i></p>
                    <p style="font-weight:600;color:#86EFAC;font-size:0.9rem;">Bukti pembayaran sudah dikirim!</p>
                    <p style="font-size:0.8rem;color:var(--text-secondary);margin-top:0.2rem;">Admin akan memverifikasi pembayaran kamu.</p>
                </div>
                @endif
            </div>
        </div>

        <div style="text-align:center;margin-top:1.5rem;display:flex;gap:0.75rem;justify-content:center;">
            <a href="{{ route('order.index', ['meja' => $pesanan->nomor_meja]) }}" class="btn-secondary" style="flex:1;font-size:0.9rem;">Pesan Lagi</a>
            <a href="/" class="btn-primary" style="flex:1;font-size:0.9rem;background:linear-gradient(135deg, #EF4444, #DC2626);box-shadow:0 4px 15px rgba(239,68,68,0.3);">Selesai</a>
        </div>
    </div>
</div>

<script>
    // Bersihkan keranjang dari localStorage setelah pesanan berhasil
    const cartKey = 'resto_cart_meja_{{ $pesanan->nomor_meja }}_{{ Str::slug($pesanan->nama_pemesan) }}';
    localStorage.removeItem(cartKey);
</script>
@endsection
