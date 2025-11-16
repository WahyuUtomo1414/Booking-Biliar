<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Print Booking</title>
      <style>
         body { font-family: sans-serif; font-size: 14px; }
         .header { display: flex; align-items: center; margin-bottom: 10px; }
         .logo { width: 70px; }
         .title { text-align: center; width: 100%; margin-top: -40px; font-size: 20px; font-weight: bold; }
         
         .section-title { font-size: 16px; margin: 20px 0 10px; font-weight: bold; }
         .row { display: flex; width: 100%; }
         .col-left { width: 55%; }
         .col-right { width: 45%; }

         .item { margin-bottom: 6px; }.label {
               font-weight: bold;
               display: inline-block;
               width: 140px; /* atur sesuai panjang maksimal key */
            }
         .label { font-weight: bold; }

         .record-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
         }

         .record-table th {
            background: #adbcff;
            text-align: left;
            padding: 6px 8px;
            font-weight: bold;
            border: 1px solid #ddd;
         }

         .record-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
         }
      </style>
   </head>
   <body>

      <!-- Header -->
      <div style="text-align: center; margin-bottom: 15px;">
         <img src="{{ public_path('images/logo_biliar.png') }}" 
               style="width: 120px; margin-bottom: 10px;">
         <div style="font-size: 22px; font-weight: bold; margin-top: 10px;">
            Booking Billiard
         </div>
      </div>


      <br>

      <!-- Content Row -->
      <div class="row">

         <!-- LEFT: DATA BOOKING -->
         <div class="col-left">
            <div class="section-title">Data Booking</div>
            <br>

            <div class="item"><span class="label">Kode Booking </span> : {{ $booking->kode_booking }}</div>
            <div class="item"><span class="label">Pelanggan </span> : {{ $booking->pelanggan->nama }}</div>
            <div class="item"><span class="label">Nomor Wa </span> : {{ $booking->pelanggan->nomor_wa }}</div>
         </div>

         <table class="record-table">
            <tr>
               <th>Meja</th>
               <th>Kode Booking</th>
               <th>Tanggal</th>
               <th>Jam Mulai</th>
               <th>Jam Selesai</th>
               <th>Durasi</th>
               <th>Total Harga</th>
            </tr>
            <tr>
               <td>{{ $booking->meja->nama }} – {{ $booking->meja->tipe }}</td>
               <td>{{ $booking->kode_booking }}</td>
               <td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('M d, Y') }}</td>
               <td>{{ $booking->jam_mulai }}</td>
               <td>{{ $booking->jam_selesai }}</td>
               <td>{{ $booking->durasi_booking }} Menit</td>
               <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
            </tr>
         </table>

         <br>

         <!-- RIGHT: DATA PEMBAYARAN -->
         <div class="col-right">
            <div class="section-title">Pembayaran</div>

            <table class="record-table">
               <tr>
                  <th>Jenis Pembayaran</th>
                  <th>Jumlah Bayar</th>
                  <th>Status</th>
               </tr>
               <tr>
                  <td>{{ $booking->pembayaran->jenis_pembayaran }}</td>
                  <td>Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                  <td>{{ ucfirst($booking->pembayaran->status) }}</td>
               </tr>
            </table>
         </div>

      </div>

      <br>
      <br>
      <br>

      <br>
      <br>
      <br>

      <!-- Footer -->
      <div style="text-align: center; margin-bottom: 15px;">
         <img src="{{ public_path('images/pikka_code.png') }}" 
               style="width: 120px; margin-bottom: 10px;">
         <div style="font-size: 22px; font-weight: bold; margin-top: 10px;">
            Terima Kasih
         </div>
      </div>

   </body>
</html>
