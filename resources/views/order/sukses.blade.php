@extends('layouts.order')
@section('title', 'Pesanan Berhasil — Seblak Saiton')
@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;">
    <div class="container-order" style="width:100%;">
        <div class="card animate-slide-up" style="text-align:center;">
            <div class="success-icon">✓</div>
            <h2 class="font-poppins" style="font-size:1.5rem;margin-bottom:0.25rem;">Pesanan Berhasil!</h2>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;">Terima kasih, {{ $pesanan->nama_pemesan }}!</p>

            {{-- KODE PESANAN --}}
            <div style="background:linear-gradient(135deg,#0F172A,#1E293B);color:white;padding:1rem;border-radius:16px;margin-bottom:1.5rem;">
                <p style="font-size:0.8rem;opacity:0.8;">Kode Pesanan</p>
                <p class="font-poppins" style="font-size:1.5rem;font-weight:800;">{{ $pesanan->kode_pesanan }}</p>
            </div>

            {{-- DETAIL --}}
            <div style="text-align:left;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                    <div style="background:#F8FAFF;padding:0.75rem;border-radius:12px;">
                        <p style="font-size:0.75rem;color:var(--text-muted);">Meja</p>
                        <p class="font-poppins" style="font-weight:700;">{{ $pesanan->nomor_meja }}</p>
                    </div>
                    <div style="background:#F8FAFF;padding:0.75rem;border-radius:12px;">
                        <p style="font-size:0.75rem;color:var(--text-muted);">Status</p>
                        <p class="font-poppins" style="font-weight:700;">{{ $pesanan->status_label }}</p>
                    </div>
                </div>

                {{-- ITEMS PER PORSI --}}
                <div class="section-title" style="font-size:0.95rem;">Detail Pesanan</div>
                @foreach($pesanan->porsiPesanans as $porsi)
                    <div style="background:#F8FAFF;padding:0.75rem;border-radius:12px;margin-bottom:0.75rem;border:1px solid #E2E8F0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <strong style="color:var(--primary);">{{ $porsi->nama_porsi }}</strong>
                            <span style="font-size:0.75rem;color:var(--text-muted);">{{ $porsi->level_pedas_label }} • {{ $porsi->jenis_rasa_label }}</span>
                        </div>
                        @if($porsi->catatan)
                            <div style="font-size:0.75rem;color:var(--text-muted);font-style:italic;margin-bottom:0.5rem;">Catatan: {{ $porsi->catatan }}</div>
                        @endif
                        
                        @foreach($porsi->detailPesanans as $detail)
                        <div style="display:flex;justify-content:space-between;padding:0.25rem 0;font-size:0.85rem;border-bottom:1px dashed #E2E8F0;">
                            <span>- {{ $detail->menu->nama_menu }} x{{ $detail->jumlah }}</span>
                            <span style="font-weight:600;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                @endforeach

                <div style="display:flex;justify-content:space-between;padding:1rem 0;font-family:'Poppins',sans-serif;">
                    <span style="font-weight:700;font-size:1.1rem;">Total</span>
                    <span style="font-weight:800;font-size:1.25rem;color:var(--primary);">{{ $pesanan->total_harga_format }}</span>
                </div>

                {{-- INSTRUKSI --}}
                @if($pesanan->metode_bayar === 'cash')
                <div style="background:#FEF3C7;padding:1rem;border-radius:16px;text-align:center;">
                    <p style="font-size:1.5rem;"><i class="bi bi-cash"></i></p>
                    <p style="font-weight:600;">Silakan bayar di kasir ya!</p>
                    <p style="font-size:0.85rem;color:var(--text-muted);">Sebut kode pesanan kamu saat membayar.</p>
                </div>
                @else
                <div style="background:#D1FAE5;padding:1rem;border-radius:16px;text-align:center;">
                    <p style="font-size:1.5rem;"><i class="bi bi-phone"></i></p>
                    <p style="font-weight:600;">Bukti pembayaran sudah dikirim!</p>
                    <p style="font-size:0.85rem;color:var(--text-muted);">Admin akan memverifikasi pembayaran kamu.</p>
                </div>
                @endif
            </div>
        </div>

        <div style="text-align:center;margin-top:1.5rem;display:flex;gap:0.75rem;justify-content:center;">
            <a href="{{ route('order.index', ['meja' => $pesanan->nomor_meja]) }}" class="btn-secondary" style="flex:1;">Pesan Lagi</a>
            <a href="/" class="btn-primary" style="flex:1;background:#EF4444;border:none;">Selesai & Keluar</a>
        </div>
    </div>
</div>

<script>
    // Bersihkan keranjang dari localStorage setelah pesanan berhasil
    const cartKey = 'seblak_cart_meja_{{ $pesanan->nomor_meja }}_{{ Str::slug($pesanan->nama_pemesan) }}';
    localStorage.removeItem(cartKey);
</script>
@endsection
