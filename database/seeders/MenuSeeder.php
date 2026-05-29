<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // === TOPPING SEBLAK ===
            ['nama_menu' => 'Bakso Urat',     'kategori' => 'topping', 'harga' => 5000,  'stok' => 100],
            ['nama_menu' => 'Bakso Halus',     'kategori' => 'topping', 'harga' => 4000,  'stok' => 100],
            ['nama_menu' => 'Ceker Ayam',      'kategori' => 'topping', 'harga' => 5000,  'stok' => 80],
            ['nama_menu' => 'Sosis',           'kategori' => 'topping', 'harga' => 4000,  'stok' => 100],
            ['nama_menu' => 'Telur Puyuh',     'kategori' => 'topping', 'harga' => 4000,  'stok' => 100],
            ['nama_menu' => 'Telur Ayam',      'kategori' => 'topping', 'harga' => 5000,  'stok' => 50],
            ['nama_menu' => 'Kerupuk Seblak',  'kategori' => 'topping', 'harga' => 3000,  'stok' => 200],
            ['nama_menu' => 'Mie',             'kategori' => 'topping', 'harga' => 3000,  'stok' => 100],
            ['nama_menu' => 'Kwetiau',         'kategori' => 'topping', 'harga' => 3000,  'stok' => 100],
            ['nama_menu' => 'Makaroni',        'kategori' => 'topping', 'harga' => 3000,  'stok' => 100],
            ['nama_menu' => 'Sayap Ayam',      'kategori' => 'topping', 'harga' => 7000,  'stok' => 50],
            ['nama_menu' => 'Dumpling',        'kategori' => 'topping', 'harga' => 5000,  'stok' => 80],
            ['nama_menu' => 'Fish Cake',       'kategori' => 'topping', 'harga' => 4000,  'stok' => 80],
            ['nama_menu' => 'Tahu',            'kategori' => 'topping', 'harga' => 3000,  'stok' => 100],
            ['nama_menu' => 'Cuanki',          'kategori' => 'topping', 'harga' => 4000,  'stok' => 80],

            // === MINUMAN ===
            ['nama_menu' => 'Es Teh Manis',    'kategori' => 'minuman', 'harga' => 5000,  'stok' => 100],
            ['nama_menu' => 'Es Jeruk',        'kategori' => 'minuman', 'harga' => 7000,  'stok' => 100],
            ['nama_menu' => 'Air Mineral',     'kategori' => 'minuman', 'harga' => 4000,  'stok' => 100],
            ['nama_menu' => 'Pop Ice',         'kategori' => 'minuman', 'harga' => 8000,  'stok' => 80],
            ['nama_menu' => 'Es Coklat',       'kategori' => 'minuman', 'harga' => 8000,  'stok' => 80],
            ['nama_menu' => 'Thai Tea',        'kategori' => 'minuman', 'harga' => 10000, 'stok' => 60],
            ['nama_menu' => 'Teh Hangat',      'kategori' => 'minuman', 'harga' => 4000,  'stok' => 100],
            ['nama_menu' => 'Kopi Susu',       'kategori' => 'minuman', 'harga' => 12000, 'stok' => 50],

            // === CEMILAN ===
            ['nama_menu' => 'Cireng Isi',      'kategori' => 'cemilan', 'harga' => 10000, 'stok' => 50],
            ['nama_menu' => 'Batagor',         'kategori' => 'cemilan', 'harga' => 12000, 'stok' => 50],
            ['nama_menu' => 'Siomay',          'kategori' => 'cemilan', 'harga' => 10000, 'stok' => 50],
            ['nama_menu' => 'Kentang Goreng',  'kategori' => 'cemilan', 'harga' => 12000, 'stok' => 40],
            ['nama_menu' => 'Pisang Goreng',   'kategori' => 'cemilan', 'harga' => 8000,  'stok' => 50],
            ['nama_menu' => 'Dimsum Ayam',     'kategori' => 'cemilan', 'harga' => 10000, 'stok' => 50],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['nama_menu' => $menu['nama_menu']],
                $menu
            );
        }
    }
}
