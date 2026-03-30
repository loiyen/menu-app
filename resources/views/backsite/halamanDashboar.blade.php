@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 order-1 mb-5">
                <div class="row g-3">

                    <!-- SALDO -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">

                                <div>
                                    <small class="text-muted">Saldo Anda</small>
                                    <h4 class="fw-bold mb-0">
                                        Rp{{ number_format($pendapatan) }}
                                    </h4>
                                </div>

                                <div class="bg-success-subtle rounded-3 p-3">
                                    <!-- ICON MONEY -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" class="text-success">
                                        <path d="M10 10h4v2h-4z" />
                                        <path fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm2 0h12v8H4V6z" />
                                    </svg>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- MENU -->
                    <div class="col-lg-2 col-md-4 col-sm-4">
                        <div class="card border-0 shadow-sm rounded-4 text-center">
                            <div class="card-body">

                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="text-primary">
                                        <path d="M4 3h12v2H4zM4 7h12v2H4zM4 11h12v2H4z" />
                                    </svg>
                                </div>

                                <small class="text-muted">Total Menu</small>
                                <h5 class="fw-bold mb-0">{{ $menu }}</h5>

                            </div>
                        </div>
                    </div>

                    <!-- MEJA -->
                    <div class="col-lg-2 col-md-4 col-sm-4">
                        <div class="card border-0 shadow-sm rounded-4 text-center">
                            <div class="card-body">

                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="text-warning">
                                        <path d="M3 10h18v2H3z" />
                                        <path d="M5 12v5h2v-5H5zm12 0v5h2v-5h-2z" />
                                    </svg>
                                </div>

                                <small class="text-muted">Total Meja</small>
                                <h5 class="fw-bold mb-0">{{ $meja }}</h5>

                            </div>
                        </div>
                    </div>

                    <!-- USER -->
                    <div class="col-lg-2 col-md-4 col-sm-4">
                        <div class="card border-0 shadow-sm rounded-4 text-center">
                            <div class="card-body">

                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="text-info">
                                        <path fill-rule="evenodd"
                                            d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>

                                <small class="text-muted">Total User</small>
                                <h5 class="fw-bold mb-0">{{ $user_data }}</h5>

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
                                        <h4 class="text-success">{{ 'Rp' . number_format($total_order) }} </h4>
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
                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <!-- HEADER -->
                            <div
                                class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Kategori</h6>

                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="text-muted">
                                    <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z" />
                                </svg>
                            </div>

                            <!-- BODY -->
                            <div class="card-body">

                                <ul class="list-unstyled m-0">

                                    @forelse ($kategori as $item)
                                        <li class="d-flex align-items-center justify-content-between mb-3">

                                            <!-- LEFT -->
                                            <div class="d-flex align-items-center gap-2">

                                                <!-- ICON -->
                                                <div class="bg-light rounded-3 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="text-primary">
                                                        <path d="M4 4h16v16H4zM2 2h20v20H2z" />
                                                    </svg>
                                                </div>

                                                <div>
                                                    <div class="fw-semibold">{{ $item->nama }}</div>
                                                    <small class="text-muted">Kategori</small>
                                                </div>

                                            </div>

                                            <!-- RIGHT -->
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                {{ $item->menu_count }} Menu
                                            </span>

                                        </li>
                                    @empty

                                        <!-- EMPTY STATE -->
                                        <li class="text-center py-4">

                                            <div class="mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    fill="currentColor" class="text-muted">
                                                    <path d="M4 4h16v16H4zM2 2h20v20H2z" />
                                                </svg>
                                            </div>

                                            <div class="text-muted">
                                                Belum ada kategori
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
