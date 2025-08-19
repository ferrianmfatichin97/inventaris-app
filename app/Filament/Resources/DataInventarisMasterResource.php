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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Carbon\Carbon;

class DataInventarisMasterResource extends Resource
{
    protected static ?string $model = DataInventarisMaster::class;

    protected static ?string $navigationGroup = 'Management Inventaris';
    protected static ?string $navigationLabel = 'Data Inventaris Master';
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
            ->filters([
                Filter::make('Tanggal Perolehan')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('inv_peroleh_tanggal', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('inv_peroleh_tanggal', '<=', $date));
                    }),
                SelectFilter::make('periode')
                    ->label('Periode Perolehan')
                    ->options(function () {
                        return DataInventarisMaster::query()
                            ->selectRaw('YEAR(inv_peroleh_tanggal) as year, MONTH(inv_peroleh_tanggal) as month')
                            ->distinct()
                            ->orderByDesc('year')
                            ->orderByDesc('month')
                            ->get()
                            ->mapWithKeys(function ($row) {
                                $label = Carbon::createFromDate($row->year, $row->month, 1)
                                    ->translatedFormat('F Y');
                                $value = $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT);
                                return [$value => $label];
                            })
                            ->toArray();
                    })
                    ->placeholder('Pilih Periode')
                    ->query(function ($query, array $data) {
                        return $query->when($data['value'], function ($q, $value) {
                            [$year, $month] = explode('-', $value);
                            $q->whereYear('inv_peroleh_tanggal', $year)
                                ->whereMonth('inv_peroleh_tanggal', $month);
                        });
                    }),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
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
