@extends('layouts.admin')
@section('title', 'Laporan Bulanan — Seblak Saiton')
@section('content')
<div class="admin-topbar no-print">
    <h1><i class="bi bi-graph-up"></i> Laporan Bulanan</h1>
    <button onclick="window.print()" class="btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak Laporan</button>
</div>

<div class="admin-card no-print" style="margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.laporan.index') }}" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;">
        <div style="flex:1;min-width:150px;">
            <label class="form-label">Bulan</label>
            <select name="bulan" class="form-input">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div style="flex:1;min-width:150px;">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-input">
                @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div>
            <button type="submit" class="btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        </div>
    </form>
</div>

<div class="stats-grid" style="margin-bottom: 2rem;">
    <div class="stat-card" style="background:var(--primary);color:white;border:none;">
        <div class="stat-label" style="color:rgba(255,255,255,0.8);">Total Pendapatan Bulan Ini</div>
        <div class="stat-value" style="font-size:1.5rem;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Pesanan Selesai</div>
        <div class="stat-value">{{ $totalPesanan }} Porsi</div>
    </div>
</div>

<div class="admin-card" style="margin-bottom: 2rem;">
    <h2 style="margin-bottom: 1rem;"><i class="bi bi-bar-chart-fill"></i> Grafik Pendapatan Harian</h2>
    <div style="position: relative; height:300px; width:100%;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="admin-card">
    <h2 style="margin-bottom: 1rem;"><i class="bi bi-table"></i> Rincian Per Tanggal</h2>
    @if($pendapatanHarian->isEmpty())
        <div style="text-align:center;padding:2rem;color:var(--admin-text-muted);">
            <p style="font-size:2rem;"><i class="bi bi-inbox" style="color:#CCC;"></i></p>
            <p>Belum ada pendapatan di bulan ini.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Pesanan</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendapatanHarian as $row)
                    <tr>
                        <td><strong>{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l, d F Y') }}</strong></td>
                        <td>{{ $row->jml_pesanan }} Pesanan</td>
                        <td style="color:var(--primary);font-weight:700;">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    @media print {
        body { background: white; }
        .no-print, .admin-sidebar, .mobile-header { display: none !important; }
        .admin-main { margin: 0 !important; padding: 0 !important; }
        .admin-card { box-shadow: none; border: 1px solid #ddd; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');
    const labels = {!! $labels !!};
    const data = {!! $data !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#E63946',
                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#E63946',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value === 0) return 'Rp 0';
                            return 'Rp ' + (value/1000) + 'K';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
