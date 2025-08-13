@extends('backsite_barista.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-0">
                    <h5 class="mb-0">Riwayat</h5>
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-1 mt-1">
                        <form method="GET" action="{{ route('orderbarista.index') }}" class="mb-3">
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
                                <input type="text" id="search-input" class="form-control"
                                    placeholder="Masukan kode order..." aria-label="Search..."
                                    aria-describedby="basic-addon-search31" />
                            </div>
                        </form>
                    </div>

                    <small class="text-body float-end">
                        <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal"
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
                                    <th>#</th>
                                    <th>Orderan</th>
                                    <th class="text-center">Meja</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="search-result">
                                @forelse ($order as $item)
                                    <tr>
                                        <td>{{ $order->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="mb-2">{{ $item->order_id }}</div>
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
                                        <td class="text-center">{{ $item->meja?->nomor_meja? : '.' }} <br>
                                            <i>{{ $item->meja?->lokasi? : '.' }}</i>
                                        </td>
                                        <td class="text-center">{{ tanggal_indo($item->waktu_pesan) }}</td>
                                        <td class="text-center">{{ format_jam($item->waktu_pesan) }}</td>
                                        <td>
                                            <a href="{{ route('riwayat.detail', $item->id) }}"
                                                class="btn btn-sm btn-warning"> Detail</a>
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

    {{-- filter --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Filter data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-6">
                        <div class="col mb-0">
                            <label for="emailBasic" class="form-label">Dari : </label>
                            <input type="date" id="emailBasic" class="form-control" />
                        </div>
                        <div class="col mb-0">
                            <label for="dobBasic" class="form-label">Sampai : </label>
                            <input type="date" id="dobBasic" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ajax-cari --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');
            const resultContainer = document.getElementById('search-result');

            input.addEventListener('input', function() {
                const query = input.value;

                fetch(`/orderbarista/search-live?q=${encodeURIComponent(query)}`)
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
