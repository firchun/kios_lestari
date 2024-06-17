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
                          <a href="{{ route('home') }}" class="login-panel"><i class="fa fa-user"></i>Dashboard</a>
                      @else
                          <a href="#" class="login-panel"><i class="fa fa-user"></i>Akun</a>
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
                      <div class="logo">
                          <a href="{{ url('/') }}">
                              <img src="{{ asset('img/logo.png') }}" alt="" style="height: 100px; width:auto;">
                          </a>
                      </div>
                  </div>
                  <div class="col-lg-7 col-md-12 d-none d-sm-inline-block">
                      <h1 class="text-center">{{ env('APP_NAME') }}</h1>
                  </div>
                  <div class="col-lg-3 text-right col-md-3">
                      <ul class="nav-right">
                          <li class="heart-icon">
                              <a href="#">
                                  <i class="icon_heart_alt"></i>
                                  <span>1</span>
                              </a>
                          </li>
                          <li class="cart-icon">
                              <a href="#">
                                  <i class="icon_bag_alt"></i>
                                  <span>3</span>
                              </a>
                              <div class="cart-hover">
                                  <div class="select-items">
                                      <table>
                                          <tbody>
                                              <tr>
                                                  <td class="si-pic"><img
                                                          src="{{ asset('frontend_theme') }}/img/select-product-1.jpg"
                                                          alt=""></td>
                                                  <td class="si-text">
                                                      <div class="product-selected">
                                                          <p>$60.00 x 1</p>
                                                          <h6>Kabino Bedside Table</h6>
                                                      </div>
                                                  </td>
                                                  <td class="si-close">
                                                      <i class="ti-close"></i>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="si-pic"><img
                                                          src="{{ asset('frontend_theme') }}/img/select-product-2.jpg"
                                                          alt=""></td>
                                                  <td class="si-text">
                                                      <div class="product-selected">
                                                          <p>$60.00 x 1</p>
                                                          <h6>Kabino Bedside Table</h6>
                                                      </div>
                                                  </td>
                                                  <td class="si-close">
                                                      <i class="ti-close"></i>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                                  <div class="select-total">
                                      <span>total:</span>
                                      <h5>$120.00</h5>
                                  </div>
                                  <div class="select-button">
                                      <a href="#" class="primary-btn view-card">VIEW CARD</a>
                                      <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                  </div>
                              </div>
                          </li>

                      </ul>
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
                  </ul>
              </nav>
              <div id="mobile-menu-wrap"></div>
          </div>
      </div>
  </header>
  <!-- Header End -->
