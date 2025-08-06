<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages;
use App\Models\Inventaris;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    // protected static ?string $navigationIcon = 'heroicon-o-collection';
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
            Forms\Components\TextInput::make('lokasi_barang'),
            Forms\Components\DatePicker::make('tanggal_perolehan'),
            Forms\Components\TextInput::make('nilai_perolehan')->numeric(),
            Forms\Components\TextInput::make('usia_pemakaian_bulan')->numeric(),
            Forms\Components\DatePicker::make('tanggal_habis_buku'),

            Forms\Components\Group::make([
                Forms\Components\TextInput::make('tanahGedung.no_shm'),
                Forms\Components\TextInput::make('tanahGedung.luas_tanah')->numeric(),
                Forms\Components\TextInput::make('tanahGedung.luas_gedung')->numeric(),
            ])
            ->visible(fn ($get) => in_array($get('jenis_inventaris'), ['Tanah', 'Gedung'])),

            Forms\Components\Group::make([
                Forms\Components\TextInput::make('kendaraan.no_polisi'),
                Forms\Components\TextInput::make('kendaraan.no_rangka'),
                Forms\Components\DatePicker::make('kendaraan.expire_stnk'),
            ])
            ->visible(fn ($get) => $get('jenis_inventaris') === 'Kendaraan'),

            Forms\Components\Textarea::make('keterangan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_barang')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('jenis_inventaris'),
            Tables\Columns\TextColumn::make('nilai_perolehan')->money('IDR'),
            Tables\Columns\TextColumn::make('lokasi_barang'),
        ]);
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
