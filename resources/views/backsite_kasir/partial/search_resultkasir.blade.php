@if ($result->isEmpty())
    <tr>
        <td colspan="9" class="text-center">
            <div class="mt-5 mb-5">
                <img src="{{ asset('images/notfound.png') }}" width="90" alt="not found">
                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
            </div>
        </td>
    </tr>
@else
    @foreach ($result as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
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
                <a href="{{ route('detail.kasir', $item->id) }}" class="btn btn-warning btn-sm">
                    <i class="bx bx-info-circle"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endif
