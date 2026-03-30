@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <!-- HEADER -->
        <div class="col-12 mb-3 mt-2">
            <div class="d-flex align-items-center justify-content-between py-2">

                <!-- Back -->
                <a href="/checkout"
                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;">
                    <i class="fa fa-arrow-left text-dark"></i>
                </a>

                <!-- Title -->
                <h6 class="fw-semibold mb-0 text-dark">
                    Pembayaran
                </h6>

                <!-- Placeholder -->
                <div style="width:38px;"></div>

            </div>
        </div>

        <!-- TIPE PESANAN -->
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-3 d-flex justify-content-between align-items-center">

                    <!-- Left -->
                    <div class="d-flex align-items-center gap-2">

                        <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                            style="width:36px;height:36px;">
                            <i class="fa fa-utensils text-success"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Tipe Pesanan
                            </small>
                            <span class="fw-semibold text-dark">
                                Makan di tempat
                            </span>
                        </div>

                    </div>

                    <!-- Status -->
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        <i class="fa fa-check me-1"></i> Aktif
                    </span>

                </div>

            </div>
        </div>

        <form action="{{ route('order.create') }}" method="POST">
            @csrf
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-3">

                        <!-- TITLE -->
                        <h6 class="fw-semibold mb-3">
                            Informasi Pemesan
                        </h6>

                        <!-- NAMA -->
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">
                                Nama Lengkap
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" name="nama"
                                    placeholder="Masukkan nama" required>
                            </div>
                        </div>

                        <!-- PHONE -->
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">
                                Nomor Ponsel
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fa fa-phone text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" name="phone"
                                    placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">
                                Email
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                    class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                    name="email" placeholder="email@gmail.com">
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- CATATAN -->
                        <div class="mb-3">
                            <label class="form-label small text-muted mb-1">
                                Catatan
                            </label>

                            <textarea class="form-control bg-light border-0" name="catatan" rows="2"
                                placeholder="Contoh: meja dekat jendela..."></textarea>
                        </div>

                        <!-- NOMOR MEJA -->
                        <div class="mb-1">
                            <label class="form-label small text-muted mb-1">
                                Nomor Meja
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fa fa-map-marker text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light fw-semibold"
                                    value="{{ session('nomor_meja') }}" disabled>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-12 product-item mb-5">
                <div class="card-body">

                    <!-- TITLE -->
                    <h6 class="fw-semibold mb-3">
                        Pembayaran
                    </h6>

                    <!-- INFO BOX -->
                    <div class="bg-warning-subtle rounded-3 p-2 mb-3 d-flex align-items-start gap-2">
                        <i class="fa fa-info-circle text-warning mt-1"></i>
                        <small class="text-muted">
                            Mohon tidak pindah meja setelah pembayaran berhasil.
                        </small>
                    </div>

                    <!-- METODE -->
                    <div class="">
                        <small class="text-muted d-block mb-2">
                            Metode Pembayaran
                        </small>

                        <!-- OPTION QRIS -->
                        <label
                            class="d-flex align-items-center justify-content-between border rounded-3 p-2 mb-2 payment-option">

                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:36px;height:36px;">
                                    <i class="fa fa-qrcode text-dark"></i>
                                </div>

                                <div>
                                    <span class="fw-semibold d-block">QRIS</span>
                                    <small class="text-muted">Scan & bayar cepat</small>
                                </div>
                            </div>

                            <input class="form-check-input" type="radio" name="metode" value="qris" checked>

                        </label>
                        @error('metode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pb-5 mt-5"></div>

            <div class="fixed-bottom bg-white border-top shadow-sm">
                <div class="container py-2">

                    <div class="d-flex align-items-center justify-content-between">

                        <!-- TOTAL -->
                        <div>
                            <small class="text-muted d-block">
                                Total Pembayaran
                            </small>
                            <span class="fw-bold text-primary fs-5">
                                Rp {{ number_format($total_harga + 4000) }}
                            </span>
                        </div>
                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
