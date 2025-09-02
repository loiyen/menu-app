@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Detail Menu</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 mb-2">

            <div id="menu-results" class="col">
                <div class="product-item">
                    <figure>
                        <a href="{{ route('detail.menu', $menu->id) }}" title="Product Title">
                            <img src="{{ asset('storage/' . $menu->gambar) }}" style="width: 100%; height: 130px;"
                                class="tab-image">
                        </a>
                    </figure>
                    <div class="mb-4">
                        <h3 class="mt-0 mb-2"><span></span>{{ $menu->nama }}</h3>
                        <h6 class="mt-2 mb-2">{{ 'Rp.' . number_format($menu->harga) }}</h6>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $menu->id }}">
                        <input type="hidden" name="nama" value="{{ $menu->nama }}">
                        <input type="hidden" name="harga" value="{{ $menu->harga }}">
                        <input type="hidden" name="gambar" value="{{ $menu->gambar }}">
                        <div class="mb-2">
                            <h6>Catatan</h6>
                            <small>Opsional</small>
                            <div>
                                <div class="mb-3">
                                    <textarea class="form-control" name="catatan" placeholder="Tulis catatan..." id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
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
                                    value="1">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-right-plus btn btn-primary btn-number"
                                        data-type="plus">
                                        <svg width="16" height="16">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus" aria-hidden="true"></i> Tambah
                                <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>

        @include('frondsite.partials.category')
        {{-- @include('frondsite.partials.navbarfooter') --}}
        {{-- @include('frondsite.partials.footer') --}}
    @endsection
