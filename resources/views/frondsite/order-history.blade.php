<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>

</head>
<body>
    <h1>Order History</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Payment Status</th>
                <th>Expired At</th>
                <th>Transaction Time</th> 
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ tanggal_indo($order->waktu_pesan) }}</td>
                    <td>
                        @if ($order->transaction->transaction_status == 'PENDING')
                            Menunggu Pembayaran
                        @elseif ($order->transaction->transaction_status == 'PAID')
                            Berhasil
                        @elseif ($order->transaction->transaction_status == 'EXPIRED')
                            Kadaluarsa
                        @else
                            Gagal
                        @endif
                    </td>
                    <td>{{ $order->transaction->transaction_time }}</td>
                    <td>{{ $order->transaction->created_at }}</td>
                    <td>{{ 'Rp.' . number_format($order->transaction->gross_amount) }}</td>
                    <td><a href="{{ $order->transaction ? $order->transaction->invoice_url : '#' }}" target="_blank">Bayar Ulang</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>