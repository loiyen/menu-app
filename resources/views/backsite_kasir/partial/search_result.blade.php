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
                @if ($item->status == 'menunggu')
                    <span class="badge text-bg-primary">{{ $item->status }}</span>
                @elseif($item->status == 'diproses')
                    <span class="badge text-bg-danger">{{ $item->status }}</span>
                @elseif($item->status == 'selesai')
                    <span class="badge text-bg-success">{{ $item->status }}</span>
                @elseif($item->status == 'dibatalkan')
                    <span class="badge text-bg-dark">{{ $item->status }}</span>
                @endif
            </td>
            <td><strong>{{ $item->pembayaran?->metode ?? '-' }}</strong>
                <div class="mt-2">
                    <i>Pembayaran :</i>
                    @php
                        $pembayaranStatus = $item->pembayaran?->status;
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
                </div>

            </td>
            <td>{{ tanggal_indo($item->waktu_pesan) }}</td>
            <td>{{ format_jam($item->waktu_pesan) }}</td>
        </tr>
    @endforeach
    

@endif
