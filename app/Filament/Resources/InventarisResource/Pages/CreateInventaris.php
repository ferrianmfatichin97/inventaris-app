<?php

namespace App\Filament\Resources\InventarisResource\Pages;

use App\Filament\Resources\InventarisResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateInventaris extends CreateRecord
{
    protected static string $resource = InventarisResource::class;

    protected function afterCreate(): void
    {
        $data = $this->data;

        Log::info("Input Data", $data);
        if ($this->record->jenis_inventaris === 'Kendaraan' && !empty($data['kendaraan'])) {
            $this->record->kendaraan()->create($data['kendaraan']);
        }

        if (in_array($this->record->jenis_inventaris, ['Tanah', 'Gedung']) && !empty($data['tanahGedung'])) {
            $this->record->tanahGedung()->create($data['tanahGedung']);
        }
    }
}
