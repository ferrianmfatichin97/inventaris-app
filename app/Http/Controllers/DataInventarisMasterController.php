<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataInventarisMasterController extends Controller
{
    public function show($inv_rekening)
    {
        $data = DB::connection('mysql_remote')
            ->table('data_inventaris_master')
            ->where('inv_rekening', $inv_rekening)
            ->first();

        if (!$data) {
            abort(404, 'Data tidak ditemukan.');
        }

        return view('inventaris-master.show', compact('data'));
    }
}
