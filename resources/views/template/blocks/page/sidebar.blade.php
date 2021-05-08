<div class="card mb-3">
    <div class="card-header">	
        <?php echo __('Bantuan'); ?>
    </div>
    <div class="card-body p-0">	
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center {{ set_active('page.about') }}">
                <a class="" href="{{ route('page.about') }}">{{ __('Tentang Kami')}}</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center {{ set_active('page.contact') }}">
                <a class="" href="{{ route('page.contact') }}">{{ __('Kontak Kami')}}</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center {{ set_active('page.terms') }}">
                <a class="" href="{{ route('page.terms') }}">{{ __('Syarat dan Ketentuan')}}</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center {{ set_active('page.privacy') }}">
                <a class="" href="{{ route('page.privacy') }}">{{ __('Kebijakan Privasi')}}</a>
            </li>

        </ul>
    </div>
</div>