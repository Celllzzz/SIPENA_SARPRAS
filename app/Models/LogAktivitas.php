<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelaporan_id',
        'user_id',
        'aktivitas',
    ];

    /**
     * Mendapatkan user yang melakukan aktivitas.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}