@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <h5 class="mb-0">Pembayaran</h5>
                </div>
                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <div class="mb-0">
                        <form method="GET" action="{{ route('pembayaran.index') }}" class="mb-0">
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
                    <div>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#basicModal">
                            <i class='bx bx-filter'></i> Filter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NO - ORDER</th>
                                    <th>Total</th>
                                    <th class="text-center">Metode</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_pembayaran as $item)
                                    <tr>
                                        <td>{{ $data_pembayaran->firstItem() + $loop->index }}</td>
                                        <td class="">
                                            <div class="mb-3">{{ $item->order->order_id }}</div>
                                            <small class="mt-2 mb-2">
                                                <i>Status :
                                                    @if ($item->status == 'lunas')
                                                        <span class="badge bg-label-success">{{ $item->status }}</span>
                                                    @elseif($item->status == 'menunggu')
                                                        <span class="badge bg-label-primary">{{ $item->status }}</span>
                                                    @else
                                                        <span class="badge bg-label-danger">{{ $item->status }}</span>
                                                    @endif
                                                </i>
                                            </small>

                                        </td>
                                        <td>{{ 'Rp. ' . number_format($item->jumlah_bayar) }}</td>
                                        <td class="text-center">
                                            <div>
                                                @if ($item->metode == 'tunai')
                                                    <span class="badge text-bg-primary">{{ $item->metode }}</span>
                                                @elseif($item->metode == 'transfer')
                                                    <span class="badge text-bg-info">{{ $item->metode }}</span>
                                                @endif

                                        </td>
                                        <td>
                                            {{ tanggal_indo($item->waktu_bayar) }}
                                        </td>
                                        <td>
                                            <i> {{ format_jam($item->waktu_bayar) }}</i>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('detail.pembayaran', $item->id) }}"
                                                class="btn btn-sm mb-2 btn-warning">
                                                <i class="bx bx-info-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        {{ $data_pembayaran->appends(['perPage' => request('perPage')])->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Filter pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/filterdatapembayaran" method="GET">
                        @csrf
                        <div class="row g-6">
                            <div class="col mb-0">
                                <label for="emailBasic" class="form-label">Dari</label>
                                <input type="date" name="dari" id="emailBasic" class="form-control" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">Sampai</label>
                                <input type="date" name="sampai" id="dobBasic" class="form-control" />
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
@endsection
