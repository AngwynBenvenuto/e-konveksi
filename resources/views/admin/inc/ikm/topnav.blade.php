<nav class="navbar navbar-static-top" role="navigation">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <a id="toggle-fullscreen" class="nav-link hide-arrow toggle-full">
                <i class="simple-icon-size-fullscreen icon-lnj navbar-icon align-middle"></i>
                <span class="d-lg-none align-middle">&nbsp;</span>
            </a>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fas fa-comment"></i>
                <span class="label label-warning">
                    <?php echo \Lintas\helpers\cchat::list($ikm_id)['found_rows'] ?>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <div class="notifbox">
                    @include('admin/inc/ikm/list-chat')
                </div>
                {{-- <div class="panel-footer text-sm text-center">
                    <a href="#">View more</a>
                </div> --}}
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="label label-primary">
                    <?php
                        $ikm_id = \Lintas\libraries\CUserLogin::get('id');
                        $penjahit_id = null;
                        echo \Lintas\helpers\cnotif::unread($ikm_id, $penjahit_id);
                    ?>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <div class="notifbox">
                    @include('admin/inc/ikm/list-notification')
                </div>
            </ul>
        </li>
        <li class="navbar-user nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="d-inline-flex flex-lg-row align-items-center align-middle">
                    <i class="far fa-user"></i>
                    <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{ $nameDisplay }}</span>
                </span>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="{{ route('admin.setting.profile') }}" >
                        <i class="fas fa-user"></i>&nbsp;{{ __('Profile') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.logout') }}" >
                        <i class="fas fa-sign-out-alt"></i>&nbsp;{{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>