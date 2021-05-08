<div class="card card-member-sidenav">
    <div class="card-body p-0">
        <ul class="account-nav mb-3">
            <li>
                <a href="{{ route('admin.setting.profile') }}" class="{{ set_active('admin.setting.profile') }}">
                    <i class="fas fa-user mr-2"></i><?php echo __('Profile'); ?>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaksi.ikm') }}" class="{{ set_active('admin.transaksi.ikm') }}">
                    <i class="fas fa-plane mr-2"></i><?php echo __('Transaksi'); ?>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penawaran.ikm') }}" class="{{ set_active('admin.penawaran.ikm') }}">
                    <i class="far fa-money-bill-alt mr-2"></i>{{ __('Penawaran') }}
                </a>
            </li>
        </ul>
    </div>
</div>