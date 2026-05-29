<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorsiPesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function getLevelPedasLabelAttribute()
    {
        $labels = [
            '0' => 'Tidak Pedas',
            '1' => 'Sedikit Pedas',
            '2' => 'Pedas',
            '3' => 'Lumayan Pedas',
            '4' => 'Sangat Pedas',
            '5' => 'Extra Pedas'
        ];
        return $labels[$this->level_pedas] ?? 'Tidak Pedas';
    }

    public function getJenisRasaLabelAttribute()
    {
        return $this->jenis_rasa === 'gurih_manis' ? 'Gurih Manis' : 'Gurih';
    }
}
