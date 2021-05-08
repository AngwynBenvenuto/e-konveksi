<nav class="navbar navbar-static-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
            <i class="fa fa-bars"></i> 
        </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <a id="toggle-fullscreen" class="nav-link hide-arrow toggle-full">
                <i class="simple-icon-size-fullscreen icon-lnj navbar-icon align-middle"></i>
                <span class="d-lg-none align-middle">&nbsp;</span>
            </a>
        </li>
        <li class="navbar-user nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="d-inline-flex flex-lg-row align-items-center align-middle">
                    <i class="far fa-user"></i>
                    <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{ ucwords($nameDisplay) }}</span>
                </span>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="{{ route('admin.setting.change_password') }}">
                        <i class="fas fa-key"></i>&nbsp;{{ __('Change Password') }}
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