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
                <td>{{ $result->firstItem() + $loop->index }}</td>
                <td class="">
                    <div class="mb-2">Kode Pemesanan : <br> <small
                            style="color: black">{{ $item->nomor_pesanan ?? '0' }}
                        </small>
                    </div>


                    <div>Tanggal & waktu : <br> <small style="color: black">
                            {{ tanggal_indo($item->waktu_pesan) }}, {{ format_jam($item->waktu_pesan) }}
                        </small>
                    </div>
                </td>
                <td>
                    {{ $item->nama }} <br> <small>{{ $item->email }}</small>
                </td>

                <td class="text-center">
                    @if ($item->payment_status == 'PAID')
                        <span class="badge rounded-pill text-bg-success"><i class="bx bx-check-circle"></i> Paid</span>
                    @else
                        <span class="badge rounded-pill text-bg-danger"><i class="bx bx-x-circle"></i> Expired</span>
                    @endif

                </td>
                <td class="text-center">
                    {{ 'Rp. ' . number_format($item->total_harga) }}
                </td>

                <td class="text-center">
                    <a href="{{ route('detail.order', $item->id) }}" class="btn mb-2 btn-warning">
                        <i class="bx bx-info-circle"></i>
                    </a>
                </td>
                <td class="text-center">
                    <form action="" method="post" class="form-hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-2 btn-konfirmasi-hapus">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>

                </td>

            </tr>
        @endforeach
    </ul>
@endif
