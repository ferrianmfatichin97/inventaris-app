<?php

namespace App\Filament\Resources\DataInventarisMasterResource\Pages;

use App\Filament\Resources\DataInventarisMasterResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListDataInventarisMasters extends ListRecords
{
    protected static string $resource = DataInventarisMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('inventaris.export', [
                    'filters' => json_encode($this->getTableFiltersForm()->getState()),
                ]))
                ->openUrlInNewTab(),
        ];
    }
}
