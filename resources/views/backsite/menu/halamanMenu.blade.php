@extends('backsite.layout.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($errors->any())
            <div class="row">
                @foreach ($errors->all() as $error)
                    <div class="col-md-4 col-sm-4 col-lg-4 ">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Menu</h5>
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="col-1 mt-1">
                    <form method="GET" action="{{ route('menu.index') }}" class="mb-3">
                        <label for="perPage">Tampilkan: </label>
                        <select class="form-select" name="perPage" id="perPage" onchange="this.form.submit()">
                            @foreach ([5, 10, 20, 30, 50] as $jumlah)
                                <option value="{{ $jumlah }}" {{ request('perPage') == $jumlah ? 'selected' : '' }}>
                                    {{ $jumlah }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                </div>

                <div class="col-7 mt-4">
                    <form id="form-search">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31">
                                <i class="icon-base bx bx-search"></i>
                            </span>
                            <input type="text" id="search-input" class="form-control" placeholder="Masukan kunci..."
                                aria-label="Search..." aria-describedby="basic-addon-search31" />
                        </div>
                    </form>
                </div>

                <small class="text-body float-end">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#basicModal">
                        <i class='bx  bx-plus'></i> Tambah
                    </button>
                    <a href="" class="btn btn-danger btn-sm"><i class='bx bx-printer'></i> Print</a>
                </small>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="search-result">
                        <!-- Tempat hasil pencarian -->
                        @forelse ($menu as $item)
                            <tr>
                                <td>{{ $menu->firstItem() + $loop->index }}</td>
                                <td><img src="{{ asset('storage/' . $item->gambar) }}" alt="gambar" width="75" height="60"></td>
                                <td>
                                    <div>
                                        <b>{{ $item->nama }}</b>
                                    </div>
                                    <div class="mt-5">
                                        <small> <i> Update : {{ tanggal_indo($item->updated_at) }} </i> </small>
                                    </div>
                                </td>
                                <td>{{ $item->Kategori->nama }}</td>
                                <td>{{ 'Rp.' . number_format($item->harga) }}</td>
                                <td>{{ $item->stok }}</td>

                                <td>
                                    <div class="d-flex gap-3 mt-4">
                                        <form action="{{ route('edit.menu', $item->id) }}" method="post"
                                            class="form-hapus">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm mb-2 btn-warning"
                                                data-bs-toggle="modal" data-id="{{ $item->id }}"
                                                data-bs-target="#basicModaledit">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('hapus.menu', $item->id) }}" method="post"
                                            class="form-hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-2 btn-konfirmasi-hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="mt-5 mb-5">
                                        <img src="{{ asset('images/notfound.png') }}" width="150" alt="not found">
                                        <h6 class="text-muted mt-3"><b>Tidak ditemukan!</b></h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="card-body">
                    {{ $menu->appends(['perPage' => request('perPage')])->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>


    {{-- tambah menu --}}
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('simpan.menu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-mb-6 mb-4">
                                <label for="nameBasic" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nameBasic"
                                    class="form-control @error('nama')is-invalid @enderror" placeholder="Masukan nama..."
                                    value="{{ old('nama') }}" />
                            </div>
                        </div>
                        <div class="row g-6 mb-5">
                            <div class="col mb-0">
                                <label for="exampleFormControlSelect1" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori')is-invalid @enderror" name="kategori"
                                    id="exampleFormControlSelect1" aria-label="Default select example">
                                    <option selected disabled value>Pilih kategori --</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">Harga</label>
                                <input type="text" name="harga" id="dobBasic"
                                    class="form-control @error('harga')is-invalid @enderror"
                                    placeholder="Masukan harga..." value="{{ old('harga') }}" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobBasic" class="form-label">Stok</label>
                                <input type="text" name="stok" id="dobBasic"
                                    class="form-control @error('stok')is-invalid @enderror" placeholder="Masukan stok..."
                                    value="{{ old('stok') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-6">
                                <label for="formFile" class="form-label">Gambar</label>
                                <input class="form-control @error('gambar')is-invalid @enderror" name="gambar"
                                    type="file" id="formFile" />
                                <div id="defaultFormControlHelp" class="form-text">
                                    Upload max : 5 MB ( png, jpg, jepg ).
                                </div>
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

    {{-- ajx-cari --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');
            const resultContainer = document.getElementById('search-result');

            input.addEventListener('input', function() {
                const query = input.value;

                fetch(`/menu3/search-live?q=${encodeURIComponent(query)}`)
                    .then(response => response.text())
                    .then(html => {
                        resultContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

@endsection
