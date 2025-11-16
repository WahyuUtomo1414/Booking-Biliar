<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingPrintController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/booking/{id}/print', [BookingPrintController::class, 'print'])
    ->name('booking.print');
