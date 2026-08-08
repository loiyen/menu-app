@extends('frondsite.layout.main')

@section('container')
    <div class="col-12">

        <!-- HEADER -->
        <div class="col-12 mb-3 mt-2">
            <div class="d-flex align-items-center justify-content-between py-2">
                <a href="{{ route('riwayat.pesananuser') }}"
                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;">
                    <i class="fa fa-arrow-left text-dark"></i>
                </a>
                <h6 class="fw-semibold mb-0 text-dark">
                    Detail Pesanan
                </h6>
                <div style="width:38px;"></div>
            </div>
        </div>

        <!-- STATUS -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">

            @if ($orders->payment_status === 'PAID')
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-success-subtle border border-success-subtle">
                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                        style="width:24px;height:24px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                            viewBox="0 0 16 16">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-7.25 7.25a1 1 0 01-1.414 0l-3.25-3.25a1 1 0 111.414-1.414L8.5 11.586l6.543-6.543a1 1 0 011.414 0z" />
                        </svg>
                    </div>

                    <div>
                        <div class="fw-bold text-success">Pembayaran Berhasil</div>
                        <small class="text-muted">Pesanan telah dibayar</small>
                    </div>
                </div>
            @else
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-warning-subtle border border-warning-subtle">
                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                        style="width:24px;height:24px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 1a7 7 0 110 14A7 7 0 018 1zm0 3a1 1 0 00-1 1v3a1 1 0 102 0V5a1 1 0 00-1-1zm0 7a1.25 1.25 0 100-2.5A1.25 1.25 0 008 11z" />
                        </svg>
                    </div>

                    <div>
                        <div class="fw-bold text-dark">Menunggu Pembayaran</div>
                        <small class="text-muted">Pesanan belum dibayar</small>
                    </div>
                </div>
            @endif

            <div class="mt-3 small text-muted">
                No. Pesanan <br>
                <span class="text-dark fw-medium">{{ $orders->transaction->xendit_external_id }}</span>
            </div>

            <div class="mt-2 small text-muted">
                Tanggal <br>
                <span class="text-dark fw-medium">
                    {{ tanggal_indo($orders->waktu_pesan) }},
                    {{ format_jam($orders->waktu_pesan) }}
                </span>
            </div>

            <div class="mt-2 small text-muted">
                Catatan <br>
                <span class="text-dark fw-medium">{{ $orders->catatan ?? '-' }}</span>
            </div>
        </div>

        <!-- DETAIL MENU -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
            <h6 class="fw-semibold mb-3">Detail Menu ({{ $total_item }})</h6>

            @foreach ($orders->items as $item)
                <div class="d-flex align-items-center justify-content-between mb-3">

                    <div class="d-flex gap-3 align-items-center">

                        <img src="{{ asset('storage/' . $item->menu->gambar) }}" class="rounded-3" width="60"
                            height="60" style="object-fit: cover">

                        <div>
                            <div class="fw-semibold">{{ $item->nama_menu }}</div>
                            <small class="text-muted">x{{ $item->qty }}</small>
                        </div>
                    </div>

                    <div class="text-end">
                        <div class="fw-semibold">
                            Rp{{ number_format($item->harga) }}
                        </div>

                    </div>
                </div>
                <div>
                    <h6 class="text-muted">Catatan : </h6>
                    @if ($item->catatan_menu == null)
                        <p>Tidak ada</p>
                    @else
                        <p>{{ $item->catatan_menu }}</p>
                    @endif

                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-muted">Status pesanan : </h6>
                    @if ($item->status == 'proses')
                        <span class="badge bg-primary">Proses</span>
                    @else
                        <span class="badge" style="background-color: forestgreen">Selesai</span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- PEMBAYARAN -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
            <h6 class="fw-semibold mb-3">Rincian Pembayaran</h6>

            <div class="d-flex justify-content-between small mb-">
                <span class="text-muted">Metode</span>
                <span class="fw-medium">
                    @if ($orders->transaction->payment_type == 'qris')
                        <p>QRIS</p>
                    @endif

                </span>
            </div>

            <div class="d-flex justify-content-between small mb-2">
                <span class="text-muted">Subtotal</span>
                <span>Rp{{ number_format($orders->total_harga) }}</span>
            </div>

            <div class="d-flex justify-content-between small mb-2">
                <span class="text-muted">PPN</span>
                <span>Rp4,000</span>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <span class="fw-semibold">Total</span>
                <span class="fw-bold">
                    Rp{{ number_format($orders->transaction->gross_amount) }}
                </span>
            </div>
        </div>

        <!-- BUTTON -->
        <div class="d-grid ">
            @if ($orders->payment_status === 'PAID')
                <a href="/" class="btn btn-primary rounded-pill fw-semibold py-2">
                    Pesan Lagi
                </a>
            @else
                <a href="{{ route('pembayaran.pesanan', $orders->id) }}"
                    class="btn btn-primary rounded-pill fw-semibold py-2">
                    Bayar
                </a>
            @endif

        </div>
        <div class="mb-5"></div>

    </div>
@endsection
