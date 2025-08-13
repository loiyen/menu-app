@extends('backsite_barista.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-4 col-lg-12 col-md-12 order-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6><b>Orderan</b> / <i>{{ tanggal_indo($today) }}</i></h6>
                    <h6>Rp. <i></i></h6>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-warning">{{ $item_proses }}</h4>
                                <p class="mb-1">Item proses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-success">{{ $item_selesai }}</h4>
                                <p class="mb-1">Item selesai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-danger">{{ $order_batal }}</h4>
                                <p class="mb-1">Order dibatalkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar orderan</h6>
                        <div class="col-7 mt-0">
                            <form id="form-search">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31">
                                        <i class="icon-base bx bx-search"></i>
                                    </span>
                                    <input type="text" id="search-input" class="form-control"
                                        placeholder="Masukan kode order..." aria-label="Search..."
                                        aria-describedby="basic-addon-search31" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id order</th>
                                    <th>Nomor meja</th>
                                    <th class="text-center">Lokasi</th>
                                    <th>Jam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="search-result">
                                @forelse ($order as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->order_id }}</td>
                                        <td>
                                            <div class="mb-3">{{ $item->meja->nomor_meja }}
                                            </div>
                                            <div> <i>Status :
                                                    @if ($item->status == 'menunggu')
                                                        <span class="badge bg-label-primary">{{ $item->status }}</span>
                                                    @elseif($item->status == 'diproses')
                                                        <span class="badge bg-label-warning">{{ $item->status }}</span>
                                                    @elseif($item->status == 'selesai')
                                                        <span class="badge bg-label-success">{{ $item->status }}</span>
                                                    @elseif($item->status == 'dibatalkan')
                                                        <span class="badge bg-label-danger">{{ $item->status }}</span>
                                                    @endif
                                                </i>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->meja->lokasi }}</td>
                                        <td>{{ format_jam($item->waktu_pesan) }}</td>
                                        <td class="text-center">
                                            <div>
                                                <a href="{{ route('detail.pemesanan', $item->id) }}"
                                                    class="btn btn-sm btn-warning"> Detail</a>
                                                     <a href="{{ route('print.pemesanan', $item->id) }}"
                                                    class="btn btn-sm btn-danger    "> Print</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="mt-5 mb-5">
                                                <img src="{{ asset('images/notfound.png') }}" width="150"
                                                    alt="not found">
                                                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="card-body">
                            {{ $order->appends(['perPage' => request('perPage')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');
            const resultContainer = document.getElementById('search-result');

            input.addEventListener('input', function() {
                const query = input.value;

                fetch(`/order_today/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(html => {
                        resultContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
