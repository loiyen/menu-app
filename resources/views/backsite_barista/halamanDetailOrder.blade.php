@extends('backsite_barista.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="/dashboardbarista" class="btn btn-sm btn-warning">Kembali</a>
                            <p>{{ $detail->order_id }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="card-body mt-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <td><b>Nama customer</b></td>
                                                    <td>:</td>
                                                    <td><b>{{ $detail->nama }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if ($detail->status == 'menunggu')
                                                            <span
                                                                class="badge bg-label-primary">{{ $detail->status }}</span>
                                                        @elseif($detail->status == 'diproses')
                                                            <span
                                                                class="badge bg-label-warning">{{ $detail->status }}</span>
                                                        @elseif($detail->status == 'selesai')
                                                            <span
                                                                class="badge bg-label-success">{{ $detail->status }}</span>
                                                        @elseif($detail->status == 'dibatalkan')
                                                            <span class="badge bg-label-danger">{{ $detail->status }}</span>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>:</td>
                                                    <td>{{ tanggal_indo($detail->waktu_pesan) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jam</td>
                                                    <td>:</td>
                                                    <td>{{ format_jam($detail->waktu_pesan) }}</td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="card-body mt-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <td><b>Meja</b></td>
                                                    <td>:</td>
                                                    <td><b>{{ $detail->meja->nomor_meja }}
                                                        </b></td>
                                                </tr>
                                                <tr>
                                                    <td>Lokasi</td>
                                                    <td>:</td>
                                                    <td><b>{{ $detail->meja->lokasi }}
                                                            </i></b></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h6 class="card-title">-- Opsi gula</h6>
                                                    <p class="card-text">
                                                        @if ($detail->opsi == 'normal')
                                                            <span
                                                                class="badge rounded-pill text-bg-primary">{{ $detail->opsi }}
                                                            </span>
                                                        @elseif($detail->opsi == 'less')
                                                            <span
                                                                class="badge rounded-pill text-bg-warning">{{ $detail->opsi }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge rounded-pill text-bg-success">{{ $detail->opsi }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h6 class="card-title">-- Catatan </h6>
                                                    <p class="card-text">{{ $detail->catatan }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-5">
                                <div class="class row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <p><strong>* List menu orderan</strong></p>
                                        </div>
                                    </div>
                                    @foreach ($detail->items as $item)
                                        <div class="col-md-4 col-lg-4 col-sm-6 mb-2">
                                            <div class="card h-100">
                                                <img src="{{ asset('storage/' . $item->menu->gambar) }}" height="100%"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">
                                                        <strong>{{ $item->nama_menu }}</strong>
                                                    </h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <td>Qty</td>
                                                                    <td>:</td>
                                                                    <td>{{ $item->qty }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td>:</td>
                                                                    <td>{{ $item->status }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td> {{ 'Rp.' . number_format($item->sub_total) }}</td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="col-12 btn btn-warning btn-sm proses-btn"
                                                            data-id="{{ $item->id }}"
                                                            @if ($item->status == 'siap') disabled @endif>
                                                            Selesai
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                @if ($detail->status == 'selesai')
                                    <button class="col-12 btn btn-outline-success" data-order-id="{{ $item->order_id }}"
                                        disabled>
                                       <p class="mt-3 text-center">Pesanan selesai!</p>
                                    </button>
                                @else
                                    <button id="selesaiBtn" class="col-12 btn btn-outline-success"
                                        data-order-id="{{ $item->order_id }}" disabled>
                                        <p class="mt-3 text-center">Pesanan selesai!</p>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ajjax --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkSelesai = () => {
                const allProcessed = [...document.querySelectorAll('.proses-btn')]
                    .every(btn => btn.disabled);
                document.getElementById('selesaiBtn').disabled = !allProcessed;
            };

            document.querySelectorAll('.proses-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.id;

                    fetch(`/item/proses/${itemId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                status: 'siap'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.disabled = true;
                                checkSelesai();
                            }
                        });
                });
            });

            // Handle klik tombol "Selesai"
            document.getElementById('selesaiBtn').addEventListener('click', function() {
                const orderId = this.dataset.orderId;

                fetch(`/order/selesai/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            status: 'selesai'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Order berhasil diselesaikan!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {

                                window.location.href = "/dashboardbarista";
                            });
                        }
                    });
            });

            checkSelesai();
        });
    </script>
@endsection
