@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-4 col-lg-12 col-md-12 order-1">
                <div class="row mb-5 ">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-warning">{{ $order_hari_ini }}</h4>
                                <p class="mb-1">Order Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-success">{{ $pembayaran_tunai }}</h4>
                                <p class="mb-1">Pembayaran Tunai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-warning">{{ $pembayaran_transfer }}</h4>
                                <p class="mb-1">Pembayaran Transfer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 ">
                    {{-- list-sebelumnya --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                                <div class="col-6">
                                    <h6>Cari data pemesanan : </h6>
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
                                <h6></h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <div></div>
                                <div>
                                    <p> Jumlah : {{ $total_perhari }} | Total pendapatan :
                                        {{ 'Rp.' . number_format($total_pendapatanbyhari) }} | T.Tunai :
                                        {{ 'Rp.' . number_format($total_pembayaranTunai) }} | T.Transfer :
                                        {{ 'Rp.' . number_format($total_pembayaranTf) }} </p>
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
                                            <th>Tanggal</th>
                                            <th>Jam</th>

                                        </tr>
                                    </thead>
                                    <tbody id="search-result">
                                        @forelse ($order as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->pembayaran && $item->pembayaran->metode == 'tunai')
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
                                                </td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>
                                                    @if ($item->status == 'pending')
                                                        <span class="badge text-bg-primary">{{ $item->status }}</span>
                                                    @elseif($item->status == 'processing')
                                                        <span class="badge text-bg-danger">{{ $item->status }}</span>
                                                    @elseif($item->status == 'completed')
                                                        <span class="badge text-bg-success">{{ $item->status }}</span>
                                                    @elseif($item->status == 'cancelled')
                                                        <span class="badge text-bg-dark">{{ $item->status }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <strong>{{ $item->pembayaran->metode ?? '-' }}</strong>
                                                    <div class="mt-2">
                                                        <i>Status Pembayaran:</i>
                                                        @if ($item->pembayaran)
                                                            @switch($item->pembayaran->status)
                                                                @case('menunggu')
                                                                    <span class="badge bg-label-primary">Menunggu</span>
                                                                @break

                                                                @case('lunas')
                                                                    <span class="badge bg-label-success">Lunas</span>
                                                                @break

                                                                @case('gagal')
                                                                    <span class="badge bg-label-danger">Gagal</span>
                                                                @break

                                                                @default
                                                                    <span class="badge bg-label-secondary">Belum Ada</span>
                                                            @endswitch
                                                        @else
                                                            <span class="badge bg-label-secondary">Belum Dibayar</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ tanggal_indo($item->waktu_pesan) }}</td>
                                                <td>{{ format_jam($item->waktu_pesan) }}</td>
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
                                    {{ $order->appends(['perPage' => request('perPage')])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ajax --}}
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
                            `/order_today_kasir/search?q=${encodeURIComponent(query)}`, {
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
