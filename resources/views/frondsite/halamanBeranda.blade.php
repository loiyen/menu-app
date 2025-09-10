@extends('frondsite.layout.main')

@section('container')

    @include('frondsite.partials.navbar')
    <div class="col-12 mt-0 mb-3">
        <div class="card rounded-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mt-0 mb-0">Kafe Lundayeh</h6>
                        <small>Buka hari ini, 09:00-01:00</small>
                    </div>
                    <div class=""> 
                        <span><a href="/info-jam"><i class="fa fa-arrow-right" style="color: rgb(84, 84, 84)" aria-hidden="true"></i></a></span>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col-12 mt-0 mb-4 ">
        <div class="card rounded-sm" style="background-color: rgb(255, 252, 214); height:50px;">
            <div class="card-body">
                <h6 class="text-center text-dark">Nomor Meja : JDA6 <b class="text-primary">
                        @if (session()->has('nomor_meja'))
                            <div class="alert alert-info">
                                Anda memesan dari <strong> Meja {{ session('nomor_meja') }}</strong>
                            </div>
                        @endif
                    </b>
                </h6>
            </div>

        </div>
    </div>

    <div class="col-md-12">
        <div class="bootstrap-tabs product-tabs">
            <div class="tabs-header d-flex justify-content-between border-bottom my-0 mt-0">
                <h5 class="mt-3 mb-2">Kategori</h5>
                <nav>
                    <div class="nav nav-tabs col-sm-12" id="nav-tab" role="tablist">
                        @foreach ($kategori as $category)
                            <a class="nav-link fs-6 {{ $loop->first ? 'active' : '' }}" id="nav-{{ $category->id }}-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-{{ $category->id }}" type="button" role="tab"
                                aria-controls="nav-{{ $category->id }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $category->nama }}
                            </a>
                        @endforeach
                    </div>
                </nav>
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
                                <div id="menu-results" class="col">
                                    <div class="product-item">
                                        <figure>
                                            <a href="{{ route('detail.menu', $item->id) }}" title="Product Title">
                                                {{-- <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    style="width: 100%; height: 100px;" class="tab-image"> --}}
                                                <img src="https://placehold.co/600x400/png" style="width: 100%; height: 100px;" class="tab-image">
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
                                            <div class="d-flex align-items-center justify-content-between">
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
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <iconify-icon icon="uil:shopping-cart"></iconify-icon>
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
