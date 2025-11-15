<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Support\RawJs;
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
                                    $item->id => $item->nama . ' — ' . $item->tipe
                                ])
                        )
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->native(false)
                        ->afterStateUpdated(function ($state, callable $set, $get) {

                            $durasi = $get('durasi_booking');
                            if (!$durasi) return;

                            $meja = \App\Models\Meja::find($state);
                            if (!$meja) return;

                            $total = ($durasi / 60) * $meja->harga_per_jam;
                            $set('total_harga', $total);
                        }),

                    TextInput::make('kode_booking')
                        ->label('Kode Booking')
                        ->default(fn () => 'BOOK-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT))
                        ->required(),

                    DatePicker::make('tanggal')
                        ->label('Tanggal Booking')
                        ->required(),

                    Select::make('jam_mulai')
                        ->label('Jam Mulai')
                        ->options([
                            '10:00' => '10:00',
                            '11:00' => '11:00',
                            '12:00' => '12:00',
                            '13:00' => '13:00',
                            '14:00' => '14:00',
                            '15:00' => '15:00',
                            '16:00' => '16:00',
                            '17:00' => '17:00',
                            '18:00' => '18:00',
                            '19:00' => '19:00',
                            '20:00' => '20:00',
                        ])
                        ->required()
                        ->reactive()
                        ->native(false)
                        ->afterStateUpdated(function ($state, callable $set, $get) {

                            $mulai = $state;
                            $selesai = $get('jam_selesai');

                            if (!$mulai || !$selesai) return;

                            $hMulai = intval(explode(':', $mulai)[0]);
                            $hSelesai = intval(explode(':', $selesai)[0]);

                            $durasi = ($hSelesai - $hMulai) * 60;
                            $set('durasi_booking', $durasi);

                            $mejaId = $get('meja_id');
                            if ($mejaId) {
                                $meja = \App\Models\Meja::find($mejaId);
                                if ($meja) {
                                    $set('total_harga', ($durasi / 60) * $meja->harga_per_jam);
                                }
                            }
                        }),

                    Select::make('jam_selesai')
                        ->label('Jam Selesai')
                        ->options([
                            '11:00' => '11:00',
                            '12:00' => '12:00',
                            '13:00' => '13:00',
                            '14:00' => '14:00',
                            '15:00' => '15:00',
                            '16:00' => '16:00',
                            '17:00' => '17:00',
                            '18:00' => '18:00',
                            '19:00' => '19:00',
                            '20:00' => '20:00',
                            '21:00' => '21:00',
                        ])
                        ->required()
                        ->reactive()
                        ->native(false)
                        ->afterStateUpdated(function ($state, callable $set, $get) {

                            $mulai = $get('jam_mulai');
                            $selesai = $state;

                            if (!$mulai || !$selesai) return;

                            $hMulai = intval(explode(':', $mulai)[0]);
                            $hSelesai = intval(explode(':', $selesai)[0]);

                            $durasi = ($hSelesai - $hMulai) * 60;
                            $set('durasi_booking', $durasi);

                            $mejaId = $get('meja_id');
                            if ($mejaId) {
                                $meja = \App\Models\Meja::find($mejaId);
                                if ($meja) {
                                    $set('total_harga', ($durasi / 60) * $meja->harga_per_jam);
                                }
                            }
                        }),

                    TextInput::make('durasi_booking')
                        ->label('Durasi (menit)')
                        ->numeric()
                        ->required(),

                    TextInput::make('total_harga')
                        ->label('Total Harga')
                        ->prefix('Rp')
                        ->default(0)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('pembayaran.jumlah_bayar', $state);
                        })
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(['.', ',']),

                ])->columns(2)->columnSpanFull(),

            Section::make('Pembayaran')
                ->description('Isi pembayaran jika pelanggan sudah bayar.')
                ->schema([

                    Select::make('pembayaran.jenis_pembayaran')
                        ->label('Jenis Pembayaran')
                        ->options([
                            'Cash' => 'Cash',
                            'Transfer' => 'Transfer',
                            'Qriz' => 'Qriz',
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
