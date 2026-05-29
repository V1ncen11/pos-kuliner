@extends('layouts.admin')
@section('title', 'Dashboard — Seblak Saiton')
@section('content')
<div class="admin-topbar">
    <h1><i class="bi bi-grid-1x2-fill"></i> Dashboard</h1>
    <p style="color:var(--admin-text-muted);font-size:0.875rem;">{{ now()->translatedFormat('l, d F Y') }}</p>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Pesanan Hari Ini</div>
        <div class="stat-value">{{ $stats['total_pesanan_hari_ini'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Menunggu / Belum Bayar</div>
        <div class="stat-value">{{ $stats['pesanan_menunggu'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Sedang Diproses</div>
        <div class="stat-value">{{ $stats['pesanan_diproses'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Selesai Hari Ini</div>
        <div class="stat-value">{{ $stats['pesanan_selesai_hari_ini'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pendapatan Hari Ini</div>
        <div class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</div>
    </div>
    <div class="stat-card" style="background:var(--primary);color:white;border:none;">
        <div class="stat-label" style="color:rgba(255,255,255,0.8);">Pendapatan Bulan Ini</div>
        <div class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</div>
    </div>
</div>

{{-- PESANAN TERBARU --}}
<div class="admin-card">
    <div class="admin-card-header">
        <h2><i class="bi bi-receipt"></i> Pesanan Terbaru</h2>
        <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary btn-sm">Lihat Semua</a>
    </div>

    @if($pesananTerbaru->isEmpty())
        <div style="text-align:center;padding:2rem;color:var(--admin-text-muted);">
            <p style="font-size:2rem;"><i class="bi bi-inbox" style="color:#CCC;"></i></p>
            <p>Belum ada pesanan hari ini.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Meja</th>
                        <th>Mangkuk</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananTerbaru as $pesanan)
                    <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.pesanan.detail', $pesanan->id) }}'">
                        <td><strong>{{ $pesanan->kode_pesanan }}</strong></td>
                        <td>{{ $pesanan->nama_pemesan }}</td>
                        <td><span class="badge badge-blue">{{ $pesanan->nomor_meja }}</span></td>
                        <td>
                            <span class="badge" style="background:#E2E8F0;color:#475569;">{{ $pesanan->porsiPesanans->count() }} Porsi</span>
                        </td>
                        <td><strong>{{ $pesanan->total_harga_format }}</strong></td>
                        <td>{{ strtoupper($pesanan->metode_bayar) }}</td>
                        <td><span class="badge {{ $pesanan->status === 'selesai' ? 'badge-green' : ($pesanan->status === 'diproses' ? 'badge-blue' : ($pesanan->status === 'menunggu_verifikasi' ? 'badge-yellow' : 'badge-red')) }}">{{ $pesanan->status_label }}</span></td>
                        <td style="font-size:0.8rem;color:var(--admin-text-muted);">{{ $pesanan->created_at->format('H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
