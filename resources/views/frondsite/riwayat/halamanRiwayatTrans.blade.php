@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-md-12 ">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h6 class="mt-2">Riwayat</h6>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>
        @forelse ($orders as $item)
            <div class="col-md-12">
                <div class="card-body product-item">
                    <a href="{{ route('detail.history', $item->id) }}" class="text-decoration-none ">
                        <div class="d-flex mb-2 align-items-center justify-content-center">
                            <div>
                                <small class="fw-bold" style="color: rgb(72, 72, 72)">Makan di tempat <i
                                        class="fa fa-check-circle" style="color: rgb(0, 202, 40)"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div>
                                <h6><span><i class="fa fa-cutlery" style="color: rgb(255, 208, 0)"></i></span>
                                    Pesanan
                                    <br>
                                    <small class=""
                                        style="color: rgb(162, 162, 162)">{{ tanggal_indo($item->waktu_pesan) }},
                                        {{ format_jam($item->waktu_pesan) }}</small>
                                </h6>
                            </div>
                            <div>
                                <span><i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                                <h6>A.n {{ $item->nama }} <br><small
                                        style="color: rgb(151, 151, 151)">Rp{{ number_format($item->total_harga) }}
                                        ({{ $total_itembeli }} item)
                                        <br>#{{ $item->transaction->xendit_external_id }}</small>
                                </h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center">
                <img class="mt-5" src="{{ asset('images/histor.png') }}" width="40%" alt="">
            </div>
            <span class="text-center">Belum ada pesanan</span>
        @endforelse

    </div>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
