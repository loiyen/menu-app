@extends('backsite_kasir.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12 order-1">
                <div class="row mb-5 ">
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-warning">{{ $order_hari_ini }}</h4>
                                <p class="mb-1">Order Masuk</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title mb-3 text-success">{{ $pembayaran_tunai }}</h4>
                                <p class="mb-1">Pembayaran Tunai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 mb-6">
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
                            <div class="mb-5">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Riwayat Pesanan <br>
                                        <small style="color: rgb(124, 124, 124)">17 Agustus 2023</small>
                                    </h4>
                                    <div>
                                        <form id="form-search">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text" id="basic-addon-search31"><i
                                                        class="icon-base bx bx-search"></i></span>
                                                <input type="text" id="search-input" class="form-control"
                                                    placeholder="Masukan kode order..." />
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div id="search-result" class="row mt-5">
                                @forelse ($order as $item)
                                    <div class="col-md-4 col-lg-3 col-sm-6 mb-2">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    @if ($item->status === 'pending')
                                                        <span class="col-12 badge bg-info mb-2">Pending</span>
                                                    @elseif($item->status === 'processing')
                                                        <span class="col-12 badge bg-warning mb-2">Proccessing</span>
                                                    @elseif($item->status === 'completed')
                                                        <span class="col-12 badge bg-success mb-2">Completed</span>
                                                    @else
                                                        <span class="col-12 badge bg-danger mb-2">Canceled</span>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <small>No. {{ $order->firstItem() + $loop->index }}</small>
                                                        <h6 class="text-warning">Pesanan <br>
                                                            <small
                                                                style="color: rgb(138, 138, 138)">{{ tanggal_indo($item->waktu_pesan) }},
                                                                {{ format_jam($item->waktu_pesan) }}</small>
                                                        </h6>
                                                    </div>
                                                    <span class="mt-2">
                                                        <h4><i class="bx bx-bowl-hot" style="color: rgb(133, 133, 133)"></i>
                                                        </h4>
                                                    </span>
                                                </div>
                                                <hr>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Kode Pesanan</small>
                                                    <small style="color: black">ORD-{{ $item->order_id }}</small>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Nama</small>
                                                    <small style="color: black">{{ $item->nama }}</small>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Meja</small>
                                                    <small style="color: black">{{ $item->meja->nomor_meja }} - (
                                                        {{ $item->meja->lokasi }} )</small>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Status</small>
                                                    <small>
                                                        @if ($item->payment_status == 'paid')
                                                            <span
                                                                class="badge text-bg-info">{{ $item->payment_status }}</span>
                                                        @elseif($item->payment_status == 'unpaid')
                                                            <span
                                                                class="badge text-bg-warning">{{ $item->payment_status }}</span>
                                                        @elseif($item->payment_status == 'failed')
                                                            <span
                                                                class="badge text-bg-danger">{{ $item->payment_status }}</span>
                                                        @endif
                                                    </small>
                                                </div>
                                                <hr>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Pembayaran</small>
                                                    <small
                                                        style="color: black">{{ $item->pembayaran->metode ?? '-' }}</small>
                                                </div>
                                                <hr>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Total Pembayaran :</small>
                                                    <small
                                                        style="color: black"><b>{{ 'Rp' . number_format($item->total_harga) }}</b></small>
                                                </div>
                                                <hr>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <small>Lihat Pesanan</small>
                                                    <a href="{{ route('detail.kasir', $item->id) }}"
                                                        class="text-decoration-none">
                                                        <small><i class="bx bx-right-arrow-circle"
                                                                style="color: rgb(186, 186, 186)"></i></small></small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <div class="d-flex align-items-center justify-content-center py-10"
                                        style="background-color: rgb(230, 230, 230)">
                                        <div>
                                            <img src="{{ asset('images/notfound.png') }}" width="90" alt="not found">
                                            <h6 class="mt-2 fw-bold">Data Kosong!</h6>
                                        </div>
                                    </div>
                                @endforelse
                                <div class="card-body">
                                    {{ $order->appends(['perPage' => request('perPage')])->links() }}
                                </div>
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
