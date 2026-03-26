  <header>
      <div class="container-fluid">
          <div class="row py-3 border-bottom">

              <div class="col-sm-6 col-lg-3 text-center text-sm-start">
                  <div class="main-logo">
                      <a href="#">
                          <img src="{{ asset('images/logo.jpg') }}" width="25%" height="20%" alt="logo"
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

          <div class="fixed-bottom bg-white border-top shadow-sm">
              <div class="container">

                  <div class="d-flex justify-content-around align-items-center py-2">

                      <!-- Riwayat -->
                      <a href="/riwayat-pesanan" class="text-decoration-none text-center text-dark">
                          <div class="d-flex flex-column align-items-center small">
                              <i class="fa fa-history mb-1"></i>
                              <span>Riwayat</span>
                          </div>
                      </a>

                      <!-- Search -->
                      <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"
                          class="text-decoration-none text-center text-dark">
                          <div class="d-flex flex-column align-items-center small">
                              <i class="fa fa-search mb-1"></i>
                              <span>Cari</span>
                          </div>
                      </a>

                      <!-- Cart (Highlight) -->
                      <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                          class="text-decoration-none text-center position-relative">

                          <div class="d-flex flex-column align-items-center small text-primary fw-semibold">
                              <i class="fa fa-shopping-cart mb-1"></i>
                              <span>Keranjang</span>
                          </div>

                          <!-- Badge -->
                          @if ($total_item > 0)
                              <span
                                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                  {{ $total_item }}
                              </span>
                          @endif

                      </a>

                  </div>

              </div>
          </div>

          <div class="col">
              <div id="hasil-makanan" class="mt-3">
              </div>
          </div>
      </div>

      </div>

  </header>
