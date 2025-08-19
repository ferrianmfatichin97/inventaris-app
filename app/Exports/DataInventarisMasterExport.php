<?php

namespace App\Exports;

use App\Models\DataInventarisMaster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class DataInventarisMasterExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithEvents
{
    protected $filters;
    protected $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DataInventarisMaster::query();

        if (!empty($this->filters['Tanggal Perolehan']['from'])) {
            $query->whereDate('inv_peroleh_tanggal', '>=', $this->filters['Tanggal Perolehan']['from']);
        }
        if (!empty($this->filters['Tanggal Perolehan']['until'])) {
            $query->whereDate('inv_peroleh_tanggal', '<=', $this->filters['Tanggal Perolehan']['until']);
        }

        if (!empty($this->filters['periode']['value'])) {
            [$year, $month] = explode('-', $this->filters['periode']['value']);
            $query->whereYear('inv_peroleh_tanggal', $year)
                ->whereMonth('inv_peroleh_tanggal', $month);
        }

        return $query->orderByDesc('inv_peroleh_tanggal')->get();
    }

    public function headings(): array
    {
        return [
            ['PT BPR DP TASPEN'],
            ['KANTOR PUSAT KONSOLIDASI'],
            ['Alamat: Jalan Kantor Alamat'],
            [],
            ['RINCIAN NOMINATIF AKTIVA TETAP DAN INVENTARIS'],
            ['Di Download Pada : ' . now()->translatedFormat('d F Y')],
            [],
            [
                'No.',
                'Nomor Rekening/Seri',
                'Nama Aktiva',
                'Tanggal Perolehan',
                'Nilai Perolehan',
                'Status',
            ]
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->inv_rekening,
            $row->inv_nama,
            Carbon::parse($row->inv_peroleh_tanggal)->format('d/m/Y'),
            $row->inv_peroleh_nilai,
            $row->inv_status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => '#,##0', // Format rupiah tanpa simbol
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge untuk header
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                $sheet->mergeCells('A5:F5');
                $sheet->mergeCells('A6:F6');

                // Bold header perusahaan & judul
                $sheet->getStyle('A1:A3')->getFont()->setBold(true);
                $sheet->getStyle('A5:A6')->getFont()->setBold(true);

                // Bold header kolom tabel
                $sheet->getStyle('A8:F8')->getFont()->setBold(true);
                $sheet->getStyle('A8:F8')->getAlignment()->setHorizontal('center');

                // Auto width kolom
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
