<?php
use Lintas\helpers\cnotif;
use Lintas\helpers\cchat;
use Lintas\libraries\CMemberLogin;

?>
<div class="pre-header">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-5 additional-shop-info">
                <ul class="list-unstyled list-inline"></ul>
            </div>
            <div class="col-md-7 col-sm-7 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    @if(Auth::guest())
                        <li>
                            <a class="" href="{{ route('login') }}">{{ trans('Masuk') }}</a>
                        </li>
                        <li>
                            <a class="" href="{{ route('register') }}">{{ trans('Daftar') }}</a>
                            <span class="tag label label-danger img-rounded">
                                <a href="{{ route('register') }}" class="white">{{ __('Gratis!') }}</a>
                            </span>
                        </li>
                    @else
                        <div class="d-flex ">
                            <div class="nav-item dropdown align-items-center">
                                <a href="javascript:;" class="nav-link nav-chat" data-toggle="dropdown" data-target="#chatNotification" id="chatNotifications">
                                    <span class="header-chat-count bg-primary label label-primary" id="counter-chat">
                                        <?php
                                            $penjahit_id = CMemberLogin::get('id');
                                            $rows = cchat::list($penjahit_id)['found_rows'];
                                            echo $rows;
                                        ?>
                                    </span>
                                    <i class="fas fa-comment" id="chat"></i>
                                </a>
                                <div class="dropdown-menu aside-xl m0 p0 font-100p" style="min-width: 400px;" id="chatNotifications">
                                    <div class="panel panel-default mb0">
                                        <div class="page-title clearfix notificatio-plate-title-area">
                                            <span class="pull-left"><strong>Chat</strong></span>
                                        </div>
                                        <div class="dropdown-details panel bg-white m0">
                                            <div class="list-group">
                                                <?php
                                                    echo \Lintas\libraries\CBlocks::render('notification/list-chat');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nav-item dropdown align-items-center">
                                <a href="javascript:;" class="nav-link nav-notifications" data-toggle="dropdown" data-target="#menuNotification" id="menuNotifications">
                                    <span class="header-notifications-count bg-primary label label-primary" id="counter">
                                        <?php
                                            $ikm_id = null;
                                            $penjahit_id = CMemberLogin::get('id');
                                            echo cnotif::unread($ikm_id, $penjahit_id);

                                        ?>
                                    </span>
                                    <i class="fas fa-bell" id="ring"></i>
                                </a>
                                <div class="dropdown-menu aside-xl m0 p0 font-100p" style="min-width: 400px;" id="menuNotifications">
                                    <div class="panel panel-default mb0">
                                        <div class="page-title clearfix notificatio-plate-title-area">
                                            <span class="pull-left"><strong>Notifications</strong></span>
                                        </div>
                                        <div class="dropdown-details panel bg-white m0">
                                            <div class="list-group">
                                                <?php
                                                    echo \Lintas\libraries\CBlocks::render('notification/list-notification');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nav-item dropdown align-items-center">
                                <a href="#" class="nav-link dropdown-toggle no-caret" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="d-none d-md-inline"> <?php echo __('Hai'); ?>, <?php echo \Lintas\libraries\CMemberLogin::get('name_display'); ?></span>
                                    <span class="d-inline d-md-none"><i class="fas fa-user"></i></span></a>
                                <div class="dropdown-menu animate">
                                    <a class="dropdown-item" href="{{ route('user.update') }}"><i class="fas fa-user"></i> <?php echo __('Akun'); ?></a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> <?php echo __('Logout'); ?>
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>

                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="middle-header bg-top" id="middle-header">
    <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center container container-p-x bg-navbar-theme " style="box-shadow:none">
        <a href="{{ route('home') }}" class="navbar-brand brand py-0">
            <span class="brand-logo font-weight-bold ml-2">E-Konveksi</span>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse " id="layout-navbar-collapse" style="">
            <div class="navbar-nav align-items-lg-center ml-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Bantuan') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('page.about') }}">{{ __('Tentang Kami') }}</a>
                        <a class="dropdown-item" href="{{ route('page.contact') }}">{{ __('Kontak Kami') }}</a>
                    </div>
                </div>

            </div>
        </div>
    </nav>

</div>