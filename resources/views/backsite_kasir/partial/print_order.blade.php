<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        .struk-container {
            width: 310px;
            margin: auto;
            font-size: 14px;
            border: 1px dashed #000;
            padding: 10px;
        }

        .struk-header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .struk-footer {
            text-align: center;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        table td,
        table th {
            padding: 4px;
        }
    </style>
</head>

<body>

    <div class="struk-container">
        <div class="struk-header">
            <h6>Coffee Shop 123</h6>
            <small>Jl. Contoh No. 123, Jakarta</small><br>
            <small>Telp: 0812-3456-7890</small>
        </div>
        <p class="mb-0"><strong>No Order:</strong> {{ $order->order_id }}</p>
        <p class="mb-0"><strong>Meja:</strong> {{ $order->meja->nomor_meja }} - <i>{{ $order->meja->lokasi }}</i></p>
        <p class="mb-3"><strong>Tanggal / Jam:</strong> {{ tanggal_indo($order->waktu_pesan) }} -
            {{ format_jam($order->waktu_pesan) }}</p>

        <table class="table table-sm table-borderless">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->nama_menu }}</td>
                        <td class="text-end">{{ $item->qty }}</td>
                        <td class="text-end">{{ 'Rp.' . number_format($item->menu->harga) }}</td>
                        <td class="text-end">{{ 'Rp.' . number_format($item->sub_total) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Harga:</strong></td>
                    <td class="text-end">{{ 'Rp.' . number_format($order->total_harga) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>PPN:</strong></td>
                    <td class="text-end">Rp.4000</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end">{{ 'Rp.' . number_format($order->total_harga + 4000) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Bayar:</strong></td>
                    <td class="text-end">{{ 'Rp.' . number_format($order->pembayaran->jumlah_bayar) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end"><strong>Kembalian:</strong></td>
                    <td class="text-end">{{ 'Rp.' . number_format($order->pembayaran->kembalian) }}</td>
                </tr>
                {{-- 
                 --}}
            </tfoot>
        </table>
        <hr>
        <div class="">
            <p class="mb-1"><strong>WIFI : JOSS11</strong></p>
            <small>Password123</small>
        </div>

        <div class="struk-footer">
            <p>Terima kasih!</p>
            <small>~ Semoga harimu menyenangkan ~</small>
        </div>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>
