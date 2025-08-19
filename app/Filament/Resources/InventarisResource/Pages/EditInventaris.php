<?php

namespace App\Filament\Resources\InventarisResource\Pages;

use App\Filament\Resources\InventarisResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditInventaris extends EditRecord
{
    protected static string $resource = InventarisResource::class;

    protected function afterSave(): void
    {
        $data = $this->data;
        Log::info("Input Data", $data);

        if ($this->record->jenis_inventaris === 'Kendaraan' && !empty($data['kendaraan'])) {
            $this->record->kendaraan()->updateOrCreate(
                ['inventaris_id' => $this->record->id],
                $data['kendaraan']
            );
        }

        if (in_array($this->record->jenis_inventaris, ['Tanah', 'Gedung']) && !empty($data['tanahGedung'])) {
            $this->record->tanahGedung()->updateOrCreate(
                ['inventaris_id' => $this->record->id],
                $data['tanahGedung']
            );
        }
    }
}
