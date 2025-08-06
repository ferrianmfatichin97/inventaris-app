<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory;

    protected $fillable = [
        'kantor_bank_id',
        'sub_kantor_id',
        'no_rekening',
        'no_seri',
        'jenis_inventaris',
        'ruangan_id',
        'golongan_id',
        'nama_barang',
        'sumber_perolehan',
        'tanggal_perolehan',
        'nilai_perolehan',
        'usia_pemakaian_bulan',
        'tanggal_habis_buku',
        'penyusutan_per_bulan',
        'penyusutan_per_tahun',
        'akumulasi_penyusutan',
        'nilai_buku_efektif',
        'keterangan',
        'status_inventaris',
    ];

    public function tanahGedung()
    {
        return $this->hasOne(InventarisTanahGedung::class);
    }

    public function kendaraan()
    {
        return $this->hasOne(InventarisKendaraan::class);
    }
}
