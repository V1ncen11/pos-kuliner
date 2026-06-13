@extends('layouts.admin')
@section('title', 'Pesanan — Resto Cafe')
@section('content')
<div class="admin-topbar">
    <h1><i class="bi bi-receipt"></i> Daftar Pesanan</h1>
</div>

{{-- FILTERS --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.pesanan.index') }}" style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
        <select name="status" class="form-select" style="width:auto;min-width:180px;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="belum_bayar" {{ request('status') === 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <input type="date" name="tanggal" class="form-input" style="width:auto;" value="{{ request('tanggal') }}" onchange="this.form.submit()">
        @if(request()->hasAny(['status', 'tanggal']))
            <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary btn-sm">Reset</a>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="admin-card" style="padding:0;">
    @if($pesananList->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--admin-text-muted);">
            <p style="font-size:3rem;"><i class="bi bi-inbox" style="color:#CCC;"></i></p>
            <p>Tidak ada pesanan ditemukan.</p>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananList as $pesanan)
                    <tr>
                        <td><strong>{{ $pesanan->kode_pesanan }}</strong></td>
                        <td>{{ $pesanan->nama_pemesan }}</td>
                        <td>
                            @if($pesanan->nomor_meja == 0)
                                <span class="badge" style="background:#4A5568;color:white;">POS / Take-Away</span>
                            @else
                                <span class="badge badge-blue">Meja {{ $pesanan->nomor_meja }}</span>
                            @endif
                        </td>
                        <td><span class="badge" style="background:#E2E8F0;color:#475569;">{{ $pesanan->detailPesanans->count() }} Item</span></td>
                        <td><strong>{{ $pesanan->total_harga_format }}</strong></td>
                        <td>
                            {{ strtoupper($pesanan->metode_bayar) }}<br>
                            <span class="badge {{ $pesanan->is_lunas ? 'badge-green' : 'badge-red' }}" style="font-size:0.7rem;margin-top:0.25rem;display:inline-block;">{{ $pesanan->is_lunas ? 'Lunas' : 'Belum Lunas' }}</span>
                        </td>
                        <td><span class="badge {{ $pesanan->status === 'selesai' ? 'badge-green' : ($pesanan->status === 'diproses' ? 'badge-blue' : ($pesanan->status === 'menunggu_verifikasi' ? 'badge-yellow' : 'badge-red')) }}">{{ $pesanan->status_label }}</span></td>
                        <td style="font-size:0.8rem;color:var(--admin-text-muted);">{{ $pesanan->created_at->format('d/m H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.pesanan.detail', $pesanan->id) }}" class="btn-primary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:1rem;">
            {{ $pesananList->withQueryString()->links() }}
            <div class="pagination-info">
                Menampilkan {{ $pesananList->firstItem() }} sampai {{ $pesananList->lastItem() }} dari {{ $pesananList->total() }} pesanan
            </div>
        </div>
    @endif
</div>
@endsection
