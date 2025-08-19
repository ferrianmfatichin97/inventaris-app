<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataInventarisMasterExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataInventarisMasterController extends Controller
{
    public function show($inv_rekening)
    {
        // Ambil dari server remote
        $data = DB::connection('mysql_remote')
            ->table('data_inventaris_master')
            ->where('inv_rekening', $inv_rekening)
            ->first();

        if (!$data) {
            abort(404, 'Data tidak ditemukan.');
        }

        // Ambil lokasi dari tabel inventaris lokal
        $inventarisLocal = \App\Models\Inventaris::where('no_rekening', $inv_rekening)->first();

        // Tambahin property lokasi_barang
        $data->lokasi_barang = $inventarisLocal->lokasi_barang ?? '-';
        

        // return view('inventaris-master.show', compact('data'));
        return view('inventaris-master.show', [
            'data' => $data,
            'inventarisLocal' => $inventarisLocal
        ]);
    }


    public function export(Request $request)
    {
        $rawFilters = $request->input('filters', '{}');
        $filters = json_decode($rawFilters, true);

        $fileName = 'Inventaris';

        if (!empty($filters['periode']['value'])) {
            $fileName .= '_' . $filters['periode']['value'];
        }

        if (!empty($filters['Tanggal Perolehan']['from']) && !empty($filters['Tanggal Perolehan']['until'])) {
            $from = \Carbon\Carbon::parse($filters['Tanggal Perolehan']['from'])->format('d-m-Y');
            $until = \Carbon\Carbon::parse($filters['Tanggal Perolehan']['until'])->format('d-m-Y');
            $fileName .= "_{$from}_sampai_{$until}";
        }

        $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $fileName);
        // dd([
        //     'filters' => $filters,
        //     'fileName' => $fileName
        // ]);
        return Excel::download(
            new DataInventarisMasterExport($filters),
            $fileName . '.xlsx'
        );
    }
}
