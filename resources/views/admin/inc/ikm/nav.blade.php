<div class="middle-header bg-top" id="middle-header">
    <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-navbar-theme " style="box-shadow:none">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand brand py-0">
            <span class="brand-logos font-weight-bold ml-2">E-Konveksi</span>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse " id="layout-navbar-collapse" style="">
            <div class="navbar-nav align-items-lg-center navbar-dropdown-right ml-auto">
                <div class="nav-item dropdown dropdown-pull-right ">
                   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">            
                        {{ __('Bantuan') }}
                    </a>
                    <div class="dropdown-menu pull-right " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">{{ __('Panduan') }}</a>
                    </div>
                </div>
                
            </div>
        </div>
    </nav>
</div>