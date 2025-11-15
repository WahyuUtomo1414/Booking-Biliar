<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Booking')
                    ->schema([

                    Select::make('pelanggan_id')
                        ->label('Pelanggan')
                        ->options(
                            \App\Models\Pelanggan::pluck('nama', 'id')
                        )
                        ->searchable()
                        ->required()
                        ->native(false),

                    Select::make('meja_id')
                        ->label('Meja')
                        ->options(
                            \App\Models\Meja::all()
                                ->mapWithKeys(fn ($item) => [
                                    $item->id => $item->nama . ' - ' . $item->tipe
                                ])
                        )
                        ->searchable()
                        ->required()
                        ->native(false),

                    TextInput::make('kode_booking')
                        ->label('Kode Booking')
                        ->required(),

                    DatePicker::make('tanggal')
                        ->label('Tanggal Booking')
                        ->required(),

                    TimePicker::make('jam_mulai')
                        ->required(),

                    TimePicker::make('jam_selesai')
                        ->required(),

                    TextInput::make('durasi_booking')
                        ->label('Durasi (menit)')
                        ->numeric()
                        ->required(),

                    TextInput::make('total_harga')
                        ->label('Total Harga')
                        ->prefix('Rp')
                        ->numeric()
                        ->required(),

                    Select::make('status')
                        ->label('Status Booking')
                        ->options([
                            'pending' => 'Pending',
                            'active'  => 'Active',
                            'finished' => 'Finished',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required()
                        ->native(false),

                ])->columns(2)->columnSpanFull(),

            Section::make('Pembayaran')
                ->description('Isi pembayaran jika pelanggan sudah bayar.')
                ->schema([

                    Select::make('pembayaran.jenis_pembayaran')
                        ->label('Jenis Pembayaran')
                        ->options([
                            'Cash' => 'Cash',
                            'Transfer' => 'Transfer',
                        ])
                        ->native(false)
                        ->required(),

                    TextInput::make('pembayaran.jumlah_bayar')
                        ->label('Jumlah Bayar')
                        ->prefix('Rp')
                        ->numeric()
                        ->required(),

                    FileUpload::make('pembayaran.bukti_pembayaran')
                        ->label('Bukti Pembayaran')
                        ->directory('bukti_pembayaran')
                        ->image()
                        ->nullable()
                        ->columnSpanFull(),

                    Select::make('pembayaran.status')
                        ->label('Status Pembayaran')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                        ])
                        ->native(false)
                        ->required(),
                ])->columns(2)->columnSpanFull(),
            ]);
    }
}
