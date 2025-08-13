@if ($menus->count())
    <div class="row">
        @foreach ($menus as $item)
            <div class="col-md-12 mb-3">
                <div id="menu-results" class="col">
                    <div class="product-item">
                        <figure>
                            <a href="#" title="Product Title">
                                <img src="{{ asset('storage/' . $item->gambar) }}"  style="width: 100%; height: 170px;" class="tab-image">
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
                                        <button type="button" class="quantity-left-minus btn btn-danger btn-number"
                                            data-type="minus">
                                            <svg width="16" height="16">
                                                <use xlink:href="#minus"></use>
                                            </svg>
                                        </button>
                                    </span>
                                    <input type="number" name="qty" id="quantity" class="form-control input-number"
                                        min="1" value="1">

                                    <span class="input-group-btn">
                                        <button type="button" class="quantity-right-plus btn btn-primary btn-number"
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
        @endforeach
    </div>
@else
    <div class="col mb-5 mt-5">
        <div class="text-center mt-5">
            <img src="images/notfound.png" width="10%" alt="not found">
            <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
        </div>
    </div>
@endif


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('search-menu');
        const resultDiv = document.getElementById('menu-results');

        // Live search AJAX
        input.addEventListener('keyup', function() {
            const keyword = input.value.trim();
            if (keyword.length === 0) {
                resultDiv.innerHTML = ""; // Kosongkan hasil jika input kosong
                return;
            }

            fetch(`/menu/search-live?keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.text())
                .then(html => {
                    resultDiv.innerHTML = html; // Isi ulang hasil
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                });
        });

        // Event delegation untuk tombol + dan -
        resultDiv.addEventListener('click', function(e) {
            const isPlus = e.target.classList.contains('quantity-right-plus');
            const isMinus = e.target.classList.contains('quantity-left-minus');

            if (isPlus || isMinus) {
                const product = e.target.closest('.product-item');
                if (!product) return;

                const input = product.querySelector('.input-number');
                let value = parseInt(input.value) || 1;

                if (isPlus) {
                    input.value = value + 1;
                } else if (isMinus && value > 1) {
                    input.value = value - 1;
                }
            }
        });
    });
</script> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-menu');
    const resultDiv = document.getElementById('menu-results');

    // Hanya jalankan jika elemen pencarian ada
    if (searchInput && resultDiv) {
        searchInput.addEventListener('keyup', function () {
            const keyword = searchInput.value.trim();
            if (keyword.length === 0) {
                resultDiv.innerHTML = "";
                return;
            }

            fetch(`/menu/search-live?keyword=${encodeURIComponent(keyword)}`)
                .then(response => response.text())
                .then(html => {
                    resultDiv.innerHTML = html;
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                });
        });
    }

    // ✅ Gunakan event delegation untuk menangani +/– meskipun DOM diganti oleh AJAX
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('quantity-right-plus') || e.target.classList.contains('quantity-left-minus')) {
            const product = e.target.closest('.product-item');
            if (!product) return;

            const input = product.querySelector('.input-number');
            let value = parseInt(input.value) || 1;

            if (e.target.classList.contains('quantity-right-plus')) {
                input.value = value + 1;
            } else if (e.target.classList.contains('quantity-left-minus') && value > 1) {
                input.value = value - 1;
            }
        }
    });
});
</script>
