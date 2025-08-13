@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">

                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <a href="/order" class="btn btn-sm btn-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12 mb-5">
                            <div class="h-100">
                                <h6 class="card-title text-center">Transaksi</h6>
                                <div class="table-responsive text-nowrap mb-2">
                                    <table class="table table-borderless table-sm">
                                        <thead>
                                            <tr>
                                                <td><strong>Order id</strong></td>
                                                <td>:</td>
                                                <td><b class="text-warning">{{ $order->order_id }}</td>
                                            </tr>
                                          
                                            <tr>
                                                <td>Total harga</td>
                                                <td>:</td>
                                                <td>{{ 'Rp.' . number_format($order->total_harga) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal</td>
                                                <td>:</td>
                                                <td>{{ tanggal_indo($order->waktu_pesan) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jam</td>
                                                <td>:</td>
                                                <td>{{ format_jam($order->waktu_pesan) }}</td>
                                            </tr>

                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-5">
                            <div class="h-100">
                                <h6 class="card-title text-center">Meja</h6>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-borderless table-sm">
                                        <thead>
                                              <tr>
                                                <td><strong>Nama</strong></td>
                                                <td>:</td>
                                                <td><strong>{{ $order->nama }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Nomor meja</td>
                                                <td>:</td>
                                                <td>{{ $order->meja->nomor_meja }}</td>
                                            </tr>
                                            <tr>
                                                <td>Lokasi</td>
                                                <td>:</td>
                                                <td>{{ $order->meja->lokasi }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
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
                        <div class="col-md-12 col-sm-12 mb-5">

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="text-muted mt-3">Opsi gula : </h6>
                                            <p>* {{ $order->opsi }}</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="text-muted mt-3">Catatan : </h6>
                                            <p>{{ $order->catatan }} </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row g-4 ">

                        <div class="col-md-7 mb-">
                            <div class="card h-100">
                                <div class="card-header  bg-primary d-flex justify-content-between align-items-center mb-0">
                                    <h6 class="mb-0 text-white">Item order</h6>
                                    <span class="badge rounded-pill text-bg-info">{{ $total_item }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Menu</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->menu->nama ?? 'Menu tidak ditemukan' }}</td>
                                                        <td class="text-center">{{ $item->qty }}</td>
                                                        <td>{{ 'Rp.' . number_format($item->sub_total) }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card h-100">
                                <div class="card-header  bg-primary d-flex justify-content-between align-items-center mb-0">
                                    <h6 class="mb-0 text-white">Pembayaran</h6>
                                    @if ($order->pembayaran->status == 'menunggu')
                                        <span
                                            class="badge rounded-pill text-bg-danger">{{ $order->pembayaran->status }}</span>
                                    @elseif($order->pembayaran->status == 'lunas')
                                        <span
                                            class="badge rounded-pill text-bg-danger">{{ $order->pembayaran->status }}</span>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-dark">{{ $order->pembayaran->status }}</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Metode</td>
                                                    <td>:</td>
                                                    <td>{{ $order->pembayaran->metode }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>:</td>
                                                    <td><b>{{ 'Rp.' . number_format($order->pembayaran->jumlah_bayar) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>:</td>
                                                    <td>{{ tanggal_indo($order->pembayaran->waktu_bayar) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jam</td>
                                                    <td>:</td>
                                                    <td>{{ format_jam($order->pembayaran->waktu_bayar) }}</td>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                    <a href="{{ route('detail.pembayaran', $order->pembayaran->id) }}" class="col-12 btn btn-primary btn-sm">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- <div class="col-md-4 mt-4">
                        </div> --}}
                        <div class="col-md-12 mt-4">
                            <div class="card-header bg-warning d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-white">Detail pembelian </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-borderless table-sm">
                                        <thead>
                                            <tr>
                                                <td>Customer</td>
                                                <td></td>
                                                <td></td>
                                                <td>:</td>
                                                <td><b>{{ $order->nama }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Sub total</td>
                                                <td></td>
                                                <td></td>
                                                <td>:</td>
                                                <td>{{ 'Rp.' . number_format($order->total_harga) }}</td>
                                            </tr>
                                            <tr>
                                                <td>PPN</td>
                                                <td></td>
                                                <td></td>
                                                <td>:</td>
                                                <td>Rp. 4000</td>
                                            </tr>
                                            <tr class="bg-dark ">
                                                <td class="text-white"><b>Bayar</b></td>
                                                <td></td>
                                                <td></td>
                                                <td>:</td>   
                                                <td class="text-white"><b>{{ 'Rp.' . number_format($order->total_harga + 4000) }}</b></td>
                                            </tr>
                                            

                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
