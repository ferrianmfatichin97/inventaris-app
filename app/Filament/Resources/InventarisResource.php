<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages;
use App\Models\Inventaris;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Support\RawJs;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    protected static ?string $navigationGroup = 'Management Inventaris';
    protected static ?string $navigationLabel = 'Data Inventaris';
    protected static ?string $slug = 'data-inventaris';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_barang')->required(),

            Forms\Components\Select::make('jenis_inventaris')
                ->options([
                    'Tanah' => 'Tanah',
                    'Gedung' => 'Gedung',
                    'Kendaraan' => 'Kendaraan',
                ])
                ->reactive()
                ->required(),

            Forms\Components\TextInput::make('no_rekening'),
            Forms\Components\TextInput::make('ruangan_id')->label('Lokasi Barang'),
            Forms\Components\TextInput::make('nilai_perolehan')
                ->label('Nilai Perolehan')
                ->prefix('Rp ')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric(),
            Forms\Components\TextInput::make('usia_pemakaian_bulan')->numeric(),
            Forms\Components\DatePicker::make('tanggal_habis_buku'),

            Forms\Components\Group::make([
                Forms\Components\TextInput::make('tanahGedung.no_shm'),
                Forms\Components\TextInput::make('tanahGedung.luas_tanah')->numeric(),
                Forms\Components\TextInput::make('tanahGedung.luas_gedung')->numeric(),
            ])
                ->visible(fn($get) => in_array($get('jenis_inventaris'), ['Tanah', 'Gedung'])),

            Forms\Components\Group::make([
                Forms\Components\TextInput::make('kendaraan.no_polisi')->label('No Polisi'),
                Forms\Components\TextInput::make('kendaraan.no_rangka')->label('No Rangka'),
                Forms\Components\TextInput::make('kendaraan.no_mesin')->label('No Mesin'),
                Forms\Components\TextInput::make('kendaraan.no_bpkb')->label('No BPKB'),
                Forms\Components\DatePicker::make('kendaraan.expire_stnk')->label('Masa Berlaku STNK'),
                Forms\Components\TextInput::make('kendaraan.warna')->label('Warna'),
                Forms\Components\TextInput::make('kendaraan.tahun_pembuatan')->numeric()->label('Tahun Pembuatan'),
                Forms\Components\TextInput::make('kendaraan.tahun_perakitan')->numeric()->label('Tahun Perakitan'),
                Forms\Components\TextInput::make('kendaraan.atas_nama')->label('Atas Nama'),
            ])
                ->columns(2)
                ->visible(fn($get) => $get('jenis_inventaris') === 'Kendaraan'),

            Forms\Components\Textarea::make('keterangan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jenis_inventaris'),
                Tables\Columns\TextColumn::make('nilai_perolehan')->money('IDR'),
                Tables\Columns\TextColumn::make('lokasi_barang'),
            ])
            ->actions([

                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Inventaris')
                    ->modalWidth('4xl')
                    ->form(function ($record) {
                        return [
                            Forms\Components\Card::make([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\Placeholder::make('nama_barang')
                                        ->label('Nama Barang')
                                        ->content($record->nama_barang),

                                    Forms\Components\Placeholder::make('jenis_inventaris')
                                        ->label('Jenis Inventaris')
                                        ->content($record->jenis_inventaris),

                                    Forms\Components\Placeholder::make('no_rekening')
                                        ->label('No Rekening')
                                        ->content($record->no_rekening),

                                    Forms\Components\Placeholder::make('ruangan_id')
                                        ->label('Lokasi Barang')
                                        ->content($record->ruangan_id),

                                    Forms\Components\Placeholder::make('nilai_perolehan')
                                        ->label('Nilai Perolehan')
                                        ->content('Rp ' . number_format($record->nilai_perolehan, 0, ',', '.')),

                                    Forms\Components\Placeholder::make('tanggal_perolehan')
                                        ->label('Tanggal Perolehan')
                                        ->content(optional($record->tanggal_perolehan)->format('d-m-Y')),

                                    Forms\Components\Placeholder::make('keterangan')
                                        ->label('Keterangan')
                                        ->content($record->keterangan),
                                ]),
                            ])->columnSpanFull(),

                            // Detail Kendaraan
                            Forms\Components\Card::make([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\Placeholder::make('no_polisi')
                                        ->label('No Polisi')
                                        ->content(optional($record->kendaraan)->no_polisi),

                                    Forms\Components\Placeholder::make('no_rangka')
                                        ->label('No Rangka')
                                        ->content(optional($record->kendaraan)->no_rangka),

                                    Forms\Components\Placeholder::make('no_mesin')
                                        ->label('No Mesin')
                                        ->content(optional($record->kendaraan)->no_mesin),

                                    Forms\Components\Placeholder::make('no_bpkb')
                                        ->label('No BPKB')
                                        ->content(optional($record->kendaraan)->no_bpkb),

                                    Forms\Components\Placeholder::make('expire_stnk')
                                        ->label('Masa Berlaku STNK')
                                        ->content(optional(optional($record->kendaraan)->expire_stnk)->format('d-m-Y')),

                                    Forms\Components\Placeholder::make('warna')
                                        ->label('Warna')
                                        ->content(optional($record->kendaraan)->warna),

                                    Forms\Components\Placeholder::make('tahun_pembuatan')
                                        ->label('Tahun Pembuatan')
                                        ->content(optional($record->kendaraan)->tahun_pembuatan),

                                    Forms\Components\Placeholder::make('tahun_perakitan')
                                        ->label('Tahun Perakitan')
                                        ->content(optional($record->kendaraan)->tahun_perakitan),

                                    Forms\Components\Placeholder::make('atas_nama')
                                        ->label('Atas Nama')
                                        ->content(optional($record->kendaraan)->atas_nama),
                                ]),
                            ])
                                ->visible(fn() => $record->jenis_inventaris === 'Kendaraan')
                                ->columnSpanFull(),

                            // Detail Tanah/Gedung
                            Forms\Components\Card::make([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\Placeholder::make('no_shm')
                                        ->label('No SHM')
                                        ->content(optional($record->tanahGedung)->no_shm),

                                    Forms\Components\Placeholder::make('luas_tanah')
                                        ->label('Luas Tanah (m²)')
                                        ->content(optional($record->tanahGedung)->luas_tanah),

                                    Forms\Components\Placeholder::make('luas_gedung')
                                        ->label('Luas Gedung (m²)')
                                        ->content(optional($record->tanahGedung)->luas_gedung),
                                ]),
                            ])
                                ->visible(fn() => in_array($record->jenis_inventaris, ['Tanah', 'Gedung']))
                                ->columnSpanFull(),
                            Forms\Components\Card::make([
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('lihat_detail_server')
                                        ->label('Lihat Detail di Server')
                                        ->url(route('inventaris-master.show', $record->no_rekening))
                                        ->openUrlInNewTab(),
                                ]),
                            ]),
                        ];
                    }),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['kendaraan', 'tanahGedung']);
    }

    public function canAccessFilament(): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventaris::route('/'),
            'create' => Pages\CreateInventaris::route('/create'),
            'edit' => Pages\EditInventaris::route('/{record}/edit'),
        ];
    }
}
