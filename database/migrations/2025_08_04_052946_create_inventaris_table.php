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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('kantor_bank_id')->nullable();
            $table->string('sub_kantor_id')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('no_seri')->nullable();
            $table->string('jenis_inventaris');
            $table->string('ruangan_id')->nullable();
            $table->string('golongan_id')->nullable();
            $table->string('nama_barang');
            $table->string('sumber_perolehan')->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->unsignedBigInteger('nilai_perolehan')->default(0);
            $table->unsignedInteger('usia_pemakaian_bulan')->default(0);
            $table->date('tanggal_habis_buku')->nullable();
            $table->unsignedBigInteger('penyusutan_per_bulan')->default(0);
            $table->unsignedBigInteger('penyusutan_per_tahun')->default(0);
            $table->unsignedBigInteger('akumulasi_penyusutan')->default(0);
            $table->unsignedBigInteger('nilai_buku_efektif')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('status_inventaris')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
