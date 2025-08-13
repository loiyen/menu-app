@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
               
                <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                    <div>
                        <h6>Customer : <br> <strong> {{ $order->nama }}</strong> </h6>
                    </div>
                    <div>
                        <h6>Kode : <br> <strong>{{ $order->order_id }}</strong></h6>
                    </div>
                </div>
                <div>
                    <p>Metode : <b>{{ $order->pembayaran->metode }}</b></p>
                    <p>Tanggal & Jam : {{ tanggal_indo($order->pembayaran->waktu_bayar) }} -
                        {{ format_jam($order->pembayaran->waktu_bayar) }} </p>

                </div>
                <div>
                    <h6 class="text-center">Kembalian :</h6>
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <h3 class="text-center mt-2">{{ 'Rp.' . number_format($order->pembayaran->kembalian) }}</h3>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-6">
                            <a href="/dashboard-kasir" class="col-12 btn btn-warning">Selesai</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('print.notakasir', $order->id) }}" class="col-12 btn btn-outline-success"><i
                                    class="bx bx-printer bx-lg"></i> - <span>Cetak</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
