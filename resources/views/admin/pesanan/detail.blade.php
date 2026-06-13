@extends('layouts.admin')
@section('title', 'Detail Pesanan — Resto Cafe')
@section('content')
<div class="admin-topbar">
    <h1><i class="bi bi-receipt"></i> Detail Pesanan #{{ $pesanan->kode_pesanan }}</h1>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('admin.pesanan.cetak', $pesanan->id) }}" target="_blank" class="btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak Struk</a>
        <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary btn-sm">← Kembali</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    {{-- LEFT: INFO --}}
    <div>
        <div class="admin-card">
            <h3 class="font-poppins" style="margin-bottom:1rem;font-weight:700;">Informasi Pesanan</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Kode Pesanan</div>
                    <div class="detail-value">{{ $pesanan->kode_pesanan }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nama Pemesan</div>
                    <div class="detail-value">{{ $pesanan->nama_pemesan }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nomor Meja</div>
                    <div class="detail-value">Meja {{ $pesanan->nomor_meja }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Waktu Pesan</div>
                    <div class="detail-value">{{ $pesanan->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Metode Bayar</div>
                    <div class="detail-value">{{ strtoupper($pesanan->metode_bayar) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Total Harga</div>
                    <div class="detail-value" style="color:var(--admin-primary);">{{ $pesanan->total_harga_format }}</div>
                </div>
            </div>

        </div>

        {{-- BUKTI BAYAR --}}
        @if($pesanan->bukti_bayar_path)
        <div class="admin-card">
            <h3 class="font-poppins" style="margin-bottom:1rem;font-weight:700;"><i class="bi bi-image"></i> Bukti Pembayaran</h3>
            <div style="background:#F8F9FA;padding:1rem;border-radius:12px;text-align:center;">
                <img src="{{ asset('storage/' . $pesanan->bukti_bayar_path) }}" alt="Bukti Bayar" style="max-width:100%;border-radius:8px;cursor:pointer;" onclick="window.open(this.src, '_blank')">
                <p style="font-size:0.8rem;color:var(--admin-text-muted);margin-top:0.5rem;">Klik gambar untuk memperbesar</p>
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT: ITEMS + STATUS --}}
    <div>
        {{-- UPDATE STATUS --}}
        <div class="admin-card">
            <h3 class="font-poppins" style="margin-bottom:1rem;font-weight:700;"><i class="bi bi-arrow-repeat"></i> Status Pesanan</h3>
            <p style="margin-bottom:1rem;">
                Status Order: <span class="badge {{ $pesanan->status === 'selesai' ? 'badge-green' : ($pesanan->status === 'diproses' ? 'badge-blue' : ($pesanan->status === 'menunggu_verifikasi' ? 'badge-yellow' : 'badge-red')) }}" style="font-size:0.85rem;margin-right:0.5rem;">{{ $pesanan->status_label }}</span>
                Status Pembayaran: <span class="badge {{ $pesanan->is_lunas ? 'badge-green' : 'badge-red' }}" style="font-size:0.85rem;">{{ $pesanan->is_lunas ? '✅ Lunas' : '❌ Belum Lunas' }}</span>
            </p>

            <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                @csrf
                @method('PATCH')
                
                @if(!$pesanan->is_lunas && $pesanan->status !== 'dibatalkan')
                <button type="submit" name="status" value="lunas" class="btn-success btn-sm"><i class="bi bi-cash"></i> Tandai Lunas</button>
                @endif

                @if($pesanan->status !== 'diproses' && $pesanan->status !== 'selesai' && $pesanan->status !== 'dibatalkan')
                <button type="submit" name="status" value="diproses" class="btn-warning btn-sm"><i class="bi bi-fire"></i> Proses Pesanan</button>
                @endif
                
                @if($pesanan->status !== 'selesai' && $pesanan->status !== 'dibatalkan')
                <button type="submit" name="status" value="selesai" class="btn-primary btn-sm"><i class="bi bi-check-circle"></i> Selesai & Kosongkan Meja</button>
                @endif
                
                @if($pesanan->status === 'menunggu_verifikasi')
                <button type="submit" name="status" value="belum_bayar" class="btn-danger btn-sm"><i class="bi bi-x-circle"></i> Tolak Bukti QRIS</button>
                @endif
                
                @if($pesanan->status !== 'selesai' && $pesanan->status !== 'dibatalkan')
                <button type="submit" name="status" value="dibatalkan" class="btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"><i class="bi bi-trash"></i> Batalkan Pesanan</button>
                @endif
            </form>
        </div>

        {{-- ITEMS --}}
        <div class="admin-card">
            <h3 class="font-poppins" style="margin-bottom:1rem;font-weight:700;"><i class="bi bi-cart3"></i> Item Pesanan</h3>
            @foreach($pesanan->detailPesanans as $detail)
                <div style="background:#F8FAFF;padding:0.75rem;border-radius:12px;margin-bottom:0.75rem;border:1px solid #E2E8F0;">
                    <div style="display:flex;justify-content:space-between;padding:0.25rem 0;font-size:0.9rem;">
                        <span><strong style="color:var(--admin-primary);">{{ $detail->menu->nama_menu }}</strong> x{{ $detail->jumlah }}</span>
                        <span style="font-weight:700;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($detail->catatan)
                        <div style="font-size:0.75rem;color:var(--admin-text-muted);font-style:italic;margin-top:0.25rem;">
                            <i class="bi bi-pencil-square"></i> {{ $detail->catatan }}
                        </div>
                    @endif
                </div>
            @endforeach
            <div style="display:flex;justify-content:space-between;padding:1rem 0;font-family:'Poppins',sans-serif;border-top:2px solid #E0E0E0;margin-top:0.5rem;">
                <span style="font-weight:700;font-size:1.1rem;">Total</span>
                <span style="font-weight:800;font-size:1.25rem;color:var(--admin-primary);">{{ $pesanan->total_harga_format }}</span>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .admin-topbar { flex-direction: column; align-items: flex-start; }
    div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
@endsection
