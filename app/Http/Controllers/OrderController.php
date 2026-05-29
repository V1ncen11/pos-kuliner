<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Landing page — input nama pemesan, nomor meja otomatis dari query param.
     */
    public function index(Request $request)
    {
        $meja = $request->query('meja');

        // Validasi nomor meja (1-9)
        if (!$meja || !in_array((int)$meja, range(1, 9))) {
            return view('order.invalid-meja')->with('message', 'Nomor meja tidak valid. Silakan scan ulang QR code di meja kamu ya!');
        }

        // Cek meja terisi
        $terisi = \App\Models\Pesanan::where('nomor_meja', $meja)
            ->whereIn('status', ['menunggu_verifikasi', 'belum_bayar', 'diproses'])
            ->exists();
            
        if ($terisi) {
            return view('order.invalid-meja')->with('message', 'Meja ini sedang digunakan. Silakan pilih meja lain atau hubungi kasir.');
        }

        return view('order.index', [
            'nomor_meja' => (int) $meja,
        ]);
    }

    /**
     * Halaman menu — pilih level pedas, jenis rasa, dan item menu.
     */
    public function menu(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'nomor_meja' => 'required|integer|min:1|max:9',
        ]);

        $menus = Menu::tersedia()->get()->groupBy('kategori');

        return view('order.menu', [
            'nama_pemesan' => $request->nama_pemesan,
            'nomor_meja' => $request->nomor_meja,
            'toppings' => $menus->get('topping', collect()),
            'minuman' => $menus->get('minuman', collect()),
            'cemilan' => $menus->get('cemilan', collect()),
        ]);
    }

    /**
     * Proses checkout — simpan pesanan + detail dengan DB Transaction.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'nomor_meja' => 'required|integer|min:1|max:9',
            'metode_bayar' => 'required|in:cash,qris',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'porsis' => 'required|array|min:1',
            'porsis.*.nama_porsi' => 'required|string',
            'porsis.*.level_pedas' => 'required|in:0,1,2,3,4,5',
            'porsis.*.jenis_rasa' => 'required|in:gurih,gurih_manis',
            'porsis.*.catatan' => 'nullable|string|max:500',
            'porsis.*.items' => 'required|array|min:1',
            'porsis.*.items.*.menu_id' => 'required|exists:menus,id',
            'porsis.*.items.*.jumlah' => 'required|integer|min:1',
        ]);

        // Jika metode QRIS, bukti bayar wajib
        if ($request->metode_bayar === 'qris' && !$request->hasFile('bukti_bayar')) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['bukti_bayar' => ['Bukti pembayaran QRIS wajib diunggah.']]], 422);
            }
            return back()->withErrors(['bukti_bayar' => 'Bukti pembayaran QRIS wajib diunggah.'])->withInput();
        }

        try {
            $pesanan = DB::transaction(function () use ($request) {
                // 1. Upload bukti bayar jika QRIS
                $buktiPath = null;
                if ($request->hasFile('bukti_bayar')) {
                    $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
                }

                // 2. Buat record pesanan (tanpa level_pedas/jenis_rasa)
                $pesanan = Pesanan::create([
                    'kode_pesanan' => Pesanan::generateKodePesanan(),
                    'nama_pemesan' => $request->nama_pemesan,
                    'nomor_meja' => $request->nomor_meja,
                    'metode_bayar' => $request->metode_bayar,
                    'bukti_bayar_path' => $buktiPath,
                    'status' => $request->metode_bayar === 'qris' ? 'menunggu_verifikasi' : 'belum_bayar',
                    'total_harga' => 0,
                ]);

                // 3. Loop porsis
                $totalHarga = 0;

                foreach ($request->porsis as $porsiData) {
                    $porsi = $pesanan->porsiPesanans()->create([
                        'nama_porsi' => $porsiData['nama_porsi'],
                        'level_pedas' => $porsiData['level_pedas'],
                        'jenis_rasa' => $porsiData['jenis_rasa'],
                        'catatan' => $porsiData['catatan'] ?? null,
                    ]);

                    // Loop items di dalam porsi ini
                    foreach ($porsiData['items'] as $item) {
                        $menu = Menu::findOrFail($item['menu_id']);

                        if ($menu->stok < $item['jumlah']) {
                            throw new \Exception("Stok {$menu->nama_menu} tidak cukup. Tersisa: {$menu->stok}");
                        }

                        $subtotal = $menu->harga * $item['jumlah'];

                        DetailPesanan::create([
                            'pesanan_id' => $pesanan->id,
                            'porsi_pesanan_id' => $porsi->id,
                            'menu_id' => $menu->id,
                            'jumlah' => $item['jumlah'],
                            'harga_satuan' => $menu->harga,
                            'subtotal' => $subtotal,
                        ]);

                        $menu->decrement('stok', $item['jumlah']);
                        $totalHarga += $subtotal;
                    }
                }

                // 4. Update total harga
                $pesanan->update(['total_harga' => $totalHarga]);

                return $pesanan;
            });

            return redirect()->route('order.sukses', $pesanan->kode_pesanan);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['error' => [$e->getMessage()]]], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Halaman sukses — tampilkan detail pesanan.
     */
    public function sukses(string $kode)
    {
        $pesanan = Pesanan::where('kode_pesanan', $kode)
            ->with(['porsiPesanans.detailPesanans.menu'])
            ->firstOrFail();

        return view('order.sukses', compact('pesanan'));
    }
}
