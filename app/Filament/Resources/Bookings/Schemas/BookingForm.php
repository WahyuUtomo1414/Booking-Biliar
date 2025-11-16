<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Meja;
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
        $updateTotalHarga = function (callable $set, callable $get) {
            $durasi = $get('durasi_booking');
            $mejaId = $get('meja_id');

            if (!$durasi || !$mejaId) {
                return;
            }

            $meja = Meja::find($mejaId);
            if (!$meja) return;

            $total = ($durasi / 60) * $meja->harga_per_jam;

            // Update total harga
            $set('total_harga', $total);

            // Update pembayaran otomatis
            $set('pembayaran.jumlah_bayar', $total);
        };

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
                        ->afterStateUpdated(fn ($state, $set, $get) =>
                            $updateTotalHarga($set, $get)
                        ),

                    TextInput::make('kode_booking')
                        ->label('Kode Booking')
                        ->default(fn () => 'BOOK-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT))
                        ->required(),

                    DatePicker::make('tanggal')
                        ->label('Tanggal Booking')
                        ->native(false)
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
                        ->afterStateUpdated(function ($state, $set, $get) use ($updateTotalHarga) {
                            $mulai = $state;
                            $selesai = $get('jam_selesai');

                            if ($mulai && $selesai) {
                                $hMulai = intval(explode(':', $mulai)[0]);
                                $hSelesai = intval(explode(':', $selesai)[0]);
                                $set('durasi_booking', ($hSelesai - $hMulai) * 60);
                            }

                            $updateTotalHarga($set, $get);
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
                        ->afterStateUpdated(function ($state, $set, $get) use ($updateTotalHarga) {
                            $mulai = $get('jam_mulai');

                            if ($mulai && $state) {
                                $hMulai = intval(explode(':', $mulai)[0]);
                                $hSelesai = intval(explode(':', $state)[0]);
                                $set('durasi_booking', ($hSelesai - $hMulai) * 60);
                            }

                            $updateTotalHarga($set, $get);
                        }),

                    TextInput::make('durasi_booking')
                        ->label('Durasi (menit)')
                        ->numeric()
                        ->required(),

                    TextInput::make('total_harga')
                        ->label('Total Harga')
                        ->prefix('Rp')
                        ->default(0)
                        ->afterStateUpdated(fn ($state, $set) =>
                            $set('pembayaran.jumlah_bayar', $state)
                        )
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(['.', ',']),

                ])->columns(2)->columnSpanFull(),

            Section::make('Pembayaran')
                ->description('Isi pembayaran jika pelanggan sudah bayar.')
                ->relationship('pembayaran')
                ->schema([

                    Select::make('jenis_pembayaran')
                        ->label('Jenis Pembayaran')
                        ->options([
                            'Cash' => 'Cash',
                            'Transfer' => 'Transfer',
                            'Qriz' => 'Qriz',
                        ])
                        ->native(false)
                        ->required(),

                    TextInput::make('jumlah_bayar')
                        ->label('Jumlah Bayar')
                        ->prefix('Rp')
                        ->numeric()
                        ->required(),

                    FileUpload::make('bukti_pembayaran')
                        ->label('Bukti Pembayaran')
                        ->directory('bukti_pembayaran')
                        ->image()
                        ->nullable()
                        ->columnSpanFull(),

                    Select::make('status')
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
