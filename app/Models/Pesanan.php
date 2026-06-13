<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'nama_pemesan',
        'nomor_meja',
        'metode_bayar',
        'bukti_bayar_path',
        'status',
        'is_lunas',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'nomor_meja' => 'integer',
            'total_harga' => 'integer',
            'is_lunas' => 'boolean',
        ];
    }

    public function porsiPesanans()
    {
        return $this->hasMany(PorsiPesanan::class);
    }

    /**
     * Relasi: pesanan memiliki banyak detail item.
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    /**
     * Generate kode pesanan unik: SH-20260510-0001
     */
    public static function generateKodePesanan(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix = "SH-{$tanggal}-";

        $lastOrder = static::where('kode_pesanan', 'like', $prefix . '%')
            ->orderBy('kode_pesanan', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->kode_pesanan, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Label status yang lebih readable.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_verifikasi' => '⏳ Menunggu Verifikasi',
            'belum_bayar' => '💰 Belum Bayar',
            'diproses' => '🍳 Sedang Diproses',
            'selesai' => '✅ Selesai',
            'dibatalkan' => '❌ Dibatalkan',
            default => $this->status,
        };
    }

    /**
     * Badge CSS class berdasarkan status.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800',
            'belum_bayar' => 'bg-red-100 text-red-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Format total harga.
     */
    public function getTotalHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}
