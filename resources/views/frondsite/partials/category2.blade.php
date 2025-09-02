<section class="py-3 overflow-hidden">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">
                    <h6 class="section-title">Menu lainnya</h6>
                    <div class="d-flex align-items-center">
                        <a href="#" class="btn-link text-decoration-none"><small>Tambah menu →</small></a>
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
                        @forelse ($menu as $item)
                            <div class="swiper-slide">
                                <div class="row g-0">
                                    <div id="menu-results" class="col">
                                        <div class="product-item h-100">
                                            <figure>
                                                <a href="{{ route('detail.menu', $item->id) }}" title="Product Title">
                                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                                        style="width: 100%; height: 100px;"  class="tab-image">
                                                </a>
                                            </figure>
                                            <h3 class="mt-0 mb-2">{{ $item->nama }}</h3>
                                            <span class="qty text-primary"><b>Tersedia</b></span>
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
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                        <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                                                    </button>
                                                </div>
                                            </form>
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
