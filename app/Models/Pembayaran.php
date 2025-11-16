<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'pembayaran';
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
