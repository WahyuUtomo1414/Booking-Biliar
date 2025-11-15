<?php

namespace App\Filament\Resources\Mejas\Schemas;

use Filament\Support\RawJs;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;

class MejaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                ->label('Nama Meja')
                ->required(),

                Select::make('tipe')
                    ->label('Tipe Meja')
                    ->options([
                        'Regular' => 'Regular',
                        'VIP' => 'VIP',
                    ])
                    ->required()
                    ->native(false), // biar dropdown-nya bagus

                TextInput::make('harga_per_jam')
                    ->label('Harga per Jam')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->prefix("Rp"),

                Select::make('status')
                    ->label('Status Meja')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Pemeliharaan' => 'Pemeliharaan',
                    ])
                    ->required()
                    ->native(false),

                Toggle::make('active')
                    ->label('Aktif')
                    ->required(),
            ]);
    }
}
