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
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user (pelapor)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Detail laporan
            $table->string('sarana'); // nama sarana/prasarana
            $table->text('deskripsi'); // deskripsi kerusakan
            $table->string('bukti')->nullable(); // bukti foto/file
            
            // Status laporan
            $table->enum('status', ['verifikasi', 'dalam_perbaikan', 'selesai'])->default('verifikasi');
            
            // Biaya perbaikan
            $table->decimal('biaya_perbaikan', 12, 2)->nullable();
            
            // Timestamp otomatis (created_at & updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporans');
    }
};
