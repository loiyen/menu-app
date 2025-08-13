@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">Riwayat transaksi</h6>
                        <span>{{ 'Rp.' . number_format($total_transaksi) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card h-100 bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title text-white">{{ 'Rp.' . number_format($total_tunai) }}</h6>
                        <span><strong>* Tunai</strong></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card h-100 bg-secondary text-white ">
                    <div class="card-body">
                        <h6 class="card-title text-white">{{ 'Rp.' . number_format($total_tf) }}</h6>
                        <span><strong>* Payment</strong></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="card-title">Riwayat</h6>

                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <form method="GET" action="{{ route('orderkasir.index') }}" class="mb-3">
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
                            <div class="col-6">
                                <form id="form-search">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31">
                                            <i class="icon-base bx bx-search"></i>
                                        </span>
                                        <input type="text" id="search-input" class="form-control"
                                            placeholder="Masukan kode order atau nama..." aria-label="Search..."
                                            aria-describedby="basic-addon-search31" />
                                    </div>
                                </form>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">Filter</button>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>order id</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Pembayaran</th>
                                        <th>Tanggal & Jam </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="search-result">
                                    @forelse ($orders as $item)
                                        <tr>
                                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                                            <td>
                                                @if ($item->pembayaran && $item->pembayaran->metode ?? '-' == 'tunai')
                                                    <form action="{{ route('bayar.kasir', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                                            Bayar
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="btn btn-outline-secondary btn-sm">
                                                        Bayar
                                                    </button>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if ($item->pembayaran && $item->pembayaran->metode ?? '-' == 'tunai')
                                                    <form action="{{ route('bayar.kasir', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                                            <p class="mt-3">Bayar</p>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="btn btn-outline-secondary btn-sm">
                                                        <p class="mt-3">Bayar</p>
                                                    </button>
                                                @endif
                                            </td> --}}
                                            <td><small><b>{{ $item->order_id }}</b></small></td>
                                            <td>{{ $item->nama }}</td>
                                            <td> <small>Status pesanan :</small> <br> <b>
                                                    @if ($item->status == 'menunggu')
                                                        <span class="badge bg-label-primary">{{ $item->status }}</span>
                                                    @elseif($item->status == 'diproses')
                                                        <span class="badge bg-label-danger">{{ $item->status }}</span>
                                                    @elseif($item->status == 'selesai')
                                                        <span class="badge bg-label-success">{{ $item->status }}</span>
                                                    @elseif($item->status == 'dibatalkan')
                                                        <span class="badge bg-label--dark">{{ $item->status }}</span>
                                                    @endif
                                                </b>

                                            </td>
                                            <td><small>Status pembayaran :</small> <br>
                                                @php
                                                    $pembayaranStatus = $item->pembayaran->status ?? '-';
                                                @endphp

                                                @if ($pembayaranStatus == 'menunggu')
                                                    <span class="badge bg-label-primary">{{ $pembayaranStatus }}</span>
                                                @elseif ($pembayaranStatus == 'lunas')
                                                    <span class="badge bg-label-success">{{ $pembayaranStatus }}</span>
                                                @elseif ($pembayaranStatus == 'gagal')
                                                    <span class="badge bg-label-danger">{{ $pembayaranStatus }}</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Belum Ada</span>
                                                @endif

                                            </td>
                                            <td><small>
                                                    {{ tanggal_indo($item->waktu_pesan) }} & <br>
                                                    {{ format_jam($item->waktu_pesan) }}</small></td>

                                            <td>
                                                <a href="{{ route('detail.kasir', $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="mt-5 mb-5">
                                                    <img src="{{ asset('images/notfound.png') }}" width="90"
                                                        alt="not found">
                                                    <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            {{ $orders->appends(['perPage' => request('perPage')])->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalCenterTitle">* Filter data</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filter.kasir') }}" method="get">
                        <div class="row g-6">
                            <div class="col mb-0">
                                <label for="emailWithTitle" class="form-label">Dari</label>
                                <input type="date" name="dari" id="emailWithTitle" class="form-control" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Sampai</label>
                                <input type="date" name="sampai" id="dobWithTitle" class="form-control" />
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

      <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');
            const resultContainer = document.getElementById('search-result');
            let abortController = null; // Untuk menghandle pembatalan fetch

            // Debounce untuk mengurangi jumlah request
            const debounce = (func, delay) => {
                let timeoutId;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(context, args), delay);
                };
            };

            const handleSearch = async function() {
                const query = input.value.trim();

                // Batalkan request sebelumnya jika masih pending
                if (abortController) {
                    abortController.abort();
                }

                if (query === '') {
                    resultContainer.innerHTML = '';
                    return;
                }

                try {
                    abortController = new AbortController();
                    const response = await fetch(
                        `/order_kasir/search?q=${encodeURIComponent(query)}`, {
                            signal: abortController.signal
                        });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const html = await response.text();
                    resultContainer.innerHTML = html;
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Error:', error);
                        // Tampilkan pesan error ke user jika diperlukan
                        resultContainer.innerHTML =
                            '<p class="error-message">Gagal memuat hasil pencarian</p>';
                    }
                } finally {
                    abortController = null;
                }
            };

            // Gunakan debounce dengan delay 300ms
            const debouncedSearch = debounce(handleSearch, 300);

            input.addEventListener('input', debouncedSearch);

            // // Handle ketika user keluar dari input
            // input.addEventListener('blur', function() {
            //     // Tambahkan delay kecil sebelum menghapus hasil
            //     setTimeout(() => {
            //         if (document.activeElement !== input) {
            //             resultContainer.innerHTML = '';
            //         }
            //     }, 200);
            // });
        });
    </script>
@endsection
