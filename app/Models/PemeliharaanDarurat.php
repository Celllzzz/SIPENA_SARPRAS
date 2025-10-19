<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeliharaanDarurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sarana',
        'lokasi',
        'deskripsi_kerusakan',
        'tanggal_pemeliharaan',
        'tanggal_seharusnya',
        'status',
        'biaya',
        'catatan_perbaikan',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}