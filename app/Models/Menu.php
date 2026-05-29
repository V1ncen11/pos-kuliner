<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'stok',
        'gambar_path',
        'tersedia',
    ];

    protected function casts(): array
    {
        return [
            'tersedia' => 'boolean',
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }

    /**
     * Scope: hanya menu yang tersedia dan stok > 0.
     */
    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true)->where('stok', '>', 0);
    }

    /**
     * Relasi: menu dipesan di banyak detail pesanan.
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    /**
     * Format harga ke Rupiah.
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
