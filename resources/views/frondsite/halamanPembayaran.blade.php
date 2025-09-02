@extends('frondsite.layout.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/checkout"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Pembayaran</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
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

        <div class="col-12 product-item mb-3">
            <div class="card-body">
                <h6>Informasi Pemesan</h6>
                <div class="">
                    <form action="">
                        <div class="mb-4">
                            <label for="username" class="form-label"><small>Nama Lengkap</small></label>
                            <div class="input-group ">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Nama Lengkap"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><small>Nomor Ponsel (info promosi)</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Nomor Ponsel"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="username" class="form-label"><small>Kirim struk ke email</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Email"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="username" class="form-label"><small>Nomor Meja</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" value="JT12" disabled>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 product-item mb-3">
            <div class="card-body">
                <h6 class="">Pembayaran</h6>
                <div class="card mt-4 mb-3 bg-primary">
                    <div class="card-body">
                        <small class="text-white">Mohon untuk tidak pindah meja, setelah pembayaran sukses.</small>
                    </div>
                </div>
                <div class="">
                    <div class="card-body">
                        <p>Metode Pembayaran</p>
                        <div class="form-check d-flex align-items-center justify-content-between mb-1">
                            <label class="form-check-label d-flex align-items-center" for="flexRadioDefault1">
                                <span class="m-2"><i class="fa fa-qrcode"></i></span>
                                <b>QRIS</b>
                            </label>
                            <input class="form-check-input me-2" type="radio" name="flexRadioDefault"
                                id="flexRadioDefault1">
                        </div>
                    </div>
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
                    <div></div>
                    <div class="col-6">
                        <button class="btn btn-primary col-12"><small>Bayar</small></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
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
                                // Proses midtrans
                                snap.pay(response.snap_token, {
                                    onSuccess: function(result) {
                                        window.location.href = '/detailpemesanan/' +
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
                                // Untuk metode tunai atau lainnya
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pesanan Berhasil!',
                                    text: response.message ||
                                        'Pesanan Anda telah berhasil dibuat',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location.href =
                                        `/detailpemesanan/${response.order_id}`;
                                });
                            }
                        } else {
                            alert(response.message);
                        }
                    }
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    }
                });
            });

        });
    </script> --}}

    {{-- @include('frondsite.partials.footer') --}}
@endsection
