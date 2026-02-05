@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-md-12 ">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex  my-1">
                    <a href="/riwayat-pesanan"><i class="fa fa-arrow-left mt-0 m-2"></i></a>
                    <h6 class="mt-2">Detail Pesanan</h6>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card-body product-item">
                <div class="tabs-header d-flex justify-content-center my-1 mb-3 mt-2">
                    <h6><span><i class="fa fa-check-circle" style="color: rgb(0, 219, 11)" aria-hidden="true"></i></span>
                        Pesanan Selesai</h6>
                </div>
                <div class="mt-0">
                    <small>No. Pesanan : <span style="color: rgb(56, 56, 56)"><br>{{ $orders->transaction->xendit_external_id }}</span> </small>
                    <div class="d-flex align-conten-center justify-content-between">
                        <small>Tanggal Pembelian : <span style="color: rgb(56, 56, 56)"><br>{{ tanggal_indo($orders->waktu_pesan) }},
                            {{ format_jam($orders->waktu_pesan) }}</span></small>
                        <small style="color: rgb(56, 56, 56)"> </small>
                    </div>
                </div>
                <hr>
                <div>
                    <small>Catatan : <br>{{ $orders->catatan ?? '-' }}</small>

                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="bootstrap-tabs product-tabs ">
                    <h6>Detail Menu ({{ $total_item }})</h6>
                    <hr>
                    @foreach ($orders->items as $item)
                        <div class="product-item mb-1">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <img src="{{ asset('storage/'. $item->menu->gambar) }}" width="60px" height="50px"  alt="">
                                </div>
                                <h6>{{ $item->nama_menu }}<br><small style="color: rgb(125, 125, 125)">Jml: {{ $item->qty }}</small></h6>
                                <span></span>
                                <span>{{ 'Rp'.number_format($item->harga) }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <small>Status Pesanan : </small>
                                @if ($item->status === 'proses')
                                    <small class="badge" style="background-color: rgb(244, 0, 0)"> Sedang di proses</small>
                                @else
                                    <small class="badge" style="background-color: rgb(11, 216, 0)">Selesai</small>
                                @endif
                               
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs ">
                    <h6>Rincian Pembayaran</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>Metode Pembayaran</small>
                        <small>{{ $orders->transaction->payment_type }}</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>Sub Total Harga </small>
                        <small>{{ 'Rp'.number_format($orders->total_harga) }}</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>PPN</small>
                        <small>Rp4,000</small>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6>Total</h6>
                        <h6 style="color: brown"><b>{{ 'Rp'.number_format($orders->transaction->gross_amount + 4000) }}</b></h6>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="bootstrap-tabs product-tabs ">
                    <a href="/" class="col-12 btn btn-primary fw-bold">Pesan lagi</a>
                </div>
            </div>
        </div>
    </div>
@endsection
