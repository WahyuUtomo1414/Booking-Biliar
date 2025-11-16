<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingPrintController extends Controller
{
    public function print($id)
    {
        $booking = Booking::with(['pelanggan', 'meja', 'pembayaran'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.booking', [
            'booking' => $booking
        ])->setPaper('A4');

        return $pdf->stream("booking-$booking->kode_booking.pdf");
    }
}
