<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('pelanggan_id')
                    ->numeric(),
                TextEntry::make('meja_id')
                    ->numeric(),
                TextEntry::make('kode_booking'),
                TextEntry::make('tanggal')
                    ->date(),
                TextEntry::make('jam_mulai')
                    ->time(),
                TextEntry::make('jam_selesai')
                    ->time(),
                TextEntry::make('durasi_booking')
                    ->numeric(),
                TextEntry::make('total_harga')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('updated_by')
                    ->numeric(),
                TextEntry::make('deleted_by')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime(),
            ]);
    }
}
