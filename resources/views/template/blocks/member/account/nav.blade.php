<div class="card card-member-sidenav">
    <div class="card-body p-0">
        <ul class="account-nav mb-3">
            <li>
                <a href="{{ route('user.update') }}" class="{{ set_active(['user', 'user.update']) }}">
                    <i class="fas fa-user mr-2"></i><?php echo __('Profile'); ?>
                </a>
            </li>
            <li>
                <a href="{{ route('user.change_password') }}" class="{{ set_active('user.change_password') }}">
                    <i class="fas fa-lock mr-2"></i><?php echo __('Ubah Password'); ?>
                </a>
            </li>
            <li>
                <a href="{{ route('transaction.list') }}" class="{{ set_active('transaction.list') }}">
                    <i class="fas fa-plane mr-2"></i><?php echo __('Transaksi Saya'); ?>
                </a>
            </li>
            <li>
                <a href="{{ route('transaction.offer') }}" class="{{ set_active('transaction.offer') }}">
                    <i class="far fa-money-bill-alt mr-2"></i>{{ __('Penawaran Saya') }}
                </a>
            </li>
        </ul>
    </div>
</div>