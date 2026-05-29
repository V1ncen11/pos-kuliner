<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'porsi_pesanan_id',
        'menu_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'harga_satuan' => 'integer',
            'subtotal' => 'integer',
        ];
    }

    /**
     * Relasi: detail pesanan milik satu pesanan.
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function porsiPesanan()
    {
        return $this->belongsTo(PorsiPesanan::class);
    }

    /**
     * Relasi: detail pesanan merujuk ke satu menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
