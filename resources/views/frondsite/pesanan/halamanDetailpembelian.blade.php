@extends('frondsite.layout.main')

@section('container')
    @include('frondsite.partials.navbar')

    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="row g-4">
            <div class="col-md-12 col-lg-12 col-sm-12 product-item mb-3 ">

                <div class="h-100">
                    <div class="card-body mb-1">
                        <div
                            class="card card-header d-flex justify-content-between bg-primary align-items-center mt-2 mb-2">

                            <h6 class="mt-2 text-white text-center">-- {{ $orders->order_id }} -- <br class="mt-3"> Status
                                :
                                {{ $orders->status }} </h6>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><strong>{{ $orders->nama }}</strong></i></td>
                                    </tr>
                                    <tr>
                                        <td>No meja</td>
                                        <td>:</td>
                                        <td>M - {{ $orders->meja->nomor_meja }}</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td>:</td>
                                        <td>{{ $total_item }} item</td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ tanggal_indo($orders->waktu_pesan) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jam</td>
                                        <td>:</td>
                                        <td>{{ format_jam($orders->waktu_pesan) }}</td>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>

                    {{-- <div class="card-body mb-2">
                        if
                        <div class="alert bg-danger d-flex align-items-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                role="img" aria-label="Warning:">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>
                            <div>
                                {{ $orders->status }}!
                            </div>
                        </div>

                    </div> --}}

                    <div class="card-body">
                        <div class="order-md-last">
                            <h6 class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                <span class="">* Item pemesanan</span>
                            </h6>
                            <ul class="list-group mb-3">
                                @forelse ($orders->items as $item)
                                    <li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div class="d-flex align-items-start gap-2">
                                            <img src="{{ asset('storage/' . $item->menu->gambar) }}" alt="Growers cider"
                                                class="img-fluid rounded" style="width: 60%; height: 100px;">
                                            <div class="card-body">
                                                <h6 class="mb-1">{{ $item['nama_menu'] }}</h5>
                                                    <small class="text-body-secondary">X {{ $item['qty'] }}</small>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <span
                                                class="text-body-secondary">{{ 'Rp.' . number_format($item['sub_total']) }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <small>
                                                @if ($item['status'] == 'proses')
                                                    <span class="badge bg-dark rounded-pill">{{ $item['status'] }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-success rounded-pill">{{ $item['status'] }}</span>
                                                @endif
                                            </small>

                                        </div>
                                    </li>
                                @empty
                                    <div class="text-center mt-5 mb-5">
                                        <img src="{{ asset('images/cart1.png') }}" width="20%" alt="cart">
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-12 col-lg-12 mb-2 product-item mb-1">
                <div class="">
                    <div class="card-body">
                        <div class="mb-3 mt-2">
                            <h6 class="d-flex justify-content-between align-items-center mt-2 mb-3">
                                <span class="">* Pembayaran</span>
                                <span class="badge bg-primary rounded-pill">Tunai</span>
                            </h6>
                            <h5 class="card-title">{{ 'Rp. ' . number_format($orders->total_harga) }}</h5>
                        </div>
                        <div class="mb-3 mt-1">
                            <div class="alert bg-secondary d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                    role="img" aria-label="Warning:">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                                <div>
                                    Segera melakukan pembayaran dikasir, Terima kasih.
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3 mt-2">
                                <h6 class="card-title">-- Opsi gula :</h6>
                                <p class="text-body">
                                    <span class="badge bg-primary">{{ $orders->opsi }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="mb-3 mt-2">
                            <h6 class="card-title">-- Catatan :</h6>
                            <p class="text-body">
                                {{ $orders->catatan }}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="mt-5 mb-2">

                    <a href="{{ route('pesanan.selesai') }}" class="col-12 btn btn-outline-primary">Selesai</a>

                </div>
            </div>

        </div>
    </div>


    @include('frondsite.partials.footer')
@endsection
