@extends('backsite.layout.main')

@section('container')
    <div class="content-wrapper">
        <!-- Content -->
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
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header"><a href="/menu" class="btn btn-warning btn-sm text-white">Kembali</a></h5>
                        <div class="row">
                           
                            <div class="col-md-4 col-sm-12">
                                <div class="card-body">
                                    <div class="h-100">
                                        <img class="card-img" src="{{ asset('storage/' . $menu->gambar) }}"
                                            alt="Gambar" height="200" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                       <h6 class="card-title">Form edit menu -  <b class="text-primary">{{ $menu->nama }}</b> </h6>
                                    <form action="{{ route('simpan.edit', $menu->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-5">
                                            <label for="defaultFormControlInput" class="form-label">Nama menu</label>
                                            <input type="text"
                                                name="nama"class="form-control @error('nama')is-invalid @enderror"
                                                placeholder="Masukan nama..." value="{{ $menu->nama }}" />
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <input type="hidden" name="id" class="form-control" />
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-4">
                                                <label for="defaultFormControlInput" class="form-label">Kategori</label>
                                                <select class="form-select @error('kategori')is-invalid @enderror"
                                                    name="kategori" id="kategori">
                                                    @foreach ($kategori as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $menu->kategori_id ? 'selected' : '' }}>
                                                            {{ $item->nama }}</option>
                                                    @endforeach
                                                    @error('kategori')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="defaultFormControlInput" class="form-label">Harga</label>
                                                <input type="text" name="harga"
                                                    class="form-control @error('harga')is-invalid @enderror"
                                                    placeholder="Masukan harga..." value="{{ $menu->harga }}" />
                                                @error('harga')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="defaultFormControlInput" class="form-label">Stok</label>
                                                <input type="text" name="stok"
                                                    class="form-control @error('stok')is-invalid @enderror"
                                                    placeholder="Masukan stok..." value="{{ $menu->stok }}" />
                                                @error('stok')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <label for="formFile" class="form-label">Gambar</label>
                                            <input class="form-control" name="gambar" type="file" id="formFile" />
                                            <div id="defaultFormControlHelp" class="form-text">
                                                Upload max : 5 MB ( png, jpg, jepg ).
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card">
                        <h5 class="card-header">Default</h5>
                        <div class="card-body">
                            <div>
                                <label for="defaultFormControlInput" class="form-label">Name</label>
                                <input type="text" class="form-control" id="defaultFormControlInput"
                                    placeholder="John Doe" aria-describedby="defaultFormControlHelp" />
                                <div id="defaultFormControlHelp" class="form-text">
                                    We'll never share your details with anyone else.
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endsection
