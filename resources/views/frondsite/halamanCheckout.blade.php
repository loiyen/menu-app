@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">

        <div class="col-lg-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h6 class="mt-2">Pesanan</h6>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>

            <div class="col-12 product-item bg-danger-subtle mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-1 mt-1" style="color: rgb(97, 97, 97)">Tipe Pesananan</h6>
                        <h6 class="fw-bold mb-1 mt-1">Makan di tempat <span><i class="fa fa-check-square"></i></span></h6>
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
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 mt-2">Item yang dipesan ({{ $total_item }})</h6>
                                <a href="/" class="btn btn-outline-primary"><span><i class="fa fa-plus"></i> <small
                                            class="fw-bold">Tambah
                                            Item</small></span></a>
                            </div>
                            <ul class="list-group mb-3">
                                @forelse ($keranjang as $item)
                                    <div class="col-12">
                                        <div class="card-body">
                                            <hr>
                                            {{-- info --}}
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="card-title fw-bold text-black">{{ $item['nama'] }}</p>
                                                <a href="{{ route('ubah.pesanan', $item['id']) }}"
                                                    class="text-decoration-none btn btn-sm btn-outline-danger"><small
                                                        class="fw-bold"><i class="fa fa-pencil"></i>
                                                        Ubah</small></a>
                                            </div>
                                            {{-- catatan --}}
                                            <div class="mb-2">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <span class="input-group-text"><i class="fa fa-file"></i></span>
                                                    <input type="text" class="form-control" name="catatan" readonly
                                                        placeholder="Belum ada catatan..."
                                                        value="{{ $item['catatan'] }}"></input>

                                                </div>
                                                <div class="mb-2">
                                                    <h6>{{ 'Rp' . number_format($item['total']) }}</h6>
                                                </div>
                                            </div>
                                            {{-- optional --}}
                                            <div class="mb-2">
                                                <small class="text-body-secondary">
                                                    <form id="cart-form-{{ $item['id'] }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="input-group product-qty">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                                        data-id="{{ $item['id'] }}">
                                                                        <svg width="16" height="16">
                                                                            <use xlink:href="#minus"></use>
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="qty"
                                                                    id="quantity-{{ $item['id'] }}"
                                                                    class="form-control input-number"
                                                                    value="{{ $item['qty'] }}">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-right-plus btn btn-primary btn-number"
                                                                        data-id="{{ $item['id'] }}">
                                                                        <svg width="16" height="16">
                                                                            <use xlink:href="#plus"></use>
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <small>Max.10</small>
                                                        </div>
                                                    </form>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    </li>
                                @empty
                                    <div class="text-center mt-5 mb-5">
                                        <img src="{{ asset('images/cart1.png') }}" width="20%" alt="cart">
                                    </div>
                                @endforelse
                            </ul>
                        </div>    
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-sm-12 mb-3 product-item">
                    <div class="mb-4 mt-2">
                        <h6 class="text-center">Rincian Pembayaran</h6>
                    </div>
                    <div class="card-body mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Subtotal <span style="color: rgb(80, 80, 80)">({{ $total_item }} menu)</span></h6>
                            <h6>{{ 'Rp' . number_format($total_harga) }}</h6>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6>Biaya lainnya</h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="">PPN</span>
                                </div>
                            </div>
                            <div>
                                <h6>Rp4,000</h6>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Total <span style="color: rgb(80, 80, 80)"></span></h6>
                            <h6 class="fw-bold" style="color: rgb(212, 0, 0)">
                                {{ 'Rp' . number_format($total_harga + 4000) }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 product-item">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span><small>Total Pembayaran</small></span>
                                <h5>{{ 'Rp' . number_format($total_harga + 4000) }}</h5>
                            </div>
                            <div>
                                <a href="/pembayaran-pesanan" class="btn btn-primary"><small>Lanjut Pembayaran</small></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ajax-tambah-kurang item --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi update qty via AJAX
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
                    .then(response => response.json())
                    .then(data => {
                        console.log("Update sukses:", data);
                         location.reload();
                    })
                    .catch(error => console.error("Error:", error));
            }

            // Tombol +
            document.querySelectorAll(".quantity-right-plus").forEach(btn => {
                btn.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    let qtyInput = document.getElementById("quantity-" + id);
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty < 10) {
                        qty++;
                        qtyInput.value = qty;
                        updateQty(id, qty);
                    }
                });
            });

            // Tombol -
            document.querySelectorAll(".quantity-left-minus").forEach(btn => {
                btn.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    let qtyInput = document.getElementById("quantity-" + id);
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty > 1) {
                        qty--;
                        qtyInput.value = qty;
                        updateQty(id, qty);
                    }
                });
            });
        });
    </script>

    {{-- @include('frondsite.partials.footer') --}}
@endsection
