@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-4 col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3">{{ $menu }}</h4>
                                <p class="mb-1">Total menu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6">
                        <div class="card h-100">
                            <div class="card-body">

                                <h4 class="card-title mb-3">{{ $user_data }}</h4>
                                <p class="mb-1">Total user</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6 ">
                        <div class="card h-100 ">
                            <div class="card-body">
                                <h4 class="card-title mb-3">{{ $meja }}</h4>
                                <p class="mb-1">Total meja</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between">
                                <div class="card-title mb-0">
                                    <h5 class="mb-1 me-2">Data Order</h5>
                                    <p class="card-subtitle">{{ 'Rp.' . number_format($total_order) }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-6">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <h3 class="mb-1 text-success">{{ $order }}</h3>
                                        <small>Total Orders</small>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 text-success text-center">{{ $order_item }}</h3>
                                        <small >Total item Orders</small>
                                    </div>

                                </div>
                                <ul class="p-0 m-0">
                                    @forelse ($kategori as $item)
                                        <li class="d-flex align-items-center mb-5">
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $item->nama }}</h6>
                                                    <small>-- Kategori</small>
                                                </div>
                                                <div class="user-progress">
                                                    <h6 class="mb-0"><b> {{ $item->menu_count }} </b><small>Menu</small>
                                                    </h6>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="d-flex align-items-center mb-5">
                                            <div>
                                                <p>Belum ada kategori</p>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Transaksi</h5>
                            </div>
                            <div class="card-body pt-4">
                                <ul class="p-0 m-0">
                                    <li class="d-flex align-items-center mb-6">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <h3><i class="bx bx-wallet-alt bg-danger"></i></h3>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="d-block">Pay</small>
                                                <h6 class="fw-normal mb-0">Online</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <h6 class="fw-normal mb-0">
                                                    <strong>{{ 'Rp.' . number_format($pembayaran_trans) }}</strong>
                                                </h6>
                                                <span class="text-body-secondary">IDN</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center mb-6">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <h3><i class="bx bx-wallet-alt bg-success"></i></h3>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="d-block">Tunai</small>
                                                <h6 class="fw-normal mb-0">Kasir</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <h6 class="fw-normal mb-0">
                                                    <strong>{{ 'Rp.' . number_format($pembayaran_tunai) }}</strong>
                                                </h6>
                                                <span class="text-body-secondary">IDN</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <h6>Status transaksi</h6>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p>-- <small class="badge text-bg-success">Sukses</small>
                                                        </p>
                                                        <h6></h6>
                                                        <h6>{{ $pembayaran_sukses }}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p>-- <small class="badge text-bg-warning">Menunggu</small>
                                                        </p>
                                                        <h6></h6>
                                                        <h6>{{ $pembayaran_menunggu }}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p>-- <small class="badge text-bg-danger">Gagal</small>
                                                        </p>
                                                        <h6></h6>
                                                        <h6>{{ $pembayaran_gagal }}</h6>
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
            </div>
        </div>
    </div>
    </div>
@endsection
