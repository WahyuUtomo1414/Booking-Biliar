<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pelanggan', \App\Models\Pelanggan::count())
                ->description('pelanggan')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Booking', \App\Models\Booking::count())
                ->description('booking')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format(
                    \App\Models\Booking::sum('total_harga'),
                    0, ',', '.'
                )
            )
                ->description('Total Transaksi Booking')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
