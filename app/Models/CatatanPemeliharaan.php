<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPemeliharaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemeliharaan_rutin_id',
        'user_id',
        'judul',
        'isi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}