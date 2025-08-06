<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataInventarisMaster extends Model
{
    protected $connection = 'mysql_remote';
    protected $table = 'data_inventaris_master';
    protected $primaryKey = 'inv_rekening';
    public $incrementing = false; 
    protected $keyType = 'string'; 

    public $timestamps = false;

}
