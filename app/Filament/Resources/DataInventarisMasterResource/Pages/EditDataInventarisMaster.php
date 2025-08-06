<?php

namespace App\Filament\Resources\DataInventarisMasterResource\Pages;

use App\Filament\Resources\DataInventarisMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataInventarisMaster extends EditRecord
{
    protected static string $resource = DataInventarisMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
