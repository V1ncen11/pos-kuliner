<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard overview — statistik hari ini.
     */
    public function index()
    {
        $today = now()->toDateString();

        $stats = [
            'total_pesanan_hari_ini' => Pesanan::whereDate('created_at', $today)->count(),
            'pesanan_menunggu' => Pesanan::whereIn('status', ['menunggu_verifikasi', 'belum_bayar'])->count(),
            'pesanan_diproses' => Pesanan::where('status', 'diproses')->count(),
            'pesanan_selesai_hari_ini' => Pesanan::where('status', 'selesai')->whereDate('created_at', $today)->count(),
            'pendapatan_hari_ini' => Pesanan::where('status', 'selesai')->whereDate('created_at', $today)->sum('total_harga'),
            'pendapatan_bulan_ini' => Pesanan::where('status', 'selesai')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_harga'),
            'total_menu' => Menu::count(),
        ];

        $pesananTerbaru = Pesanan::with('porsiPesanans.detailPesanans.menu')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesananTerbaru'));
    }

    /**
     * List semua pesanan — filter by status.
     */
    public function pesanan(Request $request)
    {
        $query = Pesanan::with('porsiPesanans.detailPesanans.menu')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $pesananList = $query->paginate(20);

        return view('admin.pesanan.index', compact('pesananList'));
    }

    /**
     * Detail pesanan — lihat item + bukti bayar.
     */
    public function detailPesanan(int $id)
    {
        $pesanan = Pesanan::with('porsiPesanans.detailPesanans.menu')->findOrFail($id);

        return view('admin.pesanan.detail', compact('pesanan'));
    }

    /**
     * Update status pesanan.
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu_verifikasi,belum_bayar,diproses,selesai,dibatalkan,lunas',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        if ($request->status === 'lunas') {
            $pesanan->update(['is_lunas' => true]);
            return back()->with('success', "Pesanan #{$pesanan->kode_pesanan} berhasil ditandai Lunas.");
        }

        $pesanan->update(['status' => $request->status]);

        return back()->with('success', "Status pesanan #{$pesanan->kode_pesanan} berhasil diubah.");
    }

    /**
     * Cetak struk pesanan — format thermal printer.
     */
    public function cetakStruk(int $id)
    {
        $pesanan = Pesanan::with('porsiPesanans.detailPesanans.menu')->findOrFail($id);

        return view('admin.pesanan.cetak', compact('pesanan'));
    }

    /**
     * Halaman Rekap Bulanan dan Grafik.
     */
    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Get total income for the selected month
        $totalPendapatan = Pesanan::where('is_lunas', true)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum('total_harga');

        $totalPesanan = Pesanan::where('is_lunas', true)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        // Group by day for the chart
        $pendapatanHarian = Pesanan::where('is_lunas', true)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total, COUNT(id) as jml_pesanan')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = $pendapatanHarian->pluck('tanggal')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $data = $pendapatanHarian->pluck('total');

        return view('admin.laporan.index', compact('bulan', 'tahun', 'totalPendapatan', 'totalPesanan', 'labels', 'data', 'pendapatanHarian'));
    }

    /**
     * Halaman cetak QR Code Meja.
     */
    public function qrMeja()
    {
        return view('admin.qr-meja');
    }

    /**
     * Cek apakah ada pesanan baru untuk notifikasi (AJAX).
     */
    public function checkNewOrders()
    {
        $latestOrder = Pesanan::withCount('porsiPesanans')->latest()->first();
        $newOrdersCount = Pesanan::whereIn('status', ['menunggu_verifikasi', 'belum_bayar'])->count();
        
        return response()->json([
            'latest_id' => $latestOrder ? $latestOrder->id : 0,
            'kode' => $latestOrder ? $latestOrder->kode_pesanan : '',
            'nama' => $latestOrder ? $latestOrder->nama_pemesan : '',
            'meja' => $latestOrder ? $latestOrder->nomor_meja : '',
            'porsi_count' => $latestOrder ? $latestOrder->porsi_pesanans_count : 0,
            'new_orders_count' => $newOrdersCount,
        ]);
    }
}
