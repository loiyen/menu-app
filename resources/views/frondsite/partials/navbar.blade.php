  <header>
      <div class="container-fluid">
          <div class="row py-3 border-bottom">

              <div class="col-sm-6 col-lg-3 text-center text-sm-start">
                  <div class="main-logo">
                      <a href="#">
                          <img src="{{ asset('images/logo2.png') }}" width="25%" height="20%" alt="logo"
                              class="img-fluid">
                      </a>
                  </div>
              </div>

              <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
                  <div class="search-bar row bg-light p-2 my-2 rounded-4">

                      <div class="col-11 col-md-11 mt-4 mb-3">

                          <input id="search-makanan" class="form-control rounded-start rounded-2 bg-light"
                              type="text" placeholder="Masukan nama menu..." aria-label="Masukan nama menu..?">

                      </div>
                      <div class="col-1 mt-4 mb-3">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                              <path fill="currentColor"
                                  d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                          </svg>
                      </div>

                  </div>
              </div>

              <div
                  class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">

                  <div class="support-box text-end d-none d-xl-block">
                      <span class="fs-6 text-muted">Customer Servis ?</span>
                      <h6 class="mb-0">+62-82250-590837</h6>
                  </div>

                  <div class="cart text-end d-none d-lg-block dropdown">
                      <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                          data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                          <span class="fs-6 text-muted dropdown-toggle">Keranjang</span>
                          <span class="cart-total fs-6 fw-bold">
                              @if ($total_harga == null)
                              @else
                                  {{ 'Rp.' . number_format($total_harga) }}
                              @endif
                          </span>
                      </button>
                  </div>
              </div>

          </div>
          <div class="col-12 mt-3">
              <h5 class="text-center">MEJA <b class="text-primary">
                      @if (session()->has('nomor_meja'))
                          <div class="alert alert-info">
                              Anda memesan dari <strong> Meja {{ session('nomor_meja') }}</strong>
                          </div>
                      @endif
                  </b>
                  @if ($keranjang == null)
                  @else
                  @endif
              </h5>
              <div class="container-fluid">
                  <ul class="row justify-content-center g-3 list-unstyled p-0 m-0">
                      <!-- Item Desktop -->
                      <li class="col-12 col-lg-none col-lg-auto text-center d-lg-none">
                          <a href="{{ route('login') }}"
                              class="d-flex align-items-center justify-content-center p-3 rounded text-decoration-none bg-primary text-dark">
                              <i class="fa-regular fa-file-lines fa-lg me-2"></i>
                              <span>
                                  <h6 class="mt-2">Riwayat</h6>
                              </span>
                          </a>
                      </li>

                      <!-- Item Mobile - Keranjang -->
                      <li class="col-md-6 col-lg-6 col-sm-6 col-lg-none text-center d-lg-none ">
                        
                              <a href="#"
                                  class="d-flex align-items-center justify-content-center p-3 rounded text-decoration-none bg-light text-dark"
                                  data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                                  <i class="fa-solid fa-cart-shopping fa-lg me-2"></i>
                                  <span>
                                      <h6 class="mt-2">Keranjang 
                                        <span class="badge bg-primary">
                                            {{ $total_item }}
                                        </span></h6>
                                  </span>
                              </a>
                    
                      </li>

                      <!-- Item Mobile - Pencarian -->
                      <li class="col-md-6 col-lg-6 col-sm-6 col-lg-none text-center d-lg-none ">
                          <a href="#"
                              class="d-flex align-items-center justify-content-center p-3 rounded text-decoration-none bg-light text-dark"
                              data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch">
                              <i class="fa-solid fa-magnifying-glass fa-lg me-2"></i>

                              <span>
                                  <h6 class="mt-2">Pencarian</h6>
                              </span>
                          </a>
                      </li>
                  </ul>
              </div>
          </div>

          <div class="col">
              <div id="hasil-makanan" class="mt-3">

              </div>
          </div>
      </div>

      </div>
      <div class="container-fluid">
          <div class="row py-3">

              {{-- buttonnnn --}}
              <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
                  <nav class="main-menu d-flex navbar navbar-expand-lg">

                      {{-- <button class="navbar-toggler " type="button" data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                          <span class="navbar-toggler-icon"></span>
                      </button>

                      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                          aria-labelledby="offcanvasNavbarLabel">

                          <div class="offcanvas-header justify-content-center">
                              <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                  aria-label="Close"></button>

                          </div>
                          <div class="offcanvas-header justify-content-center">
                              <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                                  <span><b>Kategori</b></span>
                                  <hr class="mb-4">
                                  @foreach ($kategori as $item)
                                      <li class="nav-item active">
                                          <a href="#women" class="nav-link">- {{ $item->nama }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          </div>
                      </div> --}}
              </div>

          </div>

      </div>
  </header>
