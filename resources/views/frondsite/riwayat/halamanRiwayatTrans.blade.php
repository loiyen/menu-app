@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between">

                <!-- Back -->
                <a href="/"
                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;">
                    <i class="fa fa-arrow-left text-dark"></i>
                </a>

                <!-- Title -->
                <h6 class="fw-semibold mb-0 text-dark">
                    Riwayat Pesanan
                </h6>

                <!-- Placeholder -->
                <div style="width:38px;"></div>

            </div>
        </div>


        @forelse ($orders as $item)
            <div class="col-12 mb-3">
                <a href="{{ route('detail.history', $item->id) }}" class="text-decoration-none text-dark">

                    <div class="card border-0 shadow-sm rounded-4 p-3 history-card">

                        <!-- TOP -->
                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <small class="d-flex align-items-center gap-1 text-success fw-semibold">
                                <i class="fa fa-check-circle"></i>
                                Makan di tempat
                            </small>

                            <i class="fa fa-chevron-right text-muted"></i>

                        </div>

                        <!-- MIDDLE -->
                        <div class="mb-2">
                            <h6 class="fw-semibold mb-1">
                                <i class="fa fa-cutlery text-warning me-1"></i>
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

                                <div>
                                    @if ($item->transaction)
                                        @if ($item->transaction->transaction_status == 'PAID')
                                            <span class="badge bg-success text-white rounded-pill">Lunas</span>
                                        @elseif($item->transaction->transaction_status == 'PENDING')
                                            <a href="{{ route('pembayaran.pesanan', $item->id) }}"
                                                class="btn btn-sm btn-primary rounded-pill">
                                                Bayar
                                            </a>
                                        @elseif($item->transaction->transaction_status == 'EXPIRED')
                                            <span class="badge bg-danger text-white rounded-pill">Expired</span>
                                        @endif
                                    @endif
                                </div>
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
