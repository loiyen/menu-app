@extends('backsite.layout.main')

@section('container')
    

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <div>
                <h4 class="mb-1">Detail Order</h4>
                <small class="text-muted">Ringkasan transaksi dan pembayaran customer</small>
            </div>

            <div class="d-flex gap-2">
                <a href="/order" class="btn btn-outline-secondary btn-sm">
                    ← Kembali
                </a>

                <a href="{{ route('cetak.nota', $order->id) }}" class="btn text-white btn-primary btn-sm">
                    Print
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <h5 class="mb-1">Order #{{ $order->id }}</h5>
                        <div class="text-muted">
                            {{ tanggal_indo($order->waktu_pesan) }} • {{ format_jam($order->waktu_pesan) }}
                        </div>
                    </div>

                    <div class="text-end">
                        @if ($order->status == 'menunggu')
                            <span class="badge bg-primary rounded-pill px-3 py-2">Menunggu</span>
                        @elseif($order->status == 'diproses')
                            <span class="badge bg-warning rounded-pill px-3 py-2">Diproses</span>
                        @elseif($order->status == 'selesai')
                            <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                        @elseif($order->status == 'dibatalkan')
                            <span class="badge bg-dark rounded-pill px-3 py-2">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <small class="text-muted d-block mb-1">Customer</small>
                            <h6 class="mb-1">{{ $order->nama }}</h6>
                            <div class="text-muted small">{{ $order->phone ?? '-' }}</div>
                            <div class="text-muted small">{{ $order->email ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <small class="text-muted d-block mb-1">Meja</small>
                            <h6 class="mb-1">Meja {{ $order->meja->nomor_meja ?? '-' }}</h6>
                            <div class="text-muted small">{{ $order->meja->lokasi ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <small class="text-muted d-block mb-1">Total Pembayaran</small>
                            <h5 class="mb-1 text-primary">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </h5>
                            <div class="text-muted small">
                                Status: {{ $order->payment_status ?? '-' }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Item Order</h6>
                        <span class="badge bg-primary rounded-pill">{{ $total_item }} Item</span>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Menu</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $item->menu->nama ?? ($item->nama_menu ?? 'Menu tidak ditemukan') }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-label-primary">{{ $item->qty }}</span>
                                            </td>
                                            <td class="text-end">
                                                Rp {{ number_format($item->sub_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Pembayaran</h6>

                        @if ($pembayaran->transaction_status == 'PENDING')
                            <span class="badge bg-warning rounded-pill">PENDING</span>
                        @elseif($pembayaran->transaction_status == 'PAID')
                            <span class="badge bg-success rounded-pill">PAID</span>
                        @else
                            <span class="badge bg-danger rounded-pill">{{ $pembayaran->transaction_status }}</span>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Metode</small>
                            <div class="fw-semibold text-uppercase">{{ $pembayaran->payment_type ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Total Dibayar</small>
                            <div class="fw-bold fs-5 text-primary">
                                Rp {{ number_format($pembayaran->gross_amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Waktu Transaksi</small>
                            <div>
                                @if ($pembayaran->transaction_time)
                                    {{ tanggal_indo($pembayaran->transaction_time) }}
                                    {{ format_jam($pembayaran->transaction_time) }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('detail.pembayaran', $pembayaran->id) }}"
                            class="btn btn-outline-primary btn-sm w-100 no-print">
                            Lihat Detail Pembayaran
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0">Ringkasan Pembelian</h6>
            </div>

            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-lg-5">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Customer</span>
                            <strong>{{ $order->nama }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_harga - 4000, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>PPN</span>
                            <span>Rp {{ number_format(4000, 0, ',', '.') }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Total Bayar</h6>
                            <h5 class="mb-0 text-primary">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if ($order->catatan)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Catatan Customer</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->catatan }}</p>
                </div>
            </div>
        @endif

    </div>
@endsection
