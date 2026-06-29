
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota #{{ $order->id }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
        }

        .receipt {
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .small {
            font-size: 11px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total {
            font-size: 15px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #000;
            font-size: 11px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 11px;
        }

        @media print {

            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .receipt {
                width: 80mm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="receipt">

        <div class="center">
            <div class="title">COFFEE SHOP</div>
            <div class="small">Jl. Contoh Alamat No. 123</div>
            <div class="small">Telp. 0812-3456-7890</div>
        </div>

        <div class="line"></div>

        <table class="table">
            <tr>
                <td>No Order</td>
                <td class="text-right">#{{ $order->id }}</td>
            </tr>

            <tr>
                <td>Tanggal</td>
                <td class="text-right">
                    {{ tanggal_indo($order->waktu_pesan) }}
                </td>
            </tr>

            <tr>
                <td>Jam</td>
                <td class="text-right">
                    {{ format_jam($order->waktu_pesan) }}
                </td>
            </tr>

            <tr>
                <td>Customer</td>
                <td class="text-right">
                    {{ $order->nama }}
                </td>
            </tr>

            <tr>
                <td>Meja</td>
                <td class="text-right">
                    {{ $order->meja->nomor_meja ?? '-' }}
                </td>
            </tr>
        </table>

        <div class="line"></div>

        <table class="table">

            @foreach ($order->items as $item)
                <tr>
                    <td colspan="2">
                        <strong>{{ $item->menu->nama ?? $item->nama_menu }}</strong>
                    </td>
                </tr>

                <tr>
                    <td>
                        {{ $item->qty }} x
                        Rp {{ number_format($item->sub_total / $item->qty, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($item->sub_total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach

        </table>

        <div class="line"></div>

        @php
            $subtotal = $order->total_harga - 4000;
            $ppn = 4000;
        @endphp

        <table class="table">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td>PPN</td>
                <td class="text-right">
                    Rp {{ number_format($ppn, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div class="line"></div>

        <table class="table">
            <tr class="total">
                <td>TOTAL</td>
                <td class="text-right">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="center">
            <div class="status">
                {{ strtoupper($order->payment_status ?? 'UNPAID') }}
            </div>
        </div>

        @if ($order->catatan)
            <div class="line"></div>

            <strong>Catatan :</strong>
            <div class="small">
                {{ $order->catatan }}
            </div>
        @endif

        <div class="footer">
            <p>Terima Kasih</p>
            <p>Selamat Menikmati ☕</p>
        </div>

    </div>

</body>

</html>
