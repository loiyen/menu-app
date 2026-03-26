<section class="py-5 overflow-hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">
                    <h5 class="section-title">Menu terbaru</h5>

                    <div class="d-flex align-items-center">
                        <a href="#" class="btn-link text-decoration-none"><small>Lihat semua menu →</small></a>
                        <div class="swiper-buttons">
                            <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                            <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="brand-carousel swiper">
                    <div class="swiper-wrapper">
                        @forelse ($menu_lain as $item)
                            <div class="swiper-slide">
                                <div class="row g-0">
                                    <div id="menu-results" class="col">

                                        <div class="card border-0 shadow-sm rounded-4 h-100 menu-card">

                                            <!-- Image -->
                                            <a href="{{ route('detail.menu', $item->id) }}">
                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    class="card-img-top rounded-top-4"
                                                    style="height:140px; object-fit:cover;">
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

                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="nama"
                                                            value="{{ $item->nama }}">
                                                        <input type="hidden" name="harga"
                                                            value="{{ $item->harga }}">
                                                        <input type="hidden" name="gambar"
                                                            value="{{ $item->gambar }}">

                                                        <!-- QTY -->
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="input-group input-group-sm"
                                                                style="width:120px;">
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
                                                                        class="form-control input-number"
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
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
