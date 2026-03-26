@extends('frondsite.layout.main')

@section('container')
    <div class="row">

        <!-- HEADER -->
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between">

                <a href="{{ url()->previous() }}"
                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;">
                    <i class="fa fa-arrow-left text-dark"></i>
                </a>

                <h6 class="fw-semibold mb-0">Ubah Menu</h6>

                <div style="width:38px;"></div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <!-- IMAGE -->
                <img src="{{ asset('storage/' . $pesanan['gambar']) }}" class="w-100"
                    style="height:200px; object-fit:cover;">

                <div class="card-body p-3">

                    <!-- TITLE -->
                    <h5 class="fw-semibold mb-1">
                        {{ $pesanan['nama'] }}
                    </h5>

                    <!-- PRICE -->
                    <h6 class="text-primary fw-bold mb-3">
                        Rp {{ number_format($pesanan['harga']) }}
                    </h6>

                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $pesanan['id'] }}">
                        <input type="hidden" name="nama" value="{{ $pesanan['nama'] }}">
                        <input type="hidden" name="harga" value="{{ $pesanan['harga'] }}">
                        <input type="hidden" name="gambar" value="{{ $pesanan['gambar'] }}">

                        <!-- CATATAN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold mb-1">
                                Catatan <span class="text-muted fw-normal">(Opsional)</span>
                            </label>

                            <textarea class="form-control rounded-3" name="catatan" rows="2"
                                placeholder="Contoh: tidak pedas, tanpa bawang...">{{ $pesanan['catatan'] }}</textarea>
                        </div>

                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
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
                            Simpan Perubahan
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>
@endsection
