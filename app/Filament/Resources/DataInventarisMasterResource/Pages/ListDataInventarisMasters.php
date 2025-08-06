<?php

namespace App\Filament\Resources\DataInventarisMasterResource\Pages;

use App\Filament\Resources\DataInventarisMasterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
// use Filament\Tables\Actions\Action;

class ListDataInventarisMasters extends ListRecords
{
   protected static string $resource = DataInventarisMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
        ];
    }
}
