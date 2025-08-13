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
                <td>{{ $loop->iteration }}</td>
                <td><img src="{{ asset('storage/' . $item->gambar) }}" alt="gambar" width="75"></td>
                <td>
                    <div>
                        <b>{{ $item->nama }}</b>
                    </div>
                    <div class="mt-5">
                        <small> <i> Update : {{ tanggal_indo($item->updated_at) }} </i> </small>
                    </div>
                </td>
                <td>{{ optional($item->kategori)->nama ?? '-' }}</td>
                <td>{{ 'Rp.' . number_format($item->harga) }}</td>
                <td>{{ $item->stok }}</td>

                <td>
                    <div class="d-flex gap-3 mt-4">
                        <form action="{{ route('edit.menu', $item->id) }}" method="post" class="form-hapus">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm mb-2 btn-warning" data-bs-toggle="modal"
                                data-id="{{ $item->id }}" data-bs-target="#basicModaledit">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                        </form>

                        <form action="{{ route('hapus.menu', $item->id) }}" method="post" class="form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-2 btn-konfirmasi-hapus">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>

            </tr>
        @endforeach
    </ul>
@endif
