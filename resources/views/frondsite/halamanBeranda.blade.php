@extends('frondsite.layout.main')

@section('container')

    @include('frondsite.partials.navbar')
    <div class="col-12 mt-0 mb-3">
        <div class="card rounded-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mt-0 mb-0">Digiz Coffee & Eatery</h6>
                        <small>Buka hari ini, 15:00 - 01:00</small>
                    </div>
                    <div class="">
                        <span><a href="/info-jam"><i class="fa fa-arrow-right" style="color: rgb(84, 84, 84)"
                                    aria-hidden="true"></i></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('nomor_meja'))
        <div class="col-12 mt-0 mb-4 ">
            <div class="card rounded-sm" style="background-color: rgb(255, 252, 214); height:50px;">
                <div class="card-body">
                    <h6 class="text-center text-dark">Anda memesan dari <strong> Meja : {{ session('nomor_meja') }} 
                    </h6>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div class="bootstrap-tabs product-tabs">
            <div class="tabs-header border-bottom pb-2 mb-3">
                <h5 class="fw-semibold mb-2">Kategori</h5>
                <div class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap gap-2" id="nav-tab" role="tablist">

                        @foreach ($kategori as $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-3 text-nowrap {{ $loop->first ? 'active' : '' }}"
                                    id="nav-{{ $category->id }}-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-{{ $category->id }}" type="button" role="tab">

                                    {{ $category->nama }}

                                </button>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="tab-content" id="nav-tabContent ">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <p>Warning! {{ $error }}</p>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @foreach ($kategori as $kat)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="nav-{{ $kat->id }}"
                        role="tabpanel" aria-labelledby="nav-{{ $kat->id }}-tab">

                        <div class="row mt-4">
                            @forelse ($kat->menu as $item)
                                <div id="menu-results" class="col-6 col-md-3 col-lg-3">
                                    <div class="product-item">
                                        <figure>
                                            <a href="{{ route('detail.menu', $item->id) }}" title="Product Title">
                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    style="width: 100%; height: 100px;" class="tab-image">

                                            </a>
                                        </figure>
                                        <h3 class="mt-0 mb-2">{{ $item->nama }}</h3>
                                        <h6 class="mt-2 mb-2">{{ 'Rp.' . number_format($item->harga) }}</h6>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="nama" value="{{ $item->nama }}">
                                            <input type="hidden" name="harga" value="{{ $item->harga }}">
                                            <input type="hidden" name="gambar" value="{{ $item->gambar }}">
                                            <div class="">
                                                <div class="d-flex align-items-center justify-content-between mb-3 mt-3">
                                                    <div class="input-group product-qty">
                                                        <span class="input-group-btn ">
                                                            <button type="button"
                                                                class="quantity-left-minus btn btn-danger btn-number"
                                                                data-type="minus">
                                                                <svg width="16" height="16">
                                                                    <use xlink:href="#minus"></use>
                                                                </svg>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="qty" id="quantity"
                                                            class="form-control input-number" value="1">
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
                                                    <small>Max:10</small>
                                                </div>
                                                <button type="submit" class="col-12 btn btn-outline-primary btn-sm">
                                                    Tambah
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col mb-5 mt-5">
                                    <div class="text-center mt-5">
                                        <img src="images/notfound.png" width="10%" alt="not found">
                                        <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('frondsite.partials.category')
    {{-- @include('frondsite.partials.navbarfooter') --}}
    {{-- @include('frondsite.partials.footer') --}}
@endsection
