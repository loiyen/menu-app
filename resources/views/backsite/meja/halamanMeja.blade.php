@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($errors->any())
            <div class="row">
                @foreach ($errors->all() as $error)
                    <div class="col-md-6 col-sm-6 col-lg-6 ">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="card">
            <div class="col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Meja</h5>
                    <span>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#basicModal"><i class='bx  bx-plus'></i> Tambah</button>
                        <a href="{{ route('print.all') }}" class="btn btn-danger btn-sm"><i class='bx bx-printer'></i> Print</a>
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Print</th>
                                    <th class="text-center">QR-Code</th>
                                    <th class="text-center">Nomor</th>
                                    <th class="text-center">Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($meja as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> <a href="{{ route('print.meja', $item->nomor_meja) }}"
                                                class="btn btn-warning btn-sm"><i class='bx bx-printer'></i></a>
                                        </td>
                                        <td class="text-center"> {!! QrCode::size(150)->generate(url('/pesan/meja/' . $item->nomor_meja)) !!}</td>
                                        <td class="text-center">{{ $item->nomor_meja }}</td>
                                        <td class="text-center">{{ $item->lokasi }}</td>
                                        <td>
                                            <form action="{{ route('hapus.meja', $item->id) }}" method="post"
                                                class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm mb-2 btn-konfirmasi-hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="mt-5 mb-5">
                                                <img src="{{ asset('images/notfound.png') }}" width="100"
                                                    alt="not found">
                                                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah meja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('simpan.meja') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mb-6">
                                <label for="nameBasic" class="form-label">Nomor meja</label>
                                <input type="text" name="nomor" id="nameBasic"
                                    class="form-control @error('nomor') is-invalid @enderror"
                                    placeholder="Masukan nomor..." />
                            </div>
                            <div class="col mb-6">
                                <label for="nameBasic" class="form-label">Lokasi</label>
                                <input type="text" name="lokasi" id="nameBasic"
                                    class="form-control @error('lokasi') is-invalid @enderror "
                                    placeholder="Masukan lokasi..." />
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
