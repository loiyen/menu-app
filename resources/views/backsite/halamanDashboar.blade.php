@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 order-1">
                <div class="row">

                    <div class="col-lg-6 col-md-12 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <small class="mb-3">Saldo anda</small>
                                <h4 class="mb-2 fw-bold">{{ 'Rp' . number_format($pendapatan) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <small class="mb-1">Total Menu</small>
                                <h4 class="mb-2 fw-bold">{{ $menu }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 mb-6 ">
                        <div class="card h-100 ">
                            <div class="card-body">
                                <small class="mb-1">Total Meja</small>
                                <h4 class="mb-2 fw-bold">{{ $meja }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 mb-6 ">
                        <div class="card h-100 ">
                            <div class="card-body">
                                <small class="mb-1">Total user</small>
                                <h4 class="mb-2 fw-bold">{{ $user_data }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between">
                                <h6 class="mb-1 me-2">Pemesanan</h6>
                                <small class="card-subtitle"></small>
                            </div>
                            <div class="card-body">
                                <div class="card mb-5">
                                    <div class="card-body">
                                        <small>Total pendapat</small>
                                        <h4 class="text-success">{{ 'Rp'.number_format($total_order) }} </h4>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-6">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <h4 class="mb-1">{{ $order }}</h4>
                                        <small>Total Orders</small>
                                    </div>
                                    <div>
                                        <h4 class="mb-1  text-center">{{ $order_item }}</h4>
                                        <small>Total item Orders</small>
                                    </div>
                                    <div>
                                        <h4 class="mb-1  text-center">{{ $paid }}</h4>
                                        <small>Paid</small>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-center">{{ $expired }}</h4>
                                        <small>Expired</small>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h6 class="card-title m-0 me-2">Kategori</h6>
                            </div>

                            <div class="card-body">
                                <ul class="p-0 m-0">
                                    @forelse ($kategori as $item)
                                        <li class="d-flex align-items-center mb-5">
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <p class="mb-0 fw-bold">{{ $item->nama }}</p>
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
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
