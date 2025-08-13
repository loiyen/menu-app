@extends('backsite_barista.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="/riwayat" class="btn btn-sm btn-warning">Kembali</a>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="card-body mt-5">

                                                    {{-- <div
                                                        class="card card-header d-flex justify-content-between align-items-center mb-3">
                                                        <h6>Kode : <i># {{ $detail->order_id }}</i></h6>
                                                    </div> --}}
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <td><b>Kode</b></td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <b><i># {{ $detail->order_id }}</i>
                                                                        </b>
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
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td>{{ 'Rp. ' . number_format($detail->total_harga) }}
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="card-body mt-5">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <td><b>Meja</b></td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <b>{{ $detail->meja->nomor_meja }}
                                                                        </b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lokasi</td>
                                                                    <td>:</td>
                                                                    <td>{{ $detail->meja->lokasi }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td>{{ $item }} / item</td>
                                                                </tr>
                                                               
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-5">
                                        <div class="card">
                                            <div class="card-body mt-5">
                                                <div class="text-center">
                                                    @if ($detail->status == 'selesai')
                                                        <img src="{{ asset('images/done.png') }}" width="60"
                                                            alt="not found">
                                                        <p class="mt-3"><b>{{ $detail->status }}!</b></p>
                                                    @elseif($detail->status == 'menunggu')
                                                        <img src="{{ asset('images/tunggu.png') }}" width="60"
                                                            alt="not found">
                                                        <p class="mt-3"><b>{{ $detail->status }}!</b></p>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-8 mt-2 mb-5">
                                <div class="card h-100">
                                    <div class="card-body mt-5">
                                        <h6 class="card-title">Detail pesanan</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detail->items as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->nama_menu }}</td>
                                                            <td>{{'Rp.'.number_format($item->menu->harga) }}</td>
                                                            <td class="text-center">{{ $item->qty }}</td>
                                                            <td class="text-center">

                                                                @if ($item->status == 'siap')
                                                                    <span
                                                                        class="badge bg-label-success">{{ $item->status }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-label-danger">{{ $item->status }}</span>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-5">
                                <div class="card h-100">
                                    <div class="card-body mt-5">
                                        <div class="mb-3">
                                            <h6 class="card-title">-- Catatan </h6>
                                            <p class="card-text">{{ $detail->catatan }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="card-title">-- Opsi gula</h6>
                                            <p class="card-text">
                                                <span class="badge rounded-pill text-bg-primary">Medium sugar</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
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

        });
    </script>
@endsection
