<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventarisTanahGedung extends Model
{
     use HasFactory;

    protected $fillable = [
        'inventaris_id',
        'no_shm',
        'no_shgb',
        'tanggal_shm',
        'no_surat_ukur',
        'luas_tanah',
        'luas_gedung',
        'atas_nama',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
