@if ($result->isEmpty())
    <tr>
        <td colspan="6" class="text-center">
            <div class="mt-5">
                <img src="{{ asset('images/notfound.png') }}" width="150" alt="not found">
                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
            </div>
        </td>
    </tr>
@else
    @foreach ($result as $item)
        <tr>
            <td>{{ $result->firstItem() + $loop->index }}</td>
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
            <td class="text-center">{{ $item->meja->nomor_meja }} <br>
                <i>{{ $item->meja->lokasi }}</i>
            </td>
            <td class="text-center">{{ tanggal_indo($item->waktu_pesan) }}</td>
            <td class="text-center">{{ format_jam($item->waktu_pesan) }}</td>
            <td>
                <a href="{{ route('detail.pemesanan', $item->id) }}" class="btn btn-sm btn-warning"> Detail</a>
            </td>
        </tr>
    @endforeach

@endif
