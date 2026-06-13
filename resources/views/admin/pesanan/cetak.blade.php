<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $pesanan->kode_pesanan }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #f5f5f5;
        }

        .receipt {
            width: 280px;
            margin: 20px auto;
            background: white;
            padding: 16px 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: 700; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .fs-lg { font-size: 16px; }
        .fs-md { font-size: 14px; }
        .fs-sm { font-size: 10px; }
        .muted { color: #888; }

        .divider {
            border: none;
            border-top: 1px dashed #999;
            margin: 8px 0;
        }

        .divider-double {
            border: none;
            border-top: 2px double #333;
            margin: 8px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .row .left { flex: 1; }
        .row .right { text-align: right; white-space: nowrap; margin-left: 8px; }

        .item-row {
            margin-bottom: 4px;
        }

        .item-qty {
            color: #666;
        }

        .total-row {
            font-size: 16px;
            font-weight: 700;
            padding: 6px 0;
        }

        /* Print styles */
        @media print {
            body { background: none; }
            .receipt {
                width: 100%;
                max-width: 80mm;
                margin: 0;
                box-shadow: none;
                padding: 4px 2px;
            }
            .no-print { display: none !important; }
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }

        .btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 16px auto;
            max-width: 280px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-print {
            background: #E63946;
            color: white;
        }
        .btn-print:hover { background: #C62828; }

        .btn-back {
            background: #f0f0f0;
            color: #333;
        }
        .btn-back:hover { background: #e0e0e0; }
    </style>
</head>
<body>

{{-- BUTTONS --}}
<div class="btn-group no-print">
    <button class="btn btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Struk</button>
    <button class="btn btn-back" onclick="window.close(); window.history.back();">← Kembali</button>
</div>

{{-- RECEIPT --}}
<div class="receipt">
    {{-- HEADER --}}
    <div class="text-center mb-2">
        <div class="fs-lg bold">RESTO CAFE</div>
        <div class="fs-sm muted mt-1">Self-Order System</div>
        <div class="fs-sm muted">Pusat Kota</div>
    </div>

    <hr class="divider-double">

    {{-- INFO PESANAN --}}
    <div class="mb-1">
        <div class="row">
            <span>No. Pesanan</span>
            <span class="bold">{{ $pesanan->kode_pesanan }}</span>
        </div>
        <div class="row">
            <span>Tanggal</span>
            <span>{{ $pesanan->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="row">
            <span>Waktu</span>
            <span>{{ $pesanan->created_at->format('H:i') }}</span>
        </div>
        <div class="row">
            <span>Meja</span>
            <span class="bold">{{ $pesanan->nomor_meja }}</span>
        </div>
        <div class="row">
            <span>Pemesan</span>
            <span>{{ $pesanan->nama_pemesan }}</span>
        </div>
    </div>

    <hr class="divider">

    {{-- ITEMS --}}
    <div class="mb-1">
        @foreach($pesanan->detailPesanans as $detail)
        <div class="item-row">
            <div class="bold">{{ $detail->menu->nama_menu }}</div>
            <div class="row item-qty">
                <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                <span class="right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($detail->catatan)
                <div class="fs-sm muted mt-1">Catatan: {{ $detail->catatan }}</div>
            @endif
        </div>
        @endforeach
    </div>

    <hr class="divider-double">

    {{-- TOTAL --}}
    <div class="row total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
    </div>

    <hr class="divider">

    {{-- PAYMENT --}}
    <div class="mb-1">
        <div class="row">
            <span>Metode</span>
            <span class="bold">{{ strtoupper($pesanan->metode_bayar) }}</span>
        </div>
        <div class="row">
            <span>Status</span>
            <span class="bold">{{ $pesanan->status_label }}</span>
        </div>
    </div>

    <hr class="divider">

    {{-- FOOTER --}}
    <div class="text-center mt-2">
        <div class="fs-sm">Terima kasih sudah memesan!</div>
        <div class="fs-sm muted mt-1">Resto Cafe &mdash; Best Food in Town!</div>
        <div class="fs-sm muted mt-1">{{ $pesanan->created_at->format('d/m/Y H:i:s') }}</div>
    </div>
</div>

<script>
    // Auto print on load if requested via URL param
    const params = new URLSearchParams(window.location.search);
    if (params.get('auto') === '1') {
        window.addEventListener('load', () => window.print());
    }
</script>
</body>
</html>
