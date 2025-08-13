@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <h5 class="mb-0">Order</h5>
                </div>

                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <div class="col-1 mt-1">
                        <form method="GET" action="{{ route('order.index') }}" class="mb-3">
                            <label for="perPage">Tampilkan: </label>
                            <select class="form-select" name="perPage" id="perPage" onchange="this.form.submit()">
                                @foreach ([5, 10, 20, 30, 50] as $jumlah)
                                    <option value="{{ $jumlah }}"
                                        {{ request('perPage') == $jumlah ? 'selected' : '' }}>
                                        {{ $jumlah }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-7 mt-4">
                        <form id="form-search">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon-search31">
                                    <i class="icon-base bx bx-search"></i>
                                </span>
                                <input type="text" id="search-input-order" class="form-control"
                                    placeholder="Masukan order id..." aria-describedby="basic-addon-search31" />
                            </div>
                        </form>

                    </div>
                    <small class="text-body float-end mt-4">
                        <a href="" class="btn btn-danger btn-sm"><i class='bx bx-printer'></i> Print</a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#basicModal">
                            <i class='bx bx-filter'></i> Filter
                        </button>
                    </small>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam</th>
                                    <th class="text-center">Order_ID</th>
                                    <th class="text-center">Meja</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Total harga</th>
                                    <th class="text-center">Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="search-result-order">
                                @forelse ($order as $item)
                                    <tr>
                                        <td>{{ $order->firstItem() + $loop->index }}</td>
                                        <td class="text-center">{{ tanggal_indo($item->waktu_pesan) }}</td>
                                        <td class="text-center">{{ format_jam($item->waktu_pesan) }}</td>
                                        <td class="text-center text-moted">{{ $item->order_id }}</td>
                                        <td class="text-center"> <small><b>{{ $item->meja?->nomor_meja ?? '-' }}</b> <br>
                                                <i>{{ $item->meja?->lokasi ?? '-' }}</i></small>
                                        </td>
                                        <td class="text-center">
                                                @if ($item->status == 'menunggu')
                                                    <span
                                                        class="badge rounded-pill text-bg-primary">{{ $item->status }}</span>
                                                @elseif($item->status == 'diproses')
                                                    <span
                                                        class="badge rounded-pill text-bg-warning">{{ $item->status }}</span>
                                                @elseif($item->status == 'selesai')
                                                    <span
                                                        class="badge rounded-pill text-bg-success">{{ $item->status }}</span>
                                                @elseif($item->status == 'dibatalkan')
                                                    <span
                                                        class="badge rounded-pill text-bg-dark">{{ $item->status }}</span>
                                                @endif
                                            
                                        </td>
                                        <td class="text-center">
                                            {{ 'Rp. ' . number_format($item->total_harga) }}
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('detail.order', $item->id) }}"
                                                class="btn btn-sm mb-2 btn-warning">
                                                <i class="bx bx-info-circle"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <form action="" method="post" class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm mb-2 btn-konfirmasi-hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="mt-5 mb-5">
                                                <img src="{{ asset('images/notfound.png') }}" width="100"
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

    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Filter data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/filterdataorder" method="GET" >
                        @csrf
                        <div class="row g-6">
                            <div class="col mb-0">
                                <label for="defaultFormControlInput" class="form-label">Dari : </label>
                                <input type="date" name="dari" class="form-control" />
                            </div>
                            <div class="col mb-0">
                                <label for="defaultFormControlInput" class="form-label">Sampai : </label>
                                <input type="date" name="sampai" class="form-control"/>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ajx-cari --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input-order');
            const resultContainer = document.getElementById('search-result-order');

            input.addEventListener('input', function() {
                const query = input.value;

                fetch(`/order/order-id/search-live?q=${encodeURIComponent(query)}`)
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
