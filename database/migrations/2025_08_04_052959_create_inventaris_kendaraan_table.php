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
        Schema::create('inventaris_kendaraan', function (Blueprint $table) {
           $table->id();
            $table->foreignId('inventaris_id')->constrained()->onDelete('cascade');
            $table->string('no_rangka')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('no_bpkb')->nullable();
            $table->string('no_polisi')->nullable();
            $table->date('expire_stnk')->nullable();
            $table->string('warna')->nullable();
            $table->year('tahun_pembuatan')->nullable();
            $table->year('tahun_perakitan')->nullable();
            $table->string('atas_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_kendaraan');
    }
};
