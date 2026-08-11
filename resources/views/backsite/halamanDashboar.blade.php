@extends('backsite.layout.main')

@section('container')
    <style>
        .dashboard-page {
            background:
                radial-gradient(circle at top left, rgba(105, 108, 255, .12), transparent 34%),
                radial-gradient(circle at top right, rgba(40, 199, 111, .10), transparent 30%),
                #f7f8fc;
            min-height: 100vh;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, #111827 0%, #1f2937 45%, #2563eb 100%);
            border-radius: 28px;
            padding: 28px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(17, 24, 39, .18);
        }

        .dashboard-hero::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            right: -80px;
            top: -120px;
        }

        .dashboard-hero::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            left: 35%;
            bottom: -110px;
        }

        .dashboard-hero-content {
            position: relative;
            z-index: 2;
        }

        .dashboard-card {
            border: 0;
            border-radius: 24px;
            background: rgba(255, 255, 255, .95);
            box-shadow: 0 14px 36px rgba(15, 23, 42, .07);
            transition: .22s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 44px rgba(15, 23, 42, .11);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-lg {
            width: 60px;
            height: 60px;
            border-radius: 20px;
        }

        .metric-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .metric-value {
            color: #0f172a;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .soft-primary {
            background: rgba(105, 108, 255, .12);
            color: #696cff;
        }

        .soft-success {
            background: rgba(40, 199, 111, .13);
            color: #28c76f;
        }

        .soft-warning {
            background: rgba(255, 171, 0, .15);
            color: #ffab00;
        }

        .soft-info {
            background: rgba(0, 207, 232, .14);
            color: #00bad1;
        }

        .soft-danger {
            background: rgba(234, 84, 85, .12);
            color: #ea5455;
        }

        .order-summary-box {
            border: 1px solid rgba(148, 163, 184, .18);
            border-radius: 20px;
            padding: 18px;
            background: #f8fafc;
        }

        .category-item {
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 18px;
            padding: 14px;
            transition: .2s ease;
            background: #fff;
        }

        .category-item:hover {
            background: #f8fafc;
            border-color: rgba(105, 108, 255, .28);
        }

        .progress-modern {
            height: 10px;
            border-radius: 999px;
            background: #eef2f7;
            overflow: hidden;
        }

        .progress-modern .progress-bar {
            border-radius: 999px;
        }

        @media (max-width: 767px) {
            .dashboard-hero {
                padding: 22px;
                border-radius: 22px;
            }

            .stat-icon-lg {
                width: 52px;
                height: 52px;
            }
        }
    </style>

    @php
        $paidPercent = ($order ?? 0) > 0 ? round(($paid / $order) * 100) : 0;
        $expiredPercent = ($order ?? 0) > 0 ? round(($expired / $order) * 100) : 0;

        $paidPercent = min($paidPercent, 100);
        $expiredPercent = min($expiredPercent, 100);
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y dashboard-page">

        {{-- HERO HEADER --}}
        <div class="dashboard-hero mb-4">
            <div class="dashboard-hero-content">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-3">
                            Dashboard Admin
                        </span>

                        <h3 class="fw-bold mb-2 text-white">
                            Selamat Datang di Dashboard 
                        </h3>

                        <p class="mb-0 text-white-50">
                            Pantau pendapatan, pesanan, menu, meja, user, dan kategori dalam satu halaman yang lebih rapi.
                        </p>
                    </div>

                    <div class="col-lg-4">
                        <div class="dashboard-balance-card">
                            <small class="dashboard-balance-label d-block mb-1">
                                Saldo Anda
                            </small>

                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <h3 class="fw-bold mb-0 text-white">
                                    Rp{{ number_format($pendapatan, 0, ',', '.') }}
                                </h3>

                                <div class="dashboard-balance-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M4 6h16M4 18h16" />
                                    </svg>
                                </div>
                            </div>

                            <small class="dashboard-balance-label d-block mt-2">
                                Total saldo berdasarkan transaksi berhasil
                            </small>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- STATISTIC CARDS --}}
        <div class="row g-4 mb-4">

            {{-- TOTAL MENU --}}
            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="metric-label mb-2">Total Menu</div>
                                <h3 class="metric-value mb-1">{{ $menu }}</h3>
                                <small class="text-muted">Menu tersedia di sistem</small>
                            </div>

                            <div class="stat-icon soft-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL MEJA --}}
            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="metric-label mb-2">Total Meja</div>
                                <h3 class="metric-value mb-1">{{ $meja }}</h3>
                                <small class="text-muted">Meja aktif untuk QR Code</small>
                            </div>

                            <div class="stat-icon soft-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 10h18M6 10v9m12-9v9M5 19h14M7 6h10l2 4H5l2-4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL USER --}}
            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="metric-label mb-2">Total User</div>
                                <h3 class="metric-value mb-1">{{ $user_data }}</h3>
                                <small class="text-muted">Pengguna terdaftar</small>
                            </div>

                            <div class="stat-icon soft-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL ORDER --}}
            <div class="col-xl-3 col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="metric-label mb-2">Total Orders</div>
                                <h3 class="metric-value mb-1">{{ $order }}</h3>
                                <small class="text-muted">Semua transaksi pesanan</small>
                            </div>

                            <div class="stat-icon soft-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 14l2 2 4-4M7 4h10a2 2 0 012 2v14l-4-2-3 2-3-2-4 2V6a2 2 0 012-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- MAIN CONTENT --}}
        <div class="row g-4">

            {{-- PEMESANAN --}}
            <div class="col-xl-8">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h5 class="fw-bold mb-1">Ringkasan Pemesanan</h5>
                                <small class="text-muted">Monitoring pendapatan dan status transaksi.</small>
                            </div>

                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                Aktif
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- TOTAL PENDAPATAN --}}
                        <div class="order-summary-box mb-4">
                            <div class="row align-items-center g-3">
                                <div class="col-md-7">
                                    <small class="text-muted d-block mb-1">Total Pendapatan Order</small>
                                    <h2 class="fw-bold text-success mb-1">
                                        Rp{{ number_format($total_order, 0, ',', '.') }}
                                    </h2>
                                    <small class="text-muted">
                                        Akumulasi dari order yang tercatat di sistem.
                                    </small>
                                </div>

                                <div class="col-md-5">
                                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                                        <div class="stat-icon stat-icon-lg soft-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2M5 12a7 7 0 1014 0 7 7 0 00-14 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ORDER METRICS --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-6">
                                <div class="order-summary-box h-100">
                                    <small class="text-muted d-block mb-1">Orders</small>
                                    <h4 class="fw-bold mb-0">{{ $order }}</h4>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="order-summary-box h-100">
                                    <small class="text-muted d-block mb-1">Item Orders</small>
                                    <h4 class="fw-bold mb-0">{{ $order_item }}</h4>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="order-summary-box h-100">
                                    <small class="text-muted d-block mb-1">Paid</small>
                                    <h4 class="fw-bold text-success mb-0">{{ $paid }}</h4>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="order-summary-box h-100">
                                    <small class="text-muted d-block mb-1">Expired</small>
                                    <h4 class="fw-bold text-danger mb-0">{{ $expired }}</h4>
                                </div>
                            </div>
                        </div>

                        {{-- STATUS PROGRESS --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="fw-semibold text-muted">Order Paid</small>
                                <small class="fw-semibold text-success">{{ $paidPercent }}%</small>
                            </div>

                            <div class="progress-modern">
                                <div class="progress-bar bg-success" style="width: {{ $paidPercent }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="fw-semibold text-muted">Order Expired</small>
                                <small class="fw-semibold text-danger">{{ $expiredPercent }}%</small>
                            </div>

                            <div class="progress-modern">
                                <div class="progress-bar bg-danger" style="width: {{ $expiredPercent }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KATEGORI --}}
            <div class="col-xl-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div>
                                <h5 class="fw-bold mb-1">Kategori Menu</h5>
                                <small class="text-muted">Jumlah menu per kategori.</small>
                            </div>

                            <div class="stat-icon soft-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-column gap-3">

                            @forelse ($kategori as $item)
                                <div class="category-item">
                                    <div class="d-flex align-items-center justify-content-between gap-3">

                                        <div class="d-flex align-items-center gap-3">
                                            <div class="stat-icon soft-primary" style="width: 42px; height: 42px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v12m6-6H6" />
                                                </svg>
                                            </div>

                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                                <small class="text-muted">Kategori</small>
                                            </div>
                                        </div>

                                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                                            {{ $item->menu_count }} Menu
                                        </span>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="stat-icon stat-icon-lg soft-primary mx-auto mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 13V7a2 2 0 00-2-2h-3l-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h6" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 19l2 2 4-4" />
                                        </svg>
                                    </div>

                                    <h6 class="fw-bold mb-1">Belum ada kategori</h6>
                                    <small class="text-muted">
                                        Data kategori akan muncul setelah kamu menambahkan kategori menu.
                                    </small>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
