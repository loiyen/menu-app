@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-center my-1">
                    <h5 class="mt-2">Ubah Menu</h5>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 mb-2">
            <div id="menu-results" class="col">
                <div class="product-item">
                    <figure>
                        <img src="{{ asset('storage/' . $pesanan['gambar']) }}" style="width: 100%; height: 130px;"
                            class="tab-image">
                    </figure>
                    <div class="mb-4">
                        <h3 class="mt-0 mb-2"><span></span>{{ $pesanan['nama'] }}</h3>
                        <h6 class="mt-2 mb-2">{{ 'Rp.' . number_format($pesanan['harga']) }}</h6>
                    </div>

                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $pesanan['id'] }}">
                        <input type="hidden" name="nama" value="{{ $pesanan['nama'] }}">
                        <input type="hidden" name="harga" value="{{ $pesanan['harga'] }}">
                        <input type="hidden" name="gambar" value="{{ $pesanan['gambar'] }}">
                        <div class="mb-2">
                            <h6>Catatan <br><small style="color: rgb(173, 173, 173)">Opsional</small></h6>
                            <div>
                                <div class="mb-3">
                                    <textarea class="form-control" name="catatan"  placeholder="Tulis catatan..." id="exampleFormControlTextarea1"
                                        rows="3">{{ $pesanan['catatan'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="input-group product-qty">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number"
                                        data-type="minus">
                                        <svg width="16" height="16">
                                            <use xlink:href="#minus"></use>
                                        </svg>
                                    </button>
                                </span>
                                <input type="text" name="qty" id="quantity" class="form-control input-number"
                                    value="{{ $pesanan['qty'] }}">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-right-plus btn btn-primary btn-number"
                                        data-type="plus">
                                        <svg width="16" height="16">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="col-12 btn btn-outline-primary">
                            Perbaharui - Pesanan
                        </button>
                    </form>
                </div>
            </div>


        </div>
    @endsection
