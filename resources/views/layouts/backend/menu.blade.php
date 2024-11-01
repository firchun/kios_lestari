<div class="right-sidebar">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16 text-blue">
            Pengaturan letak
            {{-- <span class="btn-block font-weight-400 font-12">User Interface Settings</span> --}}
        </h3>
        <div class="close-sidebar" data-toggle="right-sidebar-close">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>
    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
            <div class="sidebar-radio-group pb-10 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-1" checked="" />
                    <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-2" />
                    <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-3" />
                    <label class="custom-control-label" for="sidebaricon-3"><i
                            class="fa fa-angle-double-right"></i></label>
                </div>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
            <div class="sidebar-radio-group pb-30 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-1" checked="" />
                    <label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-2" />
                    <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                            aria-hidden="true"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-3" />
                    <label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-4" checked="" />
                    <label class="custom-control-label" for="sidebariconlist-4"><i
                            class="icon-copy dw dw-next-2"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-5" />
                    <label class="custom-control-label" for="sidebariconlist-5"><i
                            class="dw dw-fast-forward-1"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-6" />
                    <label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                </div>
            </div>

            <div class="reset-options pt-30 text-center">
                <button class="btn btn-danger" id="reset-settings">
                    Reset Settings
                </button>
            </div>
        </div>
    </div>
</div>
<div class="left-side-bar">
    <div class="brand-logo text-center">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img') }}/logo.png" alt="" class="dark-logo"
                style="height: 100%; width:auto;" />
            <img src="{{ asset('img') }}/logo.png" alt="" class="light-logo"
                style="height: 100%; width:auto;" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('home') }}"
                        class="dropdown-toggle no-arrow {{ request()->is('home') ? 'active' : '' }}">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'Admin')
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-folder"></span><span class="mtext">Master Data</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('produk') }}"
                                    class="{{ request()->is('produk') ? 'active' : '' }}">Produk</a></li>
                            <li><a href="{{ route('area') }}" class="{{ request()->is('area') ? 'active' : '' }}">Area
                                    pengantaran </a>
                            </li>
                            <li><a href="{{ route('bank') }}" class="{{ request()->is('bank') ? 'active' : '' }}">
                                    Rekening Bank </a>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-folder"></span><span class="mtext">Transaksi</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('pemesanan') }}"
                                    class="{{ request()->is('pemesanan') ? 'active' : '' }}">Pemesanan</a>
                            </li>
                            <li><a href="{{ route('pembayaran') }}"
                                    class="{{ request()->is('pembayaran') ? 'active' : '' }}">Pembayaran</a>
                            </li>
                            <li><a href="{{ route('return') }}"
                                    class="{{ request()->is('return') ? 'active' : '' }}">Return Barang</a>
                            </li>
                            <li><a href="{{ route('pengantaran') }}"
                                    class="{{ request()->is('pengantaran') ? 'active' : '' }}"> Status Pengantaran</a>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-people"></span><span class="mtext">Pengguna</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('users') }}"
                                    class="{{ request()->is('users') ? 'active' : '' }}">Pengguna</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('point') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('point') ? 'active' : '' }}">
                            <span class="micon bi bi-star"></span><span class="mtext">Point Pelanggan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/chat-admin') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('chat-admin*') ? 'active' : '' }}">
                            <span class="micon bi bi-telephone"></span><span class="mtext">Chat Pelanggan</span>
                        </a>

                    </li>
                    <li>
                        <a href="{{ url('/stok') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('stok*') ? 'active' : '' }}">
                            <span class="micon bi bi-folder"></span><span class="mtext">Riwayat Stok</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/setting') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('setting*') ? 'active' : '' }}">
                            <span class="micon bi bi-gear"></span><span class="mtext">Pengaturan</span>
                        </a>
                    </li>
                @endif
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-folder"></span><span class="mtext">Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('laporan.penjualan') }}"
                                class="{{ request()->is('laporan/penjualan') ? 'active' : '' }}">Penjualan</a>
                        </li>
                        <li><a href="{{ route('laporan.keuangan') }}"
                                class="{{ request()->is('laporan/keuangan') ? 'active' : '' }}">keuangan</a>
                        </li>
                        <li><a href="{{ route('laporan.pengantaran') }}"
                                class="{{ request()->is('laporan/pengantaran') ? 'active' : '' }}">Pengantaran</a>
                        </li>
                        <li><a href="{{ route('laporan.suplai') }}"
                                class="{{ request()->is('laporan/suplai') ? 'active' : '' }}"> Suplai Stok</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="{{ url('/profile') }}"
                        class="dropdown-toggle no-arrow {{ request()->is('profile*') ? 'active' : '' }}">
                        <span class="micon bi bi-person-circle"></span><span class="mtext">Update Akun</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
