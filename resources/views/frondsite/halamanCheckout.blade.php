@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Pesanan</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>

            <div class="col-12 product-item bg-danger-subtle mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-1 mt-1" style="color: rgb(97, 97, 97)">Tipe Pesananan</h6>
                        <h6 class="fw-bold mb-1 mt-1">Makan di tempat <span><i class="fa fa-check-square"></i></span></h6>
                    </div>
                </div>
            </div>

            <div class="row">
                @include('frondsite.partials.category2')

                <div class="col-md-12 col-lg-12 col-sm-12 mb-3 product-item">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="order-md-last">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 mt-2">Item yang dipesan ({{ $total_item }})</h6>
                                <a href="/" class="btn btn-outline-danger"><span><i class="fa fa-plus"></i> <small
                                            class="fw-bold">Tambah
                                            Item</small></span></a>
                            </div>
                            <ul class="list-group mb-3">
                                @forelse ($keranjang as $item)
                                    <div class="col-12">
                                        <div class="card-body">
                                            <hr>
                                            {{-- info --}}
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="card-title fw-bold text-black">{{ $item['nama'] }}</p>
                                                <div></div>
                                            </div>
                                            {{-- catatan --}}
                                            <div class="mb-2">
                                                <form action="{{ route('update.catatan', $item['id']) }}" method="post">
                                                    @csrf
                                                    <div class="input-group mb-3">
                                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                                        <textarea type="text" class="form-control" name="catatan" placeholder="Tulis catatan...">{{ $item['catatan'] }}</textarea>
                                                        <button type="submit" class="input-group-text btn btn-primary"><i
                                                                class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                    </div>
                                                </form>
                                                <div class="mb-2">
                                                    <h6>{{ 'Rp' . number_format($item['total']) }}</h6>
                                                </div>
                                            </div>
                                            {{-- optional --}}
                                            <div class="mb-2">
                                                <small class="text-body-secondary">
                                                    <form action="{{ route('add.item') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="input-group product-qty">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                                        data-type="minus">
                                                                        <svg width="16" height="16">
                                                                            <use xlink:href="#minus"></use>
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="qty" id="quantity"
                                                                    class="form-control input-number"
                                                                    value="{{ $item['qty'] }}">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-right-plus btn btn-primary btn-number"
                                                                        data-type="plus">
                                                                        <svg width="16" height="16">
                                                                            <use xlink:href="#plus"></use>
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-sm ">
                                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                                    <span class="fw-bold"></span>
                                                                </button>
                                                                <a href="{{ route('hapus.cartitemcekout', $item['id']) }}"
                                                                    class="btn btn-outline-dark btn-sm">
                                                                    <span class="fw-bold"><i class="fa fa-trash fa-sm"
                                                                            aria-hidden="true"></i>
                                                                    </span>
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    </li>
                                @empty
                                    <div class="text-center mt-5 mb-5">
                                        <img src="{{ asset('images/cart1.png') }}" width="20%" alt="cart">
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                        <hr>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary col-12" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <h6 class="mt-1 mb-1 text-white"><span><i class="fa fa-pencil"></i></span><i> Tambah catatan
                                        lainnya</i></h6>
                            </button>
                            {{-- modal --}}
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalLabel">Catatan lainnya</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('update.catatanopsi') }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1"
                                                        class="form-label">Optional</label>
                                                    <textarea class="form-control" name="catatan_optional" placeholder="Tambahkan catatan lain di sini..."
                                                        rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Opsi
                                                        Gula</label>
                                                    <select class="form-select" name="opsi_gula"
                                                        aria-label="Default select example">
                                                        <option selected>Pilih --</option>
                                                        <option value="Normal">Normal</option>
                                                        <option value="Less">Less</option>
                                                        <option value="Tanpa gula">Tanpa gula</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary col-12">Tambah</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-sm-12 mb-3 product-item">
                    <div class="mb-4 mt-2">
                        <h6 class="text-center">Rincian Pembayaran</h6>
                    </div>
                    <div class="card-body mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Subtotal <span style="color: rgb(80, 80, 80)">({{ $total_item }} menu)</span></h6>
                            <h6>{{ 'Rp' . number_format($total_harga) }}</h6>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6>Biaya lainnya</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="">PPN</span>
                                </div>
                            </div>
                            <div>
                                <h6>Rp4,000</h6>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Total <span style="color: rgb(80, 80, 80)"></span></h6>
                            <h6 class="fw-bold" style="color: rgb(212, 0, 0)">
                                {{ 'Rp' . number_format($total_harga + 4000) }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 product-item">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span><small>Total Pembayaran</small></span>
                                <h5>{{ 'Rp' . number_format($total_harga + 4000) }}</h5>
                            </div>
                            <div>
                                <a href="/pembayaran-pesanan" class="btn btn-primary"><small>Lanjut Pembayaran</small></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
