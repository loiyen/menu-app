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
        <form action="{{ route('order.create') }}" method="POST">
        @csrf
        <div class="col-12 product-item mb-3">
            <div class="card-body">
                <h6>Informasi Pemesan</h6>
                <div class="">
                        <div class="mb-4">
                            <label for="nama" class="form-label"><small>Nama Lengkap</small></label>
                            <div class="input-group ">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap"
                                    aria-label="Nama" aria-describedby="basic-addon1" required value="Jery Hardianto">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><small>Nomor Ponsel (info promosi)</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Ponsel"
                                    aria-label="Phone" aria-describedby="basic-addon1" value="08123456789">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label"><small>Kirim struk ke email</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    aria-label="Email" aria-describedby="basic-addon1" value="jeryhardianto@gmail.com">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="catatan" class="form-label"><small>Catatan</small></label>
                            <textarea class="form-control" id="catatan" name="catatan" placeholder="Catatan tambahan (opsional)" rows="2">Halo, saya ingin makan di tempat</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="nomorMeja" class="form-label"><small>Nomor Meja</small></label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" value="JT12" id="nomorMeja" disabled>
                            </div>
                        </div>
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
                            <label class="form-check-label d-flex align-items-center" for="metodeMidtrans">
                                <span class="m-2"><i class="fa fa-qrcode"></i></span>
                                <b>QRIS</b>
                            </label>
                            <input class="form-check-input me-2" type="radio" name="metode" id="metodeMidtrans" required checked>
                        </div>
                        @error('metode') <small class="text-danger">{{ $message }}</small> @enderror
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
                        <button type="submit" class="btn btn-primary col-12"><small>Bayar</small></button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
