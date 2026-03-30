@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-12 mb-3 mt-2">

            <div class="detail-header d-flex align-items-center justify-content-between py-2">

                <!-- BACK BUTTON -->
                <a href="/" class="back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>

                <!-- TITLE -->
                <h6 class="fw-semibold mb-0 text-dark text-center flex-grow-1">
                    Detail Menu
                </h6>

                <!-- RIGHT SPACE / OPTIONAL ACTION -->
                <div class="header-action"></div>

            </div>

        </div>

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <!-- IMAGE -->
                <img src="{{ asset('storage/' . $menu->gambar) }}" class="w-100" style="height:220px; object-fit:cover;">

                <!-- BODY -->
                <div class="card-body p-3">

                    <!-- TITLE -->
                    <h5 class="fw-semibold mb-1">
                        {{ $menu->nama }}
                    </h5>

                    <!-- PRICE -->
                    <h6 class="text-primary fw-bold mb-3">
                        Rp {{ number_format($menu->harga) }}
                    </h6>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $menu->id }}">
                        <input type="hidden" name="nama" value="{{ $menu->nama }}">
                        <input type="hidden" name="harga" value="{{ $menu->harga }}">
                        <input type="hidden" name="gambar" value="{{ $menu->gambar }}">

                        <!-- CATATAN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold mb-1">
                                Catatan <span class="text-muted fw-normal">(Opsional)</span>
                            </label>

                            <textarea class="form-control rounded-3" name="catatan" placeholder="Contoh: tidak pedas, tanpa bawang..."
                                rows="2"></textarea>
                        </div>

                        <!-- QTY -->
                        <div class="d-flex align-items-center justify-content-between mb-3">

                            <div class="input-group input-group-sm" style="width:120px;">
                                <div class="input-group product-qty">
                                    <span class="input-group-btn ">
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
                            </div>

                            <small class="text-muted">Maks 10</small>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                            + Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @include('frondsite.partials.category')
        {{-- @include('frondsite.partials.navbarfooter') --}}
        {{-- @include('frondsite.partials.footer') --}}
    @endsection
