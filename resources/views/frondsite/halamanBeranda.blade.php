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
                    <div></div>
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
            <div class="mb-4">
                <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-grid"></i> Kategori
                </h5>

                <div class="category-scroll pb-2">
                    <ul class="nav nav-pills flex-nowrap gap-2">

                        @foreach ($kategori as $category)
                            <li class="nav-item">
                                <button
                                    class="nav-link category-pill d-flex align-items-center gap-2 px-3 py-2 rounded-pill {{ $loop->first ? 'active' : '' }}"
                                    data-bs-toggle="tab" data-bs-target="#nav-{{ $category->id }}">

                                    <i class="bi bi-tag"></i>
                                    <span class="text-truncate">{{ $category->nama }}</span>
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

                        <div class="menu-scroll-vertical mt-2">

                            @forelse ($kat->menu as $item)
                                <!-- CARD MENU -->
                                <div class="col-12 col-sm-3 col-md-4 col-lg-3">
                                    <div
                                        class="menu-scroll d-flex gap-3 pb-2 card menu-card border-0 shadow-sm rounded-4 h-100">

                                        <!-- Image -->
                                        <a href="{{ route('detail.menu', $item->id) }}">
                                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                                class="card-img-top rounded-top-4 menu-img">
                                        </a>

                                        <!-- Body -->
                                        <div class="card-body p-3 d-flex flex-column">

                                            <h6 class="fw-semibold mb-1 text-dark text-truncate">
                                                {{ $item->nama }}
                                            </h6>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-primary fw-bold">
                                                    Rp {{ number_format($item->harga) }}
                                                </small>
                                                <small class="text-muted">Max 10</small>
                                            </div>

                                            <!-- Spacer -->
                                            <div class="mt-auto">
                                                <form action="{{ route('cart.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="nama" value="{{ $item->nama }}">
                                                    <input type="hidden" name="harga" value="{{ $item->harga }}">
                                                    <input type="hidden" name="gambar" value="{{ $item->gambar }}">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between mb-3 mt-3">
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
                                                                class="form-control input-number text-center"
                                                                value="1">
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
                                                    <!-- BUTTON -->
                                                    <button type="submit"
                                                        class="btn btn-primary w-100 rounded-pill btn-sm fw-semibold">
                                                        + Tambah
                                                    </button>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="col-12">
                                    <div class="empty-state text-center px-3 py-5">

                                        <!-- SVG ICON -->
                                        <div class="empty-icon mb-3">
                                            <svg width="80" height="80" fill="none" viewBox="0 0 24 24">
                                                <path d="M3 7h18l-1.5 11a2 2 0 0 1-2 1.5h-11a2 2 0 0 1-2-1.5L3 7z"
                                                    stroke="#6c757d" stroke-width="1.5" />
                                                <path d="M9 11h6M10 15h4" stroke="#adb5bd" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                                <circle cx="9" cy="5" r="1" fill="#6c757d" />
                                                <circle cx="15" cy="5" r="1" fill="#6c757d" />
                                            </svg>
                                        </div>

                                        <h5 class="fw-semibold text-dark mb-2">
                                            Menu tidak tersedia
                                        </h5>

                                        <p class="text-muted small mb-3">
                                            Silakan pilih kategori lain atau coba lagi nanti
                                        </p>

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
