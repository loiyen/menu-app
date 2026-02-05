@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                        <a href="/dashboard-kasir" class="btn btn-sm btn-warning">Kembali</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6><i class="bx bx-cart" style="color: rgb(255, 208, 0)"></i> Informasi
                                                Pemesanan</h6>
                                            <hr>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Kode Pesanan</small>
                                                <small style="color: rgb(3, 3, 3)">ORD - {{ $order->order_id }}</small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Pembayaran</small>
                                                <small style="color: rgb(3, 3, 3)">
                                                    @if ($order->payment_status == 'paid')
                                                        <span class="badge text-bg-info">{{ $order->payment_status }}</span>
                                                    @elseif($order->payment_status == 'unpaid')
                                                        <span
                                                            class="badge text-bg-warning">{{ $order->payment_status }}</span>
                                                    @elseif($order->payment_status == 'failed')
                                                        <span
                                                            class="badge text-bg-danger">{{ $order->payment_status }}</span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Tanggal & Jam </small>
                                                <small>{{ tanggal_indo($order->created_at) }},
                                                    {{ format_jam($order->created_at) }}</small>
                                            </div>
                                            <hr>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Total Harga</small>
                                                <small
                                                    style="color: rgb(3, 3, 3)">{{ 'Rp' . number_format($order->total_harga) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-sm-6 mb-2">
                                    <div class="h-100">
                                        <div class="card-body">
                                            <h6 class=""><i class="bx bx-user" style="color: rgb(255, 208, 0)"></i>
                                                Informasi Pelanggan</h6>
                                            <hr>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Nama Pelanggan</small>
                                                <small style="color: rgb(3, 3, 3)">{{ $order->nama }}</small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Email</small>
                                                <small style="color: rgb(3, 3, 3)">root@gmail.com</small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>No.Handphone</small>
                                                <small style="color: rgb(3, 3, 3)">082250590837</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-sm-6 mb-2">
                                    <div class="h-100">
                                        <div class="card-body">
                                            <h6><i class="bx bx-chair" style="color: rgb(255, 208, 0)"></i> Informasi Meja
                                            </h6>
                                            <hr>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Nomor Meja</small>
                                                <small style="color: rgb(3, 3, 3)">{{ $order->meja->nomor_meja }}</small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Lokasi</small>
                                                <small style="color: rgb(3, 3, 3)">{{ $order->meja->lokasi }}</small>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between mb-1">
                                                <small>Tanggal & Jam</small>
                                                <small style="color: rgb(3, 3, 3)">{{ tanggal_indo($order->waktu_pesan) }},
                                                    {{ format_jam($order->waktu_pesan) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 mb-5">
                            <div class="mb-3 mt-3">
                                <h6><i class="bx bx-info-circle" style="color: rgb(255, 208, 0)"></i> Informasi Tambahan
                                </h6>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="text-muted mt-3"><i class="bx bx-info-circle"
                                                    style="color: rgb(255, 208, 0)"></i> Opsi Gula </h6>
                                            <small>{{ $order->opsi }}</small>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="text-muted mt-3"><i class="bx bx-info-circle"
                                                    style="color: rgb(255, 208, 0)"></i> Catatan </h6>
                                            <small>{{ $order->catatan }} </small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row g-4 ">

                        <div class="col-md-12 mb-">

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-0">
                                    <h6 class="mb-0"><i class="bx bx-list-plus" style="color: rgb(255, 208, 0)"></i>
                                        Item
                                        order</h6>
                                    <span class="badge rounded-pill text-bg-warning">{{ $total_item }}</span>
                                </div>
                                <hr>
                                <di class="row">
                                    @foreach ($order->items as $item)
                                        <div class="col mb-2">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <small><b>{{ $item->qty }}x</b> {{ $item->nama_menu }}
                                                        </small>
                                                        <small
                                                            style="color: black">{{ 'Rp' . number_format($item->sub_total) }}</small>
                                                    </div>
                                                    <small class="mb-3">Catatan :
                                                        <br>{{ $item->catatan_menu }}
                                                    </small>
                                                    <hr>
                                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                                        <small>Status Pesanan</small>
                                                        <small style="color: black">
                                                            @if ($item->status === 'siap')
                                                                <i class="bx bx-check-circle"
                                                                    style="color: rgb(0, 235, 67)"></i> Siap
                                                            @else
                                                                <i class="bx bx-timer" style="color: rgb(235, 161, 0)"></i>
                                                                Proses
                                                            @endif

                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </di>
                            </div>

                        </div>

                        <div class="row mb-1">
                            <h6><i class="bx bx-wallet" style="color: rgb(235, 161, 0)"></i> Informasi Pembayaran</h6>
                            <div class="col-md-6 col-lg-6 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <small>Nomor Order</small>
                                            <small style="color: black">ORD-{{ $order->order_id }}</small>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <small>Metode Pembayaran</small>
                                            <small style="color: black">{{ $order->pembayaran->metode }}</small>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <small>Status Pembayaran</small>
                                            <small style="color: black">
                                                @if ($order->pembayaran->status === 'menunggu')
                                                    <span class="badge bg-info">Menunggu</span>
                                                @elseif($order->pembayaran->status === 'lunas')
                                                    <span class="badge bg-success">Lunas</span>
                                                @else
                                                    <span class="badge bg-danger">Gagal</span>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <small>Tanggal & Jam</small>
                                            <small style="color: black"> {{ tanggal_indo($order->updated_at) }},
                                                {{ format_jam($order->updated_at) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <small>Sub total</small>
                                            <small
                                                style="color: black">{{ 'Rp' . number_format($order->total_harga) }}</small>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <small>Biaya lainya <br>PPN</small>
                                            <small style="color: black">Rp.4000</small>
                                        </div>
                                        <hr>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <small>Total </small>
                                            <small
                                                style="color: black">{{ 'Rp' . number_format($order->total_harga + 4000) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
