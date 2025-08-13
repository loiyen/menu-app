@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
         @if ($errors->any())
            <div class="row">
                @foreach ($errors->all() as $error)
                    <div class="col-md-12 col-sm-12 col-lg-12 ">
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
                    <h5 class="mb-0">Kategori</h5>
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#basicModal"><i
                            class='bx  bx-plus'></i> Tambah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($kategori as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>Lorem ipsum dolor sit amet consectetur.</td>
                                        <td class="text-center">{{ $item->menu_count }}</td>
                                        <td>
                                            <form action="{{ route('hapus.kategori', $item->id) }}" method="post" class="form-hapus">
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
                                   <td colspan="4" class="text-center">
                                            <div class="mt-5">
                                                <img src="{{ asset('images/notfound.png') }}" width="100"
                                                    alt="not found">
                                                <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                            </div>
                                        </td>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('simpan.kategori') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mb-6">
                                <label for="nameBasic" class="form-label">Nama kategori</label>
                                <input type="text" name="nama" id="nameBasic" class="form-control @error ('nama')is-invalid @enderror"
                                    placeholder="Masukan nama kategori..." autofocus />
                            </div>
                        </div>
                      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
