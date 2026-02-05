@if ($result->isEmpty())
    <div class="d-flex align-items-center justify-content-center py-10" style="background-color: rgb(230, 230, 230)">
        <div>
            <img src="{{ asset('images/notfound.png') }}" width="90" alt="not found">
            <h6 class="mt-2 fw-bold">Data Kosong!</h6>
        </div>

    </div>
@else
    @foreach ($result as $item)
        <div id="search-result" class="col mb-2">
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
                            <small>No. {{ $loop->iteration }}</small>
                            <h6 class="text-warning">Pesanan <br>
                                <small style="color: rgb(138, 138, 138)">{{ tanggal_indo($item->waktu_pesan) }},
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
                                <span class="badge text-bg-info">{{ $item->payment_status }}</span>
                            @elseif($item->payment_status == 'unpaid')
                                <span class="badge text-bg-warning">{{ $item->payment_status }}</span>
                            @elseif($item->payment_status == 'failed')
                                <span class="badge text-bg-danger">{{ $item->payment_status }}</span>
                            @endif
                        </small>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <small>Pembayaran</small>
                        <small style="color: black">{{ $item->pembayaran->metode ?? '-' }}</small>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <small>Total Pembayaran :</small>
                        <small style="color: black"><b>{{ 'Rp' . number_format($item->total_harga) }}</b></small>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <small>Lihat Pesanan</small>
                        <a href="{{ route('detail.kasir', $item->id) }}" class="text-decoration-none">
                            <small><i class="bx bx-right-arrow-circle"
                                    style="color: rgb(186, 186, 186)"></i></small></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endif
