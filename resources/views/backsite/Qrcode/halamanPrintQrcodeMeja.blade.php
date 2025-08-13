<!DOCTYPE html>
<html>
<head>
    <title>Cetak QR - {{ $meja->nomor_meja }}</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                text-align: center;
                padding: 30px;
            }
        }

        .qr-box {
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 30px;
            margin: auto;
            width: fit-content;
            text-align: center;
            margin-top: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">

    <div class="container print-area ">
        <div class="qr-box bg-white">
            <h5 class="text-muted mb-3">Meja - {{ $meja->nomor_meja }}</h5>
            <div class="mb-3">
                {!! $qr !!}
            </div>
            <p class="text-muted small"><b>Scan QR-Code </b></p>
            <p class="text-muted small"> <i> {{ $meja->lokasi }} </i></p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
