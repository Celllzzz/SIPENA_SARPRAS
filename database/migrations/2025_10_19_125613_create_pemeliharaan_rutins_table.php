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
        Schema::create('pemeliharaan_rutins', function (Blueprint $table) {
            $table->id();
            $table->string('sarana'); 
            $table->string('lokasi');
            $table->string('frekuensi');
            $table->date('tanggal_berikutnya');
            $table->string('status')->default('Terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan_rutins');
    }
};
