@extends('frondsite.layout.main')



@section('container')
    @include('frondsite.partials.navbar')

    <div class="row">
        <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-3">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/" class="btn btn-primary"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h4 class="mt-2">Checkout</h4>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        {{-- <form action="{{ route('hapus.keranjang') }}" method="post"> --}}
                        <form action="">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 product-item bg-primary">
                    <div class="card-body">
                        <h6 class="text-white">Perhatian !!</h6>
                        <p class="card-text text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam sint
                            similique
                            veniam consequatur ratione expedita temporibus </p>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 col-sm-12 product-item">
                    <div class="card-body">


                        <div class="order-md-last">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class=""> + Keranjang anda</h6>
                            </h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <ul class="list-group mb-3">
                                @forelse ($keranjang as $item)
                                    <li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div class="d-flex align-items-start gap-2">
                                            <img src="{{ asset('storage/' . $item['gambar']) }}" alt="Growers cider"
                                                class="img-fluid rounded" style="width: 100px; height: 100px;">
                                            <div class="card-body">
                                                <h6 class="mb-0 mt-4">{{ $item['nama'] }}</h6>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <small class="text-body-secondary">
                                                <form action="{{ route('add.item') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <div class="input-group product-qty m-1">
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
                                                                class="form-control input-number"
                                                                value="{{ $item['qty'] }}">
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
                                                        <button type="submit" class="btn btn-primary btn-sm ">
                                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </small>
                                            <p class="text-body-secondary">{{ 'Rp.' . number_format($item['harga']) }}</p>
                                        </div>
                                        <div class="mt-5 m-1">
                                            <a href="{{ route('hapus.cartitemcekout', $item['id']) }}"
                                                class="btn btn-outline-dark ms-2">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
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

                <div class="col-md-12 col-lg-12 col-sm-12 product-item">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="">* Detail transaksi</h6>
                    </h4>
                    <div class="card-body mb-4">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <thead>

                                    <tr>
                                        <td><b>Meja</b></td>
                                        <td>:</td>
                                        <td><strong>2</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi</td>
                                        <td>:</td>
                                        <td>Garden</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr>
                                        </td>
                                        <td>
                                            <hr>
                                        </td>
                                        <td>
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total item</td>
                                        <td>:</td>
                                        <td>{{ $total_item }} <i>(item)</i></td>
                                    </tr>
                                    <tr>
                                        <td>Total harga</td>
                                        <td>:</td>
                                        <td>{{ 'Rp.' . number_format($total_harga) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>PPN</b></td>
                                        <td>:</td>
                                        <td>Rp.4000</td>
                                    </tr>
                                    <tr class="bg-dark text-white">
                                        <td><b>Bayar</b></td>
                                        <td>:</td>
                                        <td><b>{{ 'Rp.' . number_format($total_harga + 4000) }}</b></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="order-md-last ">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="">* Detail pemesanan</h6>
                            </h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" id="payment-form" action="{{ route('checkout.proses') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="card-body mt-3">
                                        <div class="mb-3">
                                            <p for="nama" class="form-label"><strong>Nama</strong></p>
                                            <input type="text" name="nama"
                                                class="form-control rounded-start rounded-0 bg-light" id="nama"
                                                placeholder="Masukan nama..." required>
                                        </div>
                                        <div class="mb-3">
                                            <p for="meja" class="form-label"><strong>Meja</strong></p>
                                            <input type="text" name="meja"
                                                class="form-control rounded-start rounded-0 bg-light" id="meja"
                                                placeholder="3" value="3" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-4">
                                    <p for="catatan" class="form-label"><strong>Catatan</strong></p>
                                    <textarea name="catatan" id="catatan" rows="4" class="form-control rounded-start rounded-0 bg-light"></textarea>
                                </div>
                                <div class="mb-5 mt-4">
                                    <p for="opsi_gula" class="form-label"><strong>Opsi gula</strong></p>
                                    <select class="form-select" name="opsi_gula" id="opsi_gula"
                                        aria-label="Default select example" required>
                                        <option value="" selected disabled>Pilih opsi gula</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Less">Less</option>
                                        <option value="Tanpa Gula">Tanpa Gula</option>
                                    </select>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label><b>Metode Pembayaran</b></label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode" id="tunai"
                                            value="tunai" checked>
                                        <label class="form-check-label" for="tunai">Tunai (Bayar di Kasir)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metode" id="midtrans"
                                            value="midtrans">
                                        <label class="form-check-label" for="midtrans">Bayar Sekarang (Midtrans)</label>
                                    </div>
                                </div>

                                <button type="submit" id="pay-button" class="col-12 btn btn-primary">
                                    Pesan
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
        integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#payment-form').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = $(form).serializeArray();
                const paymentMethod = $("input[name='metode']:checked").val();

                $.ajax({
                    url: '/order/process',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            if (paymentMethod === 'midtrans' && response.snap_token) {
                                // Buka popup Midtrans
                                snap.pay(response.snap_token, {
                                    onSuccess: function(result) {
                                        window.location.href = '/order/success/' +
                                            response.order_id;
                                    },
                                    onPending: function(result) {
                                        window.location.href = '/order/pending/' +
                                            response.order_id;
                                    },
                                    onError: function(result) {
                                        window.location.href = '/order/failed/' +
                                            response.order_id;
                                    }
                                });
                            } else {
                                window.location.href = `{{ route('detail.pemesananuser', '') }}/${response.order_id}`;
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    }
                });
            });
          
        });
    </script>

    @include('frondsite.partials.footer')
@endsection


