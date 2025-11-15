<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pelanggan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('meja_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kode_booking')
                    ->required(),
                DatePicker::make('tanggal')
                    ->required(),
                TimePicker::make('jam_mulai')
                    ->required(),
                TimePicker::make('jam_selesai')
                    ->required(),
                TextInput::make('durasi_booking')
                    ->required()
                    ->numeric(),
                TextInput::make('total_harga')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
                TextInput::make('deleted_by')
                    ->numeric(),
            ]);
    }
}
