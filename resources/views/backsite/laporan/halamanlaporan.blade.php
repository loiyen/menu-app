@extends('backsite.layout.main')

@section('container')
    <style>
        .report-page {
            --report-primary: #696cff;
            --report-success: #28c76f;
            --report-warning: #ff9f43;
            --report-danger: #ea5455;
            --report-info: #00cfe8;
            --report-dark: #2f3349;
            --report-muted: #8a8d9e;
            --report-border: #ececf6;
            --report-soft: #f8f8fc;
        }

        .report-hero {
            position: relative;
            overflow: hidden;
            border: 0;
            border-radius: 20px;
            background:
                radial-gradient(circle at top right,
                    rgba(255, 255, 255, 0.22),
                    transparent 32%),
                linear-gradient(135deg,
                    #171f32 0%,
                    #24437d 55%,
                    #2f66e8 100%);
            box-shadow: 0 15px 38px rgba(45, 79, 168, 0.20);
        }

        .report-hero::after {
            content: "";
            position: absolute;
            right: -70px;
            bottom: -115px;
            width: 270px;
            height: 270px;
            border: 42px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .report-hero-content {
            position: relative;
            z-index: 2;
        }

        .report-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 50rem;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(8px);
        }

        .period-card {
            min-width: 260px;
            padding: 20px;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 17px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(9px);
        }

        .report-filter {
            overflow: hidden;
            border: 1px solid var(--report-border);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 25px rgba(31, 41, 55, 0.055);
        }

        .report-filter-header {
            padding: 19px 22px;
            border-bottom: 1px solid var(--report-border);
            background: linear-gradient(180deg,
                    #ffffff,
                    #fafaff);
        }

        .report-filter-body {
            padding: 20px 22px;
        }

        .filter-control {
            min-height: 45px;
            border: 1px solid #e2e3ef;
            border-radius: 11px;
            background: #fafaff;
        }

        .filter-control:focus {
            border-color: var(--report-primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.11);
        }

        .stat-card {
            position: relative;
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--report-border);
            border-radius: 17px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(31, 41, 55, 0.055);
            transition:
                transform 0.22s ease,
                box-shadow 0.22s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(31, 41, 55, 0.09);
        }

        .stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 49px;
            height: 49px;
            font-size: 23px;
            border-radius: 15px;
        }

        .icon-primary {
            color: var(--report-primary);
            background: rgba(105, 108, 255, 0.12);
        }

        .icon-success {
            color: var(--report-success);
            background: rgba(40, 199, 111, 0.13);
        }

        .icon-warning {
            color: var(--report-warning);
            background: rgba(255, 159, 67, 0.15);
        }

        .icon-danger {
            color: var(--report-danger);
            background: rgba(234, 84, 85, 0.13);
        }

        .icon-info {
            color: #00a7c0;
            background: rgba(0, 207, 232, 0.14);
        }

        .stat-label {
            margin-bottom: 7px;
            color: var(--report-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .stat-value {
            margin-bottom: 0;
            color: var(--report-dark);
            font-size: 23px;
            font-weight: 750;
            line-height: 1.25;
        }

        .report-card {
            overflow: hidden;
            border: 1px solid var(--report-border);
            border-radius: 19px;
            background: #ffffff;
            box-shadow: 0 9px 28px rgba(31, 41, 55, 0.055);
        }

        .report-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--report-border);
            background: linear-gradient(180deg,
                    #ffffff,
                    #fbfbff);
        }

        .report-section-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            color: var(--report-primary);
            font-size: 21px;
            border-radius: 13px;
            background: rgba(105, 108, 255, 0.11);
        }

        .report-title {
            margin-bottom: 3px;
            color: var(--report-dark);
            font-size: 16px;
            font-weight: 700;
        }

        .report-subtitle {
            margin-bottom: 0;
            color: var(--report-muted);
            font-size: 12px;
        }

        .chart-container {
            position: relative;
            min-height: 340px;
            padding: 20px;
        }

        .payment-row,
        .menu-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 13px;
            padding: 14px 0;
            border-bottom: 1px dashed #ececf4;
        }

        .payment-row:last-child,
        .menu-row:last-child {
            border-bottom: 0;
        }

        .payment-icon,
        .menu-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 39px;
            height: 39px;
            color: var(--report-primary);
            font-size: 18px;
            font-weight: 700;
            border-radius: 12px;
            background: rgba(105, 108, 255, 0.10);
        }

        .progress-box {
            padding: 18px;
            border: 1px solid var(--report-border);
            border-radius: 15px;
            background: var(--report-soft);
        }

        .report-progress {
            height: 8px;
            overflow: hidden;
            border-radius: 50rem;
            background: #e9eaf2;
        }

        .report-progress-bar {
            height: 100%;
            border-radius: inherit;
        }

        .orders-table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .orders-table thead th {
            padding: 14px 16px;
            color: #777a8b;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.35px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid var(--report-border);
            background: #fafaff;
        }

        .orders-table tbody td {
            padding: 15px 16px;
            color: #44475a;
            font-size: 12px;
            border-bottom: 1px solid #f0f0f6;
        }

        .orders-table tbody tr:hover {
            background: rgba(105, 108, 255, 0.025);
        }

        .order-code {
            color: var(--report-dark);
            font-weight: 700;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 10px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            border-radius: 50rem;
        }

        .status-success {
            color: #16874c;
            background: rgba(40, 199, 111, 0.14);
        }

        .status-warning {
            color: #b96400;
            background: rgba(255, 159, 67, 0.16);
        }

        .status-danger {
            color: #be3a3b;
            background: rgba(234, 84, 85, 0.14);
        }

        .status-primary {
            color: #5659d9;
            background: rgba(105, 108, 255, 0.13);
        }

        .status-secondary {
            color: #696c7c;
            background: rgba(108, 117, 125, 0.13);
        }

        .table-pagination {
            display: flex;
            justify-content: flex-end;
            padding: 17px 21px;
            border-top: 1px solid var(--report-border);
        }

        .empty-state {
            padding: 55px 20px;
            text-align: center;
        }

        .empty-state-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            margin-bottom: 16px;
            color: var(--report-primary);
            font-size: 32px;
            border-radius: 20px;
            background: rgba(105, 108, 255, 0.10);
        }

        @media print {

            .no-print,
            .layout-navbar,
            .layout-menu {
                display: none !important;
            }

            .content-wrapper {
                margin: 0 !important;
            }

            .report-card,
            .stat-card,
            .report-filter {
                box-shadow: none !important;
            }
        }

        @media (max-width: 767.98px) {
            .report-hero .card-body {
                padding: 22px !important;
            }

            .report-hero h3 {
                font-size: 21px;
            }

            .period-card {
                width: 100%;
                min-width: 0;
            }

            .report-card-header {
                align-items: flex-start;
                padding: 18px;
            }

            .chart-container {
                min-height: 290px;
                padding: 14px;
            }

            .table-pagination {
                justify-content: center;
            }
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y report-page">

        {{-- Header laporan --}}
        <div class="card report-hero mb-4">
            <div class="card-body p-4 p-lg-5">
                <div
                    class="report-hero-content d-flex flex-column flex-lg-row
                        align-items-lg-center justify-content-between gap-4">
                    <div>
                        <span class="report-badge mb-3">
                            <i class="bx bx-bar-chart-alt-2"></i>
                            Laporan Penjualan
                        </span>

                        <h3 class="text-white fw-bold mb-2">
                            Laporan Pesanan dan Transaksi
                        </h3>

                        <p class="mb-0 text-white opacity-75">
                            Analisis pesanan, pembayaran, pendapatan,
                            dan menu terlaris dalam satu halaman.
                        </p>
                    </div>

                    <div class="period-card">
                        <small class="d-block text-white opacity-75 mb-2">
                            Periode laporan
                        </small>

                        <div class="fw-bold fs-5">
                            {{ tanggal_indo($dari) }}
                        </div>

                        <div class="text-white opacity-75 my-1">
                            sampai
                        </div>

                        <div class="fw-bold fs-5">
                            {{ tanggal_indo($sampai) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter laporan --}}
        <div class="report-filter mb-4 no-print">
            <div class="report-filter-header">
                <div class="d-flex align-items-center gap-3">
                    <span class="report-section-icon">
                        <i class="bx bx-filter-alt"></i>
                    </span>

                    <div>
                        <h5 class="report-title">
                            Filter Laporan
                        </h5>

                        <p class="report-subtitle">
                            Tentukan periode dan status data laporan
                        </p>
                    </div>
                </div>
            </div>

            <div class="report-filter-body">
                <form method="GET" action="{{ route('laporan.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-6 col-xl-2">
                            <label for="dari" class="form-label fw-semibold">
                                Dari tanggal
                            </label>

                            <input type="date" name="dari" id="dari" class="form-control filter-control"
                                value="{{ request('dari', $dari->format('Y-m-d')) }}">
                        </div>

                        <div class="col-12 col-md-6 col-xl-2">
                            <label for="sampai" class="form-label fw-semibold">
                                Sampai tanggal
                            </label>

                            <input type="date" name="sampai" id="sampai" class="form-control filter-control"
                                value="{{ request('sampai', $sampai->format('Y-m-d')) }}">
                        </div>

                        <div class="col-12 col-md-6 col-xl-2">
                            <label for="payment_status" class="form-label fw-semibold">
                                Pembayaran
                            </label>

                            <select name="payment_status" id="payment_status" class="form-select filter-control">
                                <option value="all">
                                    Semua pembayaran
                                </option>

                                <option value="paid" @selected(request('payment_status') === 'paid')>
                                    Sudah dibayar
                                </option>

                                <option value="unpaid" @selected(request('payment_status') === 'unpaid')>
                                    Belum dibayar
                                </option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-xl-2">
                            <label for="status_order" class="form-label fw-semibold">
                                Status order
                            </label>

                            <select name="status_order" id="status_order" class="form-select filter-control">
                                <option value="all">
                                    Semua status
                                </option>

                                <option value="proses" @selected(request('status_order') === 'proses')>
                                    Diproses
                                </option>

                                <option value="selesai" @selected(request('status_order') === 'selesai')>
                                    Selesai
                                </option>
                            </select>
                        </div>

                        <div class="col-12 col-xl-4">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search-alt me-1"></i>
                                    Tampilkan
                                </button>

                                <a href="{{ route('laporan.index') }}" class="btn btn-label-secondary">
                                    <i class="bx bx-reset me-1"></i>
                                    Reset
                                </a>

                                <button type="button" class="btn btn-label-primary" onclick="window.print()">
                                    <i class="bx bx-printer me-1"></i>
                                    Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Total pesanan
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalOrders, 0, ',', '.') }}
                                </h4>

                                <small class="d-block text-muted mt-3">
                                    Pesanan pada periode laporan
                                </small>
                            </div>

                            <span class="stat-icon icon-primary">
                                <i class="bx bx-receipt"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Pendapatan berhasil
                                </p>

                                <h4 class="stat-value">
                                    Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h4>

                                <small class="d-block text-muted mt-3">
                                    Berdasarkan transaksi berhasil
                                </small>
                            </div>

                            <span class="stat-icon icon-success">
                                <i class="bx bx-wallet"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Total item terjual
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalItemTerjual, 0, ',', '.') }}
                                </h4>

                                <small class="d-block text-muted mt-3">
                                    Akumulasi kuantitas item
                                </small>
                            </div>

                            <span class="stat-icon icon-warning">
                                <i class="bx bx-bowl-hot"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Order paid
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalPaid, 0, ',', '.') }}
                                </h4>
                            </div>

                            <span class="stat-icon icon-success">
                                <i class="bx bx-check-circle"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Order unpaid
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalUnpaid, 0, ',', '.') }}
                                </h4>
                            </div>

                            <span class="stat-icon icon-danger">
                                <i class="bx bx-time-five"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Sedang diproses
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalOrderProses, 0, ',', '.') }}
                                </h4>
                            </div>

                            <span class="stat-icon icon-warning">
                                <i class="bx bx-loader-circle"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <p class="stat-label">
                                    Order selesai
                                </p>

                                <h4 class="stat-value">
                                    {{ number_format($totalOrderSelesai, 0, ',', '.') }}
                                </h4>
                            </div>

                            <span class="stat-icon icon-info">
                                <i class="bx bx-check-double"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik dan metode pembayaran --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-8">
                <div class="report-card">
                    <div class="report-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <span class="report-section-icon">
                                <i class="bx bx-line-chart"></i>
                            </span>

                            <div>
                                <h5 class="report-title">
                                    Tren Pesanan dan Pendapatan
                                </h5>

                                <p class="report-subtitle">
                                    Perkembangan data pada periode laporan
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="reportChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="report-card">
                    <div class="report-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <span class="report-section-icon">
                                <i class="bx bx-credit-card"></i>
                            </span>

                            <div>
                                <h5 class="report-title">
                                    Metode Pembayaran
                                </h5>

                                <p class="report-subtitle">
                                    Transaksi pembayaran berhasil
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-4">
                        @forelse ($paymentSummary as $payment)
                            @php
                                $paymentType = strtolower($payment->payment_type ?? '');

                                $paymentLabel = match ($paymentType) {
                                    'qris' => 'QRIS',
                                    'cash', 'tunai' => 'Tunai',
                                    'bank_transfer', 'transfer' => 'Transfer',
                                    default => strtoupper($paymentType),
                                };

                                $paymentIcon = match ($paymentType) {
                                    'qris' => 'bx-qr-scan',
                                    'cash', 'tunai' => 'bx-money',
                                    default => 'bx-credit-card',
                                };
                            @endphp

                            <div class="payment-row">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="payment-icon">
                                        <i class="bx {{ $paymentIcon }}"></i>
                                    </span>

                                    <div>
                                        <div class="fw-bold">
                                            {{ $paymentLabel }}
                                        </div>

                                        <small class="text-muted">
                                            {{ number_format($payment->total_transactions, 0, ',', '.') }}
                                            transaksi
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-bold">
                                        Rp{{ number_format($payment->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="empty-state-icon">
                                    <i class="bx bx-credit-card"></i>
                                </span>

                                <h6 class="fw-bold">
                                    Belum Ada Transaksi
                                </h6>

                                <p class="text-muted mb-0">
                                    Data pembayaran belum tersedia.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress dan menu terlaris --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="report-card">
                    <div class="report-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <span class="report-section-icon">
                                <i class="bx bx-task"></i>
                            </span>

                            <div>
                                <h5 class="report-title">
                                    Ringkasan Status
                                </h5>

                                <p class="report-subtitle">
                                    Persentase pembayaran dan penyelesaian
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="progress-box mb-3">
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-2">
                                <span class="fw-semibold">
                                    Pembayaran berhasil
                                </span>

                                <span class="fw-bold text-success">
                                    {{ $persentasePaid }}%
                                </span>
                            </div>

                            <div class="report-progress">
                                <div class="report-progress-bar bg-success"
                                    style="width:
                                        {{ min($persentasePaid, 100) }}%;">
                                </div>
                            </div>

                            <small class="d-block text-muted mt-2">
                                {{ $totalPaid }} dari
                                {{ $totalOrders }} pesanan
                            </small>
                        </div>

                        <div class="progress-box">
                            <div
                                class="d-flex justify-content-between
                                    align-items-center mb-2">
                                <span class="fw-semibold">
                                    Pesanan selesai
                                </span>

                                <span class="fw-bold text-primary">
                                    {{ $persentaseSelesai }}%
                                </span>
                            </div>

                            <div class="report-progress">
                                <div class="report-progress-bar bg-primary"
                                    style="width:
                                        {{ min($persentaseSelesai, 100) }}%;">
                                </div>
                            </div>

                            <small class="d-block text-muted mt-2">
                                {{ $totalOrderSelesai }} dari
                                {{ $totalOrders }} pesanan
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="report-card">
                    <div class="report-card-header">
                        <div class="d-flex align-items-center gap-3">
                            <span class="report-section-icon">
                                <i class="bx bx-trophy"></i>
                            </span>

                            <div>
                                <h5 class="report-title">
                                    Menu Terlaris
                                </h5>

                                <p class="report-subtitle">
                                    Lima menu dengan jumlah penjualan tertinggi
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-4">
                        @forelse ($topMenus as $menu)
                            <div class="menu-row">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="menu-number">
                                        {{ $loop->iteration }}
                                    </span>

                                    <div>
                                        <div class="fw-bold">
                                            {{ $menu->nama_menu }}
                                        </div>

                                        <small class="text-muted">
                                            {{ number_format($menu->total_qty, 0, ',', '.') }}
                                            item terjual
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-bold">
                                        Rp{{ number_format($menu->total_omzet, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <span class="empty-state-icon">
                                    <i class="bx bx-food-menu"></i>
                                </span>

                                <h6 class="fw-bold">
                                    Belum Ada Data Menu
                                </h6>

                                <p class="text-muted mb-0">
                                    Penjualan menu belum tersedia.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail pesanan --}}
        <div class="report-card">
            <div class="report-card-header">
                <div class="d-flex align-items-center gap-3">
                    <span class="report-section-icon">
                        <i class="bx bx-list-ul"></i>
                    </span>

                    <div>
                        <h5 class="report-title">
                            Detail Pesanan
                        </h5>

                        <p class="report-subtitle">
                            Daftar pesanan berdasarkan periode laporan
                        </p>
                    </div>
                </div>

                <span class="badge bg-label-primary">
                    {{ $orders->total() }} data
                </span>
            </div>

            <div class="table-responsive">
                <table class="table orders-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor pesanan</th>
                            <th>Pelanggan</th>
                            <th>Waktu pesan</th>
                            <th>Item</th>
                            <th>Pembayaran</th>
                            <th>Status transaksi</th>
                            <th>Status order</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $paymentStatus = strtolower((string) $order->payment_status);

                                $paymentClass = match ($paymentStatus) {
                                    'paid' => 'status-success',
                                    'unpaid' => 'status-warning',
                                    default => 'status-secondary',
                                };

                                $paymentLabel = match ($paymentStatus) {
                                    'paid' => 'Paid',
                                    'unpaid' => 'Unpaid',
                                    default => ucfirst($paymentStatus),
                                };

                                $transactionStatus = strtoupper(
                                    (string) ($order->transaction?->transaction_status ?? 'PENDING'),
                                );

                                $transactionClass = match ($transactionStatus) {
                                    'PAID', 'SETTLED', 'SETTLEMENT', 'SUCCESS' => 'status-success',

                                    'PENDING' => 'status-warning',

                                    'FAILED', 'DENY', 'EXPIRED', 'CANCELLED', 'CANCELED' => 'status-danger',

                                    default => 'status-secondary',
                                };

                                $transactionLabel = match ($transactionStatus) {
                                    'PAID', 'SETTLED', 'SETTLEMENT', 'SUCCESS' => 'Berhasil',

                                    'PENDING' => 'Menunggu',

                                    'FAILED', 'DENY' => 'Gagal',

                                    'EXPIRED' => 'Kedaluwarsa',

                                    'CANCELLED', 'CANCELED' => 'Dibatalkan',

                                    default => ucfirst(strtolower($transactionStatus)),
                                };

                                $orderStatus = strtolower((string) $order->status_order);

                                $orderStatusClass = $orderStatus === 'selesai' ? 'status-success' : 'status-primary';

                                $orderStatusLabel = $orderStatus === 'selesai' ? 'Selesai' : 'Diproses';

                                $paymentType = strtoupper((string) ($order->transaction?->payment_type ?? '-'));
                            @endphp

                            <tr>
                                <td>
                                    {{ $orders->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="order-code">
                                        {{ $order->nomor_pesanan }}
                                    </span>

                                    @if ($order->meja?->nomor_meja)
                                        <small class="d-block text-muted mt-1">
                                            Meja
                                            {{ $order->meja->nomor_meja }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        {{ $order->nama }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $order->phone }}
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ tanggal_indo($order->waktu_pesan) }}
                                    </div>

                                    <small class="text-muted">
                                        {{ format_jam($order->waktu_pesan) }}
                                    </small>
                                </td>

                                <td>
                                    <span class="fw-bold">
                                        {{ number_format($order->items->sum('qty'), 0, ',', '.') }}
                                    </span>

                                    <small class="d-block text-muted">
                                        item
                                    </small>
                                </td>

                                <td>
                                    <div class="mb-1">
                                        {{ $paymentType }}
                                    </div>

                                    <span
                                        class="status-badge
                                            {{ $paymentClass }}">
                                        {{ $paymentLabel }}
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="status-badge
                                            {{ $transactionClass }}">
                                        {{ $transactionLabel }}
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="status-badge
                                            {{ $orderStatusClass }}">
                                        {{ $orderStatusLabel }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <span class="fw-bold">
                                        Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <span class="empty-state-icon">
                                            <i class="bx bx-receipt"></i>
                                        </span>

                                        <h5 class="fw-bold">
                                            Data Laporan Kosong
                                        </h5>

                                        <p class="text-muted mb-0">
                                            Tidak ada pesanan pada periode
                                            dan filter yang dipilih.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="table-pagination no-print">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('reportChart');

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const labels = @json($chartLabels);
            const orderData = @json($chartOrders);
            const revenueData = @json($chartRevenue);

            new Chart(canvas, {
                type: 'line',

                data: {
                    labels: labels,

                    datasets: [{
                            label: 'Jumlah Pesanan',
                            data: orderData,
                            borderWidth: 3,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Pendapatan',
                            data: revenueData,
                            borderWidth: 3,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            yAxisID: 'y1'
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (
                                        context.dataset.yAxisID === 'y1'
                                    ) {
                                        return (
                                            context.dataset.label +
                                            ': Rp' +
                                            new Intl.NumberFormat(
                                                'id-ID'
                                            ).format(
                                                context.parsed.y
                                            )
                                        );
                                    }

                                    return (
                                        context.dataset.label +
                                        ': ' +
                                        context.parsed.y
                                    );
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return (
                                        'Rp' +
                                        new Intl.NumberFormat(
                                            'id-ID', {
                                                notation: 'compact'
                                            }
                                        ).format(value)
                                    );
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
