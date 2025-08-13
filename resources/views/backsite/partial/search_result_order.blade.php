@if ($result->isEmpty())
    <tr>
        <td colspan="7" class="text-center">
            <div class="mt-5">
                <img src="{{ asset('images/notfound.png') }}" width="150" alt="not found">
                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
            </div>
        </td>
    </tr>
@else
    <ul class="list-group">
        @foreach ($result as $item)
            <tr>
                <td><small>{{ $result->firstItem() + $loop->index }}</small></td>
                <td class="text-center"><small>{{ tanggal_indo($item->waktu_pesan) }}</small></td>
                <td class="text-center"> <small>{{ format_jam($item->
                waktu_pesan) }}</small></td>
                <td class="text-center text-moted"> <small>{{ $item->order_id }}</small></td>
                <td class="text-center"> <small><b>{{ $item->meja?->nomor_meja ?? '-' }}</b> <br>
                        <i>{{ $item->meja?->lokasi ?? '-' }}</i></small>
                </td>
                <td class="text-center"><small>
                        @if ($item->status == 'menunggu')
                            <span class="badge rounded-pill text-bg-primary">{{ $item->status }}</span>
                        @elseif($item->status == 'diproses')
                            <span class="badge rounded-pill text-bg-warning">{{ $item->status }}</span>
                        @elseif($item->status == 'selesai')
                            <span class="badge rounded-pill text-bg-success">{{ $item->status }}</span>
                        @elseif($item->status == 'dibatalkan')
                            <span class="badge rounded-pill text-bg-dark">{{ $item->status }}</span>
                        @endif
                    </small>
                </td>
                <td class="text-center">
                    <small>{{ 'Rp. ' . number_format($item->total_harga) }}</small>
                </td>

                <td class="text-center">
                    <form action="{{ route('detail.order', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm mb-2 btn-warning">
                            <i class="bx bx-info-circle"></i>
                        </button>
                    </form>
                </td>
                <td class="text-center">
                    <form action="" method="post" class="form-hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-2 btn-konfirmasi-hapus">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>

                </td>

            </tr>
        @endforeach
    </ul>
@endif
