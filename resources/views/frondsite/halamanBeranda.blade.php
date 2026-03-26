@extends('frondsite.layout.main')

@section('container')
    @include('frondsite.partials.navbar')
    <div class="col-12 mb-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">

                    <!-- Left Content -->
                    <div>
                        <h6 class="fw-semibold mb-1 text-dark">
                            Digiz Coffee & Eatery
                        </h6>
                        <small class="text-muted d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success fw-medium px-2 py-1 rounded-pill">
                                Buka
                            </span>
                            <span>Hari ini, 15:00 - 01:00</span>
                        </small>
                    </div>

                    <!-- Right Icon -->
                    <a href="/info-jam"
                        class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                        style="width: 38px; height: 38px;">
                        <i class="fa fa-arrow-right text-secondary"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
    @if (session()->has('nomor_meja'))
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning-subtle">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">

                        <!-- Icon -->
                        <i class="fa fa-chair text-warning"></i>

                        <!-- Text -->
                        <small class="text-dark mb-0">
                            Anda memesan dari
                            <span class="fw-semibold">Meja {{ session('nomor_meja') }}</span>
                        </small>

                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="col-12">

        <div class="card border-0 shadow-sm rounded-4 p-3">

            <!-- Header -->
            <div class="mb-3">
                <h5 class="fw-semibold mb-2">Kategori</h5>

                <div class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap gap-2">

                        @foreach ($kategori as $category)
                            <li class="nav-item">
                                <button class="nav-link rounded-pill px-3 small {{ $loop->first ? 'active' : '' }}"
                                    data-bs-toggle="tab" data-bs-target="#nav-{{ $category->id }}">

                                    {{ $category->nama }}
                                </button>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="tab-content">

                @foreach ($kategori as $kat)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="nav-{{ $kat->id }}">

                        <div class="row g-3 mt-1">

                            @forelse ($kat->menu as $item)
                                <!-- CARD MENU -->
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card border-0 shadow-sm rounded-4 h-100 menu-card">

                                        <!-- Image -->
                                        <a href="{{ route('detail.menu', $item->id) }}">
                                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                                class="card-img-top rounded-top-4" style="height:140px; object-fit:cover;">
                                        </a>

                                        <!-- Body -->
                                        <div class="card-body p-2 d-flex flex-column">

                                            <h6 class="fw-semibold mb-1 text-dark">
                                                {{ $item->nama }}
                                            </h6>

                                            <small class="text-primary fw-semibold mb-2">
                                                Rp {{ number_format($item->harga) }}
                                            </small>

                                            <!-- Spacer -->
                                            <div class="mt-auto">

                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="nama" value="{{ $item->nama }}">
                                                    <input type="hidden" name="harga" value="{{ $item->harga }}">
                                                    <input type="hidden" name="gambar" value="{{ $item->gambar }}">

                                                    <!-- QTY -->
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="input-group input-group-sm" style="width:120px;">
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
                                                        </div>

                                                        <small class="text-muted">Max 10</small>
                                                    </div>

                                                    <!-- BUTTON -->
                                                    <button type="submit"
                                                        class="btn btn-primary w-100 btn-sm rounded-pill">
                                                        + Tambah
                                                    </button>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="col-12">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                                        <div class="mb-3">
                                            <img src="images/notfound.png" width="90" class="opacity-75">
                                        </div>
                                        <h6 class="fw-semibold text-dark mb-1">
                                            Menu tidak tersedia
                                        </h6>
                                        <small class="text-muted mb-3">
                                            Silakan pilih kategori lain atau coba lagi nanti
                                        </small>
                                        <a href="#" class="btn btn-light btn-sm rounded-pill px-3">
                                            Refresh
                                        </a>

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
