<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
        protected $fillable = [
        'user_id',
        'sarana',
        'lokasi',
        'deskripsi',
        'bukti',
        'status',
        'catatan',
        'biaya_perbaikan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
