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
        Schema::create('inventaris_tanah_gedung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained()->onDelete('cascade');
            $table->string('no_shm')->nullable();
            $table->string('no_shgb')->nullable();
            $table->date('tanggal_shm')->nullable();
            $table->string('no_surat_ukur')->nullable();
            $table->decimal('luas_tanah', 10, 2)->default(0);
            $table->decimal('luas_gedung', 10, 2)->default(0);
            $table->string('atas_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_tanah_gedung');
    }
};
