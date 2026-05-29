<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * List semua menu.
     */
    public function index()
    {
        $menus = Menu::orderBy('kategori')->orderBy('nama_menu')->get()->groupBy('kategori');
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Form tambah menu baru.
     */
    public function create()
    {
        return view('admin.menu.form', [
            'menu' => null,
            'title' => 'Tambah Menu Baru',
        ]);
    }

    /**
     * Simpan menu baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'kategori' => 'required|in:topping,minuman,cemilan',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tersedia' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar_path'] = $request->file('gambar')->store('menu', 'public');
        }

        $validated['tersedia'] = $request->has('tersedia');

        Menu::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Form edit menu.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menu.form', [
            'menu' => $menu,
            'title' => 'Edit Menu',
        ]);
    }

    /**
     * Update menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'kategori' => 'required|in:topping,minuman,cemilan',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tersedia' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($menu->gambar_path) {
                Storage::disk('public')->delete($menu->gambar_path);
            }
            $validated['gambar_path'] = $request->file('gambar')->store('menu', 'public');
        }

        $validated['tersedia'] = $request->has('tersedia');

        $menu->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Hapus menu.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->gambar_path) {
            Storage::disk('public')->delete($menu->gambar_path);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle ketersediaan menu (AJAX).
     */
    public function toggleTersedia(Menu $menu)
    {
        $menu->update(['tersedia' => !$menu->tersedia]);

        return response()->json([
            'success' => true,
            'tersedia' => $menu->tersedia,
            'message' => $menu->tersedia ? 'Menu diaktifkan' : 'Menu dinonaktifkan',
        ]);
    }
}
