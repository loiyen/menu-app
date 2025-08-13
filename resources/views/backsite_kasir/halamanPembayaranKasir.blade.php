@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="/dashboard-kasir" class="btn btn-sm btn-warning">Kembali</a>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                    <div>
                        <h6>Customer : <br> <strong> {{ $order->nama }}</strong> </h6>
                    </div>
                    <div>
                        <h6>Kode : <br> <strong>{{ $order->order_id }}</strong></h6>
                    </div>
                </div>
                @if ($order->pembayaran->status == 'lunas')
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="alert text-center alert-success alert-dismissible mb-0" role="alert">
                                Pembayaran telah diterima!
                            </div>
                        </div>
                    </div>
                @else
                @endif

                <div class="row mb-4">
                    <div class="col-md-8 col-lg-8 col-sm-12">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_menu }}</td>
                                            <td>{{ 'Rp.' . number_format($item->menu->harga) }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class="bg-dark">
                                        <td class="text-white"><strong>Total</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-white">
                                            <strong>{{ 'Rp.' . number_format($order->total_harga) }}</strong>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="col-sm-12 mt-4">
                            @if ($order->pembayaran->status == 'menunggu')
                                <button class="btn btn-outline-success" disabled>
                                    <h6 class="mt-5 text-center"><i class="bx bx-printer"></i> Cetak</h6>
                                </button>
                            @else
                                <a href="{{ route('print.notakasir', $order->id) }}" class="btn btn-outline-success">
                                    <h6 class="mt-5 text-center"><i class="bx bx-printer"></i> Cetak</h6>
                                </a>
                            @endif

                            <a href="{{ route('detail.kasir', $order->id) }}" class="btn btn-warning">
                                <h6 class="mt-5 text-white text-center"><i class="bx bx-info-circle"></i> Detail</h6>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">* Detail</h6>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-sm table-borderless ">
                                                <thead>
                                                    <tr>
                                                        <td>Total item</td>
                                                        <td>:</td>
                                                        <td>{{ $total_item }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total harga</td>
                                                        <td>:</td>
                                                        <td>{{ 'Rp.' . number_format($order->total_harga) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>* PPN</b></td>
                                                        <td>:</td>
                                                        <td><b>Rp.4000</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>* Total bayar</b></td>
                                                        <td>:</td>
                                                        <td><b>{{ 'Rp.' . number_format($order->total_harga + 4000) }}</b>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">* Pembayaran</h6>
                                        <div class="mt-2 mb-4">
                                            <label for="largeInput" class="form-label">Total</label>
                                            <input id="largeInput" class="form-control" type="text"
                                                placeholder="Masukan nominal bayar..."
                                                value="{{ 'Rp.' . number_format($order->total_harga + 4000) }}" />
                                        </div>
                                        <form action="{{ route('pembayaran.update', $order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="mt-2 mb-4">
                                                <label for="inputBayar" class="form-label">Bayar</label>
                                                <input id="inputBayar" class="form-control form-control-lg" type="text"
                                                    placeholder="Masukan nominal bayar..." />

                                                <input id="nominalBersih" name="nominal_bayar" type="hidden">

                                                <input name="total_harga" value="{{ $order->total_harga + 4000 }}"
                                                    type="hidden">

                                                @error('nominal_bayar')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div>
                                                <button class="col-12 btn btn-primary"
                                                    {{ $order->pembayaran->status == 'lunas' ? 'disabled' : '' }}>
                                                    Bayar
                                                </button>
                                            </div>
                                        </form>

                                        <script>
                                            function formatRupiahInput(inputId, hiddenInputId) {
                                                const inputEl = document.getElementById(inputId);
                                                const hiddenEl = document.getElementById(hiddenInputId);

                                                if (inputEl) {
                                                    inputEl.addEventListener('input', function(e) {
                                                        let value = e.target.value.replace(/[^0-9]/g, '');
                                                        e.target.value = value ? new Intl.NumberFormat('id-ID', {
                                                            style: 'currency',
                                                            currency: 'IDR',
                                                            minimumFractionDigits: 0
                                                        }).format(value) : '';

                                                        if (hiddenEl) {
                                                            hiddenEl.value = value;
                                                        }
                                                    });
                                                }
                                            }
                                            formatRupiahInput('inputBayar', 'nominalBersih');
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
