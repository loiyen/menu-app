@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">
        <div class="col-lg-12">
            <!-- HEADER -->
            <div class="mb-3 mt-2">
                <div class="d-flex align-items-center justify-content-between py-2">


                    <a href="/"
                        class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                        style="width:38px;height:38px;">
                        <i class="fa fa-arrow-left text-dark"></i>
                    </a>

                    <!-- Title -->
                    <h6 class="fw-semibold mb-0 text-dark">
                        Pesanan
                    </h6>

                    <!-- Placeholder -->
                    <div style="width:38px;"></div>

                </div>
            </div>

            <!-- TIPE PESANAN -->
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-3 d-flex justify-content-between align-items-center">

                        <!-- Left -->
                        <div class="d-flex align-items-center gap-2">

                            <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center"
                                style="width:36px;height:36px;">
                                <i class="fa fa-utensils text-success"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Tipe Pesanan
                                </small>
                                <span class="fw-semibold text-dark">
                                    Makan di tempat
                                </span>
                            </div>

                        </div>

                        <!-- Status -->
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                            <i class="fa fa-check me-1"></i> Aktif
                        </span>

                    </div>

                </div>
            </div>

            <div class="row">
                @include('frondsite.partials.category2')

                <div class="col-md-12 col-lg-12 col-sm-12 mb-3 product-item">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="order-md-last">

                            <!-- HEADER -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-semibold mb-0">
                                    Item dipesan ({{ $total_item }})
                                </h6>

                                <a href="/" class="btn btn-primary btn-sm rounded-pill">
                                    <i class="fa fa-plus me-1"></i> Tambah
                                </a>
                            </div>

                            <!-- LIST -->
                            @forelse ($keranjang as $item)
                                <div class="card border-0 shadow-sm rounded-4 mb-3 p-3 cart-item">

                                    <!-- TOP -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">

                                        <div>
                                            <h6 class="fw-semibold mb-1 text-dark">
                                                {{ $item['nama'] }}
                                            </h6>

                                            @if ($item['catatan'])
                                                <small class="text-muted">
                                                    {{ $item['catatan'] }}
                                                </small>
                                            @else
                                                <small class="text-muted fst-italic">
                                                    Tidak ada catatan
                                                </small>
                                            @endif
                                        </div>

                                        <a href="{{ route('ubah.pesanan', $item['id']) }}"
                                            class="btn btn-light btn-sm rounded-pill">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                    </div>

                                    <!-- PRICE -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                        <span class="fw-semibold text-primary">
                                            Rp {{ number_format($item['total']) }}
                                        </span>

                                    </div>

                                    <!-- QTY -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="input-group input-group-sm" style="width:110px;">
                                            <button type="button" class="btn btn-light border quantity-left-minus"
                                                data-id="{{ $item['id'] }}">
                                                -
                                            </button>

                                            <input type="text" id="quantity-{{ $item['id'] }}"
                                                class="form-control text-center qty-input" value="{{ $item['qty'] }}"
                                                readonly>

                                            <button type="button" class="btn btn-light border quantity-right-plus"
                                                data-id="{{ $item['id'] }}">
                                                +
                                            </button>

                                        </div>

                                        <small class="text-muted">Maks 10</small>

                                    </div>

                                </div>

                            @empty

                                <!-- EMPTY -->
                                <div class="text-center py-5">
                                    <img src="{{ asset('images/cart1.png') }}" width="120" class="mb-3 opacity-75">
                                    <h6 class="fw-semibold mb-1">Keranjang kosong</h6>
                                    <small class="text-muted">Yuk tambahkan menu favoritmu</small>
                                </div>
                            @endforelse

                        </div>

                    </div>
                </div>

                <div class="col-12 mb-5">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-3">

                            <!-- TITLE -->
                            <h6 class="fw-semibold mb-3 text-dark">
                                Rincian Pembayaran
                            </h6>

                            <!-- SUBTOTAL -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">
                                    Subtotal ({{ $total_item }} menu)
                                </span>
                                <span class="fw-semibold">
                                    Rp {{ number_format($total_harga) }}
                                </span>
                            </div>

                            <!-- BIAYA LAIN -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">
                                    PPN
                                </span>
                                <span class="text-muted">
                                    Rp 4.000
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-5"></div>

                <div class="fixed-bottom bg-white border-top shadow-sm">

                    <div class="container py-2">

                        <div class="d-flex align-items-center justify-content-between">

                            <!-- TOTAL -->
                            <div>
                                <small class="text-muted d-block">
                                    Total Pembayaran
                                </small>
                                <span class="fw-bold text-primary fs-5">
                                    Rp {{ number_format($total_harga + 4000) }}
                                </span>
                            </div>

                            <!-- BUTTON -->
                            <a href="/pembayaran-pesanan" class="btn btn-primary rounded-pill px-4 fw-semibold">
                                Bayar
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ajax-tambah-kurang item --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let reloadTimer;

            function updateQty(id, qty) {

                fetch("{{ route('add.item') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            id: id,
                            qty: qty
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Gagal update (HTTP " + response.status + ")");
                        }
                        return response.json().catch(() => null); // aman kalau bukan JSON
                    })
                    .then(data => {
                        console.log("Update sukses:", data);

                        // 🔥 reload hanya jika sukses
                        clearTimeout(reloadTimer);
                        reloadTimer = setTimeout(() => {
                            location.reload();
                        }, 300);

                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Gagal update quantity");
                    });
            }

            // ➕ PLUS
            document.querySelectorAll(".quantity-right-plus").forEach(btn => {
                btn.addEventListener("click", function() {

                    let id = this.dataset.id;
                    let input = document.getElementById("quantity-" + id);
                    let qty = parseInt(input.value) || 0;

                    if (qty >= 10) return;

                    qty++;
                    input.value = qty;

                    updateQty(id, qty);
                });
            });

            // ➖ MINUS
            document.querySelectorAll(".quantity-left-minus").forEach(btn => {
                btn.addEventListener("click", function() {

                    let id = this.dataset.id;
                    let input = document.getElementById("quantity-" + id);
                    let qty = parseInt(input.value) || 0;

                    if (qty <= 1) return;

                    qty--;
                    input.value = qty;

                    updateQty(id, qty);
                });
            });

        });
    </script>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
