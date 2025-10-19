<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanRutin extends Model
{
    use HasFactory;

    protected $fillable = [
        'sarana',
        'lokasi',
        'frekuensi',
        'tanggal_berikutnya',
        'status',
    ];

    public function catatans()
    {
        return $this->hasMany(CatatanPemeliharaan::class)->latest();
    }
}