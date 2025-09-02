@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-md-12 ">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Riwayat Pesanan</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-3 m-2 product-item">
            <a href="/detail-riwayat" class="text-decoration-none">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div>
                            <h6><span><i class="fa fa-cutlery" style="color: rgb(255, 208, 0)"></i></span> Pesanan <br>
                                <small class="" style="color: rgb(162, 162, 162)">17 Agustus 2025, 08 : 20</small>
                            </h6>
                        </div>
                        <div>
                            <span class="badge bg-primary" style="">Menunggu</span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6>A.n Loiyen</h6>
                        </div>
                        <div>
                            <span>#ORD-352SRRYE</span>
                        </div>
                    </div>
                    <div class="d-flex mb-2 align-items-center justify-content-between">
                        <div>
                            <span>Total : <br><b>Rp200,000</b></span>
                        </div>
                        <div>
                            <span>Status : <br><b style="color: rgb(31, 205, 0)">Berhasil</b></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col mb-3 m-2 product-item">
            <a href="" class="text-decoration-none">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div>
                            <h6><span><i class="fa fa-cutlery" style="color: rgb(255, 208, 0)"></i></span> Pesanan <br>
                                <small class="" style="color: rgb(162, 162, 162)">17 Agustus 2025, 08 : 20</small>
                            </h6>
                        </div>
                        <div>
                            <span class="badge bg-primary" style="">Menunggu</span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <h6>A.n Loiyen</h6>
                        </div>
                        <div>
                            <span>#ORD-352SRRYE</span>
                        </div>
                    </div>
                    <div class="d-flex mb-2 align-items-center justify-content-between">
                        <div>
                            <span>Total : <br><b>Rp200,000</b></span>
                        </div>
                        <div>
                            <span>Status : <br><b style="color: rgb(31, 205, 0)">Berhasil</b></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        

        

    </div>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
