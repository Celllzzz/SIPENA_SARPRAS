<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom catatan ke tabel pelaporans.
     */
    public function up(): void
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Rollback perubahan.
     */
    public function down(): void
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
