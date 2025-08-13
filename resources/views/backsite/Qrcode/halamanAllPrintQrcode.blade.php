<!DOCTYPE html>
<html>

<head>
    <title>Cetak Semua QR-code</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 30px;
            }
        }

        .qr-card {
            border: 1px solid #dee2e6;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.2s;
        }

        .qr-card:hover {
            transform: scale(1.02);
        }

        .qr-title {
            font-weight: bold;
            color: #495057;
        }

        .qr-subtext {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-4 print-area">
        <div class="row">
            @foreach ($meja as $item)
                <div class="col-md-4">
                    <div class="qr-card">
                        <h6 class="qr-title">Meja - {{ $item->nomor_meja }}</h6>
                        <div class="my-3">
                            {!! QrCode::size(150)->generate(url('/pesan/meja/' . $item->nomor_meja)) !!}
                        </div>
                        <p class="qr-subtext"><strong>Scan QR-Code</strong></p>
                        <p class="qr-subtext"><i>{{ $item->lokasi }}</i></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script> window.print(); </script>
</body>

</html>
