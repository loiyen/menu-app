@if ($menus->count())
    <div class="row">
        @foreach ($menus as $item)
            <div class="col-md-12 mb-3">
                <div id="menu-results" class="col">
                    <div class="product-item">
                        <figure>
                            <a href="#" title="Product Title">
                                <img src="{{ asset('storage/' . $item->gambar) }}" style="width: 100%; height: 170px;"
                                    class="tab-image">
                            </a>
                        </figure>
                        <h3 class="mt-0 mb-2">{{ $item->nama }}</h3>
                        <h6 class="mt-2 mb-4">{{ 'Rp.' . number_format($item->harga) }}</h6>
                        <div>
                            <a href="{{ route('detail.menu', $item->id) }}" type="submit" class="col-12 btn btn-primary">
                                Lihat menu
                            </a>
                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-menu');
        const resultDiv = document.getElementById('menu-results');

        // Hanya jalankan jika elemen pencarian ada
        if (searchInput && resultDiv) {
            searchInput.addEventListener('keyup', function() {
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
        document.body.addEventListener('click', function(e) {
            if (e.target.classList.contains('quantity-right-plus') || e.target.classList.contains(
                    'quantity-left-minus')) {
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
