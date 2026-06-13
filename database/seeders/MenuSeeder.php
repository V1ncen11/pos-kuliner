<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // === MAKANAN ===
            ['nama_menu' => 'Nasi Goreng Spesial', 'kategori' => 'makanan', 'harga' => 25000, 'stok' => 50],
            ['nama_menu' => 'Ayam Bakar Madu',     'kategori' => 'makanan', 'harga' => 30000, 'stok' => 50],
            ['nama_menu' => 'Mie Gacoan Level 1-5', 'kategori' => 'makanan', 'harga' => 15000, 'stok' => 100],
            ['nama_menu' => 'Nasi Gila',           'kategori' => 'makanan', 'harga' => 22000, 'stok' => 50],
            ['nama_menu' => 'Spaghetti Bolognese', 'kategori' => 'makanan', 'harga' => 28000, 'stok' => 40],
            ['nama_menu' => 'Kwetiau Goreng',      'kategori' => 'makanan', 'harga' => 24000, 'stok' => 50],
            
            // === MINUMAN ===
            ['nama_menu' => 'Es Kopi Susu Aren',   'kategori' => 'minuman', 'harga' => 18000, 'stok' => 100],
            ['nama_menu' => 'Matcha Latte',        'kategori' => 'minuman', 'harga' => 22000, 'stok' => 80],
            ['nama_menu' => 'Lychee Tea',          'kategori' => 'minuman', 'harga' => 15000, 'stok' => 100],
            ['nama_menu' => 'Lemon Tea',           'kategori' => 'minuman', 'harga' => 12000, 'stok' => 100],
            ['nama_menu' => 'Air Mineral',         'kategori' => 'minuman', 'harga' => 5000,  'stok' => 100],
            ['nama_menu' => 'Es Coklat',           'kategori' => 'minuman', 'harga' => 20000, 'stok' => 80],

            // === SNACK ===
            ['nama_menu' => 'Kentang Goreng',      'kategori' => 'snack', 'harga' => 15000, 'stok' => 60],
            ['nama_menu' => 'Dimsum Ayam',         'kategori' => 'snack', 'harga' => 18000, 'stok' => 50],
            ['nama_menu' => 'Cireng Bumbu Rujak',  'kategori' => 'snack', 'harga' => 12000, 'stok' => 60],
            ['nama_menu' => 'Pisang Bakar Coklat', 'kategori' => 'snack', 'harga' => 16000, 'stok' => 50],
            ['nama_menu' => 'Roti Bakar Keju',     'kategori' => 'snack', 'harga' => 16000, 'stok' => 50],
            ['nama_menu' => 'Platter Mix',         'kategori' => 'snack', 'harga' => 25000, 'stok' => 30],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['nama_menu' => $menu['nama_menu']],
                $menu
            );
        }
    }
}
