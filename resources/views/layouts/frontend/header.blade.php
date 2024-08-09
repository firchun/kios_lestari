  <!-- Header Section Begin -->
  <header class="header-section">
      <div class="header-top">
          <div class="container">
              <div class="ht-left">
                  <div class="mail-service">
                      <i class=" fa fa-map"></i>
                      {{ $setting->alamat }}
                  </div>
                  <div class="phone-service">
                      <i class=" fa fa-phone"></i>
                      {{ $setting->no_hp }}
                  </div>
              </div>
              <div class="ht-right">
                  @guest
                      <a href="{{ route('login') }}" class="login-panel"> <i class="fa fa-user"></i>Login</a>
                  @else
                      @if (Auth::user()->role != 'User')
                          <a href="{{ route('home') }}" class="login-panel"><i class="fa fa-home"></i>Dashboard</a>
                      @else
                          <a href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"
                              class="login-panel text-danger"><i class="fa fa-power-off"></i>Logout</a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      @endif
                  @endguest

                  <div class="top-social">
                      <a href="#"><i class="ti-facebook"></i></a>
                      <a href="#"><i class="ti-twitter-alt"></i></a>
                      <a href="#"><i class="ti-linkedin"></i></a>
                      <a href="#"><i class="ti-pinterest"></i></a>
                  </div>
              </div>
          </div>
      </div>
      <div class="container">
          <div class="inner-header">
              <div class="row align-items-center">
                  <div class="col-lg-2 col-md-7 text-center">
                      <div class="logo mb-3">
                          <a href="{{ url('/') }}">
                              <img src="{{ asset('img/logo.png') }}" alt="" style="height: 100px; width:auto;">
                          </a>
                      </div>
                  </div>
                  <div class="col-lg-7 col-md-12 d-none d-sm-inline-block">
                      <h1 class="text-center font-weight-bold">{{ env('APP_NAME') }}</h1>
                  </div>
                  <div class="col-lg-3 text-right col-md-3">
                      {{-- <ul class="nav-right">
                          <li class="heart-icon">
                              <a href="#">
                                  <i class="icon_heart_alt"></i>
                                  <span>1</span>
                      </a>
                      </li>
                      <li class="cart-icon">
                          <a href="#">
                              <i class="fa fa-xl fa-user"></i>
                              <span>3</span>
                          </a>
                      </li>

                      </ul> --}}
                  </div>
              </div>
          </div>
      </div>
      <div class="nav-item">
          <div class="container">

              <nav class="nav-menu mobile-menu">
                  <ul>
                      <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                      <li class="{{ request()->is('semua-produk') ? 'active' : '' }}"><a
                              href="{{ url('/semua-produk') }}">Semua Produk</a></li>
                      <li class="{{ request()->is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}">About</a>
                      </li>
                      @if (Auth::check())
                          @if (Auth::user()->role == 'User')
                              <li class="{{ request()->is('keranjang') ? 'active' : '' }}"><a
                                      href="{{ url('/keranjang') }}">Keranjang
                                      <span
                                          class="badge badge-danger">{{ App\Models\Keranjang::getCountKeranjang(Auth::id()) }}</span>
                                  </a>
                              </li>
                              <li class="{{ request()->is('pesanan') ? 'active' : '' }}"><a
                                      href="{{ url('/pesanan') }}">Pemesanan

                                      <span
                                          class="badge badge-danger">{{ App\Models\Pesanan::getCountPesanan(Auth::id()) }}</span>
                                  </a>
                              </li>
                              <li class="{{ request()->is('my-akun') ? 'active' : '' }}"><a
                                      href="{{ url('/my-akun') }}">Akun Saya</a>
                              </li>
                          @endif
                      @endif
                  </ul>
              </nav>
              <div id="mobile-menu-wrap"></div>
          </div>
      </div>
  </header>
  <!-- Header End -->
