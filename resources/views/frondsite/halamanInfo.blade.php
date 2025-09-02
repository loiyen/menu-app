@extends('frondsite.layout.main')

@section('container')
    {{-- @include('frondsite.partials.navbar') --}}

    <div class="row">
        <div class="col-md-12 ">
            <div class="bootstrap-tabs product-tabs mb-4 mt-4">
                <div class="tabs-header d-flex justify-content-between my-1">
                    <a href="/"><i class="fa fa-arrow-left mt-0"></i></a>
                    <h5 class="mt-2">Info Oprasional Kafe</h5>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-12 m-2 product-item h-100">
                    <div class="card-body">
                        <h6><span><i class="fa fa-calendar"></i></span> Senin - Jumat</h6>
                        <p>Jam Oprasional kafe : </p>
                        <div>
                            <ul>
                                <li>13.00 - 17.00 </li>
                                <li>17.00 - 17.30 ( Istirahat )</li>
                                <li>17.30 - 22.00 </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 m-2 product-item h-100">
                    <div class="card-body">
                        <h6><span><i class="fa fa-calendar"></i></span> Sabtu - Minggu</h6>
                        <p>Jam Oprasional kafe : </p>
                        <div>
                            <ul>
                                <li>13.00 - 17.00 </li>
                                <li>17.00 - 17.30 ( Istirahat )</li>
                                <li>17.30 - 22.00 </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- @include('frondsite.partials.footer') --}}
@endsection
