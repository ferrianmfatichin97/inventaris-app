<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisKendaraan extends Model
{
     use HasFactory;
      protected $table = 'inventaris_kendaraan'; 

    protected $fillable = [
        'inventaris_id',
        'no_rangka',
        'no_mesin',
        'no_bpkb',
        'no_polisi',
        'expire_stnk',
        'warna',
        'tahun_pembuatan',
        'tahun_perakitan',
        'atas_nama',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
