@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-md-12 ">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/riwayat-pesanan"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Riwayat Pesanan</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3 ">
            <div class="card-body  product-item">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <h6><span><i class="fa fa-check-circle" style="color: rgb(0, 219, 11)" aria-hidden="true"></i></span>
                        Pesanan Selesai</h6>
                </div>
                <div class="mt-0">
                    <small>No. Pesanan : <span style="color: rgb(56, 56, 56)">ORD-24141241</span> </small>
                    <div class="d-flex align-conten-center justify-content-between">
                        <small>Tanggal Pembelian</small>
                        <small style="color: rgb(56, 56, 56)">17 Agustus 2025, 08:20 </small>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="bootstrap-tabs product-tabs ">
                    <h6>Detail Menu (4)</h6>
                    <hr>
                    <div class="product-item mb-1">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <img src="{{ asset('images/product-thumb-1.png') }}" width="35px" alt="">
                            </div>
                            <h6>Mie<br><small style="color: rgb(125, 125, 125)">Jml: 1</small></h6>
                            <span></span>
                            <span>Rp20,000</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <small>Status Pesanan : </small>
                            <small class="badge bg-primary">Siap</small>
                        </div>
                    </div>
                    <div class="product-item mb-1">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <img src="{{ asset('images/product-thumb-1.png') }}" width="35px" alt="">
                            </div>
                            <h6>Mie<br><small style="color: rgb(125, 125, 125)">Jml: 1</small></h6>
                            <span></span>
                            <span>Rp20,000</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <small>Status Pesanan : </small>
                            <small class="badge bg-primary">Siap</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs ">
                    <h6>Rincian Pembayaran</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>Metode Pembayaran</small>
                        <small>QRIS</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>Sub Total Harga </small>
                        <small>Rp20,000</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>PPN</small>
                        <small>Rp4,000</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <small>Sub Total</small>
                        <small>Rp24,000</small>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6>Total</h6>
                        <h6>Rp24,000</h6>
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
