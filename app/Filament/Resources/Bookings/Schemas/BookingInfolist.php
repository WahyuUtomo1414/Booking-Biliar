<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('pelanggan.nama')
                    ->label('Nama Pelanggan'),
                TextEntry::make('meja.nama')
                    ->label('Nomor Meja'),
                TextEntry::make('kode_booking'),
                TextEntry::make('tanggal')
                    ->date(),
                TextEntry::make('jam_mulai')
                    ->time(),
                TextEntry::make('jam_selesai')
                    ->time(),
                TextEntry::make('durasi_booking')
                    ->numeric()
                    ->suffix(' Menit'),
                TextEntry::make('total_harga')
                    ->numeric()
                    ->prefix('Rp. '),

                    Section::make('Pembayaran')
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([

                            TextEntry::make('pembayaran.jenis_pembayaran')
                                ->label('Jenis Pembayaran')
                                ->placeholder('Belum ada pembayaran'),

                            TextEntry::make('pembayaran.jumlah_bayar')
                                ->label('Jumlah Bayar')
                                ->numeric()
                                ->formatStateUsing(fn ($state) =>
                                    $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-'
                                ),

                            ImageEntry::make('pembayaran.bukti_pembayaran')
                                ->label('Bukti Pembayaran')
                                ->height(200)
                                ->visible(fn ($record) => !empty($record->pembayaran?->bukti_pembayaran)),

                            TextEntry::make('pembayaran.status')
                                ->label('Status Pembayaran')
                                ->badge()
                                ->colors([
                                    'danger' => 'belum lunas',
                                    'success' => 'lunas',
                                ]),
                        ])
                        ->columns(2)->columnSpanFull()
                        ->visible(fn ($record) => $record->pembayaran !== null),

                Section::make('Data Tracked')
                    ->icon(Heroicon::ArchiveBox)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('createdBy.name')
                                    ->label('Created By')
                                    ->placeholder('-'),
                                TextEntry::make('updatedBy.name')
                                    ->label('Updated By')
                                    ->placeholder('-'),
                                TextEntry::make('deletedBy.name')
                                    ->label('Deleted By')
                                    ->placeholder('-'),
                            ]),
                ])->columnSpanFull()->collapsible(),

                Section::make('Timestamps')
                    ->icon(Heroicon::Clock)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime('d/F/Y H:i'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('d/F/Y H:i'),
                            ]),
                ])->columnSpanFull()->collapsible(),
            ]);
    }
}
