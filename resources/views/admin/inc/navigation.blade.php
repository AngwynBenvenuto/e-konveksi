<nav id="layout-sidenav" class="layout-lintas bg-sidenav-theme navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <div class="brand">
            <span class="brand-logo">
                <img src="{{ asset('public/img/logo.png') }}">
            </span>
            <a href="{{ route('admin.dashboard') }}" class="brand-name sidenav-text font-weight-normal ml-2">E-KONVEKSI</a>
        </div>
        <div class="logo-element">EK</div>
        <div class="sidenav-divider mt-0"></div>
        <ul class="nav metismenu menu-lintas" id="side-menu">
            <li class="{{ set_active('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="{{ set_active(['admin.master.project',
                                      'admin.master.bank',
                                      'admin.master.barang',
                                      'admin.master.kota',
                                      'admin.master.provinsi',
                                      'admin.master.jasa',
                                      'admin.master.ikm' ]) }}">
                <a href="#">
                    <i class="far fa-folder-open"></i>
                    <span class="nav-label">Master</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ set_active('admin.master.project') }}">
                        <a href="{{ route('admin.master.project') }}">Project</a>
                    </li>
                    <li class="{{ set_active('admin.master.ikm') }}">
                        <a href="{{ route('admin.master.ikm') }}">Ikm</a>
                    </li>
                    <li class="{{ set_active('admin.master.bank') }}">
                        <a href="{{ route('admin.master.bank') }}">Bank</a>
                    </li>
                    <li class="{{ set_active('admin.master.barang') }}">
                        <a href="{{ route('admin.master.barang') }}">Barang</a>
                    </li>
                    <li class="{{ set_active('admin.master.provinsi') }}">
                        <a href="{{ route('admin.master.provinsi') }}">Provinsi</a>
                    </li>
                    <li class="{{ set_active('admin.master.kota') }}">
                        <a href="{{ route('admin.master.kota') }}">Kota</a>
                    </li>
                    <li class="{{ set_active('admin.master.jasa') }}">
                        <a href="{{ route('admin.master.jasa') }}">Jasa Pengiriman</a>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active(['admin.cms.page.about',
                                        'admin.cms.page.contact',
                                        'admin.cms.page.privacy',
                                        'admin.cms.page.terms',
                                        'admin.cms.home.slide'
                                    ]) }}">
                <a href="#">
                    <i class="fas fa-sitemap"></i>
                    <span class="nav-label">CMS</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ set_active(['admin.cms.page.about',
                                                'admin.cms.page.contact',
                                                'admin.cms.page.privacy',
                                                'admin.cms.page.terms']) }}">
                        <a href="#" id="damian">{{ __('CMS Halaman')}} <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li class="{{ set_active(['admin.cms.page.about']) }}">
                                <a href="{{ route('admin.cms.page.about') }}">About Us</a>
                            </li>
                            <li class="{{ set_active(['admin.cms.page.contact']) }}">
                                <a href="{{ route('admin.cms.page.contact') }}">Contact Us</a>
                            </li>
                            <li class="{{ set_active(['admin.cms.page.privacy']) }}">
                                <a href="{{ route('admin.cms.page.privacy') }}">Privacy Policy</a>
                            </li>
                            <li class="{{ set_active(['admin.cms.page.terms']) }}">
                                <a href="{{ route('admin.cms.page.terms') }}">Terms &amp; Condition</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ set_active(['admin.cms.home.slide']) }}">
                        <a href="#" id="damian">{{ __('CMS Home')}} <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li class="{{ set_active(['admin.cms.home.slide']) }}">
                                <a href="{{ route('admin.cms.home.slide') }}">CMS Slide Show</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active(['admin.transaction.list',
                                    'admin.transaction.offer',
                                ]) }}">
                <a href="#">
                    <i class="fas fa-sitemap"></i>
                    <span class="nav-label">Transaksi</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ set_active(['admin.transaction.list']) }}">
                        <a href="{{ route('admin.transaction.list') }}">List</a>
                    </li>
                    <li class="{{ set_active(['admin.transaction.offer']) }}">
                        <a href="{{ route('admin.transaction.offer') }}">Penawaran</a>
                    </li>

                </ul>
            </li>
            <li class="{{ set_active(['admin.setting.user',
                                    'admin.setting.role',
                                    'admin.setting.system']) }}">
                <a href="#">
                    <i class="fas fa-user-cog"></i>
                    <span class="nav-label">Pengaturan</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ set_active(['admin.setting.user',
                                            'admin.setting.role']) }}">
                        <a href="#" id="damian">{{ __('Akses')}} <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li class="{{ set_active(['admin.setting.user']) }}">
                                <a href="{{ route('admin.setting.user') }}">User</a>
                            </li>
                            {{-- <li class="{{ set_active(['admin.setting.role']) }}">
                                <a href="{{ route('admin.setting.role') }}">Role</a>
                            </li> --}}

                        </ul>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</nav>
