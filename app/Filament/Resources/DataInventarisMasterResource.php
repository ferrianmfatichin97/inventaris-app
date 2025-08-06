<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataInventarisMasterResource\Pages;
use App\Filament\Resources\DataInventarisMasterResource\RelationManagers;
use App\Models\DataInventarisMaster;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class DataInventarisMasterResource extends Resource
{
    protected static ?string $model = DataInventarisMaster::class;

    protected static ?string $navigationGroup = 'Management Inventaris';
    protected static ?string $navigationLabel = 'Data Inventaris Server';
    protected static ?string $slug = 'data-inventaris-server';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inv_rekening')->label('Rekening')->searchable(),
                Tables\Columns\TextColumn::make('inv_nama')->label('Nama Barang')->searchable(),
                Tables\Columns\TextColumn::make('inv_seri')->label('No Seri'),
                // Tables\Columns\TextColumn::make('inv_kantor')->label('Kantor'),
                // Tables\Columns\TextColumn::make('inv_subkantor')->label('Sub Kantor'),
                Tables\Columns\TextColumn::make('inv_peroleh_tanggal')->label('Tgl Peroleh')->date(),
                Tables\Columns\TextColumn::make('inv_peroleh_nilai')->label('Nilai Peroleh')->money('IDR'),
                // Tables\Columns\TextColumn::make('inv_nilai_buku')->label('Nilai Buku')->money('IDR'),
                Tables\Columns\TextColumn::make('inv_status')->label('Status'),


            ])
            // ->defaultSort('inv_rekening', 'asc')
            ->defaultSort('inv_peroleh_tanggal', 'desc')
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record): string => route('inventaris-master.show', $record->inv_rekening))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataInventarisMasters::route('/'),
            'create' => Pages\CreateDataInventarisMaster::route('/create'),
            'edit' => Pages\EditDataInventarisMaster::route('/{record}/edit'),
        ];
    }
}
