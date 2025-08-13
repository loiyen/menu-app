@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <a href="/pembayaran" class="btn btn-sm btn-warning text-white">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                    <div></div>
                                    <button class="btn btn-danger btn-sm"><i class='bx bx-printer'></i></button>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <div></div>
                                        <h6 class="">Kode : <i> {{ $detail->order->order_id }} </i></h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">Riwayat order</h6>
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-borderless table-sm">
                                                        <thead>

                                                            <tr>
                                                                <td>Tanggal</td>
                                                                <td>:</td>
                                                                <td>{{ tanggal_indo($detail->waktu_bayar) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jam</td>
                                                                <td>:</td>
                                                                <td>{{ format_jam($detail->waktu_bayar) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Status pesanan</td>
                                                                <td>:</td>
                                                                <td>
                                                                    @if ($order->status == 'menunggu')
                                                                        <span
                                                                            class="badge rounded-pill text-bg-primary">{{ $order->status }}</span>
                                                                    @elseif($order->status == 'diproses')
                                                                        <span
                                                                            class="badge rounded-pill text-bg-warning">{{ $order->status }}</span>
                                                                    @elseif($order->status == 'selesai')
                                                                        <span
                                                                            class="badge rounded-pill text-bg-success">{{ $order->status }}</span>
                                                                    @elseif($order->status == 'dibatalkan')
                                                                        <span
                                                                            class="badge rounded-pill text-bg-dark">{{ $order->status }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">Pembayaran -
                                                    @if ($detail->metode == 'tunai')
                                                        <span class="badge text-bg-primary">{{ $detail->metode }}</span>
                                                    @elseif($detail->metode == 'transfer')
                                                        <span class="badge text-bg-info">{{ $detail->metode }}</span>
                                                    @endif
                                                </h6>
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-borderless table-sm">
                                                        <thead>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td>:</td>
                                                                <td>{{ 'Rp.' . number_format($detail->jumlah_bayar) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bayar</td>
                                                                <td>:</td>
                                                                <td>Rp. - </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kembalian</td>
                                                                <td>:</td>
                                                                <td>Rp. - </td>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="mb-5 card-title">Detail item</h6>
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nama</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($item as $items)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $items->nama_menu }}</td>
                                                                        <td>{{ $items->qty }}</td>
                                                                        <td>{{ 'Rp. ' . number_format($items->sub_total) }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <thead>
                                                                <tr class="bg-dark text-white">
                                                                    <td class="text-white">Total</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td class="text-white">
                                                                        {{ 'Rp.' . number_format($order->total_harga) }}
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h6 class="mb-5 card-title text-center"><i>Status :
                                                            @if ($detail->status == 'lunas')
                                                                <span
                                                                    class="badge bg-label-success">{{ $detail->status }}</span>
                                                            @elseif($detail->status == 'menunggu')
                                                                <span
                                                                    class="badge bg-label-primary">{{ $detail->status }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-label-danger">{{ $detail->status }}</span>
                                                            @endif
                                                        </i>
                                                    </h6>
                                                    @if ($detail->status == 'lunas')
                                                        <div class="text-center">
                                                            <img class=" mt-5" width="70"
                                                                src="{{ asset('images/done.png') }}" alt="">
                                                        </div>
                                                    @elseif($detail->status == 'menunggu')
                                                        <div class="text-center">
                                                            <img class=" mt-5" width="70"
                                                                src="{{ asset('images/tunggu.png') }}" alt="">
                                                        </div>
                                                    @else
                                                        <div class="text-center">
                                                            <img class=" mt-5" width="70"
                                                                src="{{ asset('images/gagal.png') }}" alt="">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
