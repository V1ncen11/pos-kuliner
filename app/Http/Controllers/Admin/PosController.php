<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Tampilkan halaman Kasir POS.
     */
    public function index()
    {
        $toppings = Menu::where('kategori', 'topping')->where('tersedia', true)->get();
        $minuman = Menu::where('kategori', 'minuman')->where('tersedia', true)->get();
        $cemilan = Menu::where('kategori', 'cemilan')->where('tersedia', true)->get();

        $today = now()->toDateString();
        $stats = [
            'pesanan_masuk' => Pesanan::whereDate('created_at', $today)->count(),
            'total_hari_ini' => Pesanan::whereDate('created_at', $today)->where('status', 'selesai')->sum('total_harga'),
        ];

        return view('admin.pos.index', compact('toppings', 'minuman', 'cemilan', 'stats'));
    }

    /**
     * Simpan pesanan dari Kasir POS.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'metode_bayar' => 'required|in:cash,qris',
            'level_pedas' => 'required|in:0,1,2,3,4,5',
            'jenis_rasa' => 'required|in:gurih,gurih_manis',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            $pesanan = DB::transaction(function () use ($request) {
                // 1. Buat record pesanan
                $pesanan = Pesanan::create([
                    'kode_pesanan' => Pesanan::generateKodePesanan(),
                    'nama_pemesan' => $request->nama_pemesan,
                    'nomor_meja' => 0, // 0 menandakan Take-Away / POS
                    'metode_bayar' => $request->metode_bayar,
                    'status' => 'selesai', // Langsung lunas karena input via kasir
                    'total_harga' => 0,
                ]);

                // 2. Buat Porsi Pertama
                $porsi = \App\Models\PorsiPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'nama_porsi' => 'Mangkuk 1',
                    'level_pedas' => $request->level_pedas,
                    'jenis_rasa' => $request->jenis_rasa,
                    'catatan' => null
                ]);

                // 2. Loop items → insert detail pesanan + kurangi stok
                $totalHarga = 0;

                foreach ($request->items as $item) {
                    $menu = Menu::findOrFail($item['menu_id']);

                    // Cek stok cukup
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

                    // Kurangi stok
                    $menu->decrement('stok', $item['jumlah']);

                    $totalHarga += $subtotal;
                }

                // 3. Update total harga
                $pesanan->update(['total_harga' => $totalHarga]);

                return $pesanan;
            });

            // Redirect ke halaman cetak struk (bisa ditambahkan auto=1 di route parameternya nanti)
            return redirect()->route('admin.pesanan.cetak', ['id' => $pesanan->id, 'auto' => 1])
                             ->with('success', 'Pesanan Kasir berhasil dibuat!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
