@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-12 mb-3 mt-2">
            <div class="d-flex align-items-center justify-content-between py-2">
                <a href="/"
                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;">
                    <i class="fa fa-arrow-left text-dark"></i>
                </a>
                <h6 class="fw-semibold mb-0 text-dark">
                    Riwayat Pesanan
                </h6>
                <div style="width:38px;"></div>
            </div>
        </div>


        @forelse ($orders as $item)
            <div class="col-12 mb-3">
                <a href="{{ route('detail.history', $item->id) }}" class="text-decoration-none">

                    <div class="card border-0 shadow-sm rounded-4 p-3 history-card hover-shadow transition">

                        <!-- TOP -->
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="d-flex align-items-center gap-2 text-success fw-semibold small">
                                <!-- SVG ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path
                                        d="M15.854 8.146a.5.5 0 0 0-.708-.708l-7.146 7.147-3.146-3.147a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7.5-7.5z" />
                                    <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0z" />
                                </svg>
                                Makan di tempat
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="text-muted" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4
                            4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>

                        </div>

                        <!-- MIDDLE -->
                        <div class="mb-3">
                            <h6 class="fw-semibold mb-1 d-flex align-items-center gap-2">

                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="text-warning" viewBox="0 0 24 24">
                                    <path d="M8 2v2H5v18h14V4h-3V2h-2v2h-4V2H8zm9 6v10H7V8h10z" />
                                </svg>

                                Pesanan
                            </h6>

                            <small class="text-muted">
                                {{ tanggal_indo($item->waktu_pesan) }},
                                {{ format_jam($item->waktu_pesan) }}
                            </small>
                        </div>

                        <hr class="my-2">

                        <!-- BOTTOM -->
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h6 class="mb-1 fw-semibold">
                                    A.n {{ $item->nama }}
                                </h6>

                                <small class="text-muted">
                                    Rp {{ number_format($item->total_harga) }}
                                    • {{ $total_itembeli }} item
                                </small>

                                <div class="small text-muted">
                                    #{{ $item->transaction->xendit_external_id }}
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div>
                                @if ($item->transaction)
                                    @if ($item->transaction->transaction_status == 'PAID')
                                        <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success fw-medium">
                                            Lunas
                                        </span>
                                    @elseif($item->transaction->transaction_status == 'PENDING')
                                        <a href="{{ route('pembayaran.pesanan', $item->id) }}"
                                            class="btn btn-sm btn-primary rounded-pill px-3">
                                            Bayar
                                        </a>
                                    @elseif($item->transaction->transaction_status == 'EXPIRED')
                                        <span class="badge rounded-pill px-3 py-2 bg-danger-subtle text-danger fw-medium">
                                            Expired
                                        </span>
                                    @endif
                                @endif
                            </div>

                        </div>

                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('images/histor.png') }}" width="120" class="mb-3 opacity-75">
                <h6 class="fw-semibold text-dark mb-1">
                    Belum ada pesanan
                </h6>
                <small class="text-muted">
                    Yuk mulai pesan menu favoritmu 🍽️
                </small>
            </div>
        @endforelse

    </div>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
