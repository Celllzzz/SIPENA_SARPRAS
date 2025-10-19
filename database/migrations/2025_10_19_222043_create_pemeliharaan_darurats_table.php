<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemeliharaan_darurats', function (Blueprint $table) {
            $table->id();
            $table->string('sarana');
            $table->string('lokasi');
            $table->text('deskripsi_kerusakan');
            $table->date('tanggal_pemeliharaan');
            $table->date('tanggal_seharusnya')->nullable(); // Tanggal pemeliharaan rutin seharusnya
            $table->string('status')->default('Dalam Pengerjaan'); // Pilihan: 'Dalam Pengerjaan', 'Selesai'
            $table->unsignedInteger('biaya')->nullable();
            $table->text('catatan_perbaikan')->nullable();
            $table->foreignId('user_id')->constrained('users'); // Admin yang menangani
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan_darurats');
    }
};
