@extends('frondsite.layout.main')

@section('container')
    @include('frondsite.partials.navbar')

    <div class="col-md-12">
        <div class="bootstrap-tabs product-tabs">
            <div class="tabs-header d-flex justify-content-between  my-0 mb-5 mt-0">
                <a href="/" class="btn btn-primary"><i class="fa fa-arrow-left mt-0"></i></a>
                <h6 class="mt-2">Riwayat</h6>
                <h6></h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the
                                    card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('frondsite.partials.footer')
@endsection
