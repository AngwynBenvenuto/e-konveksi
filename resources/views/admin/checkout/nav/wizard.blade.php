<div id="card-apps-navigation" class="card nav-wizard">
    <div class="form-wizard">
        <ul class="nav nav-lnj nav-pills nav-justified steps">
            <li class="{{ set_active('admin.checkout.address') }}">
                <a class="step col-step text-center p-3" id="address" href="{{ route('admin.checkout.address') }}">
                    <span class="number">1</span>
                    <span class="desc">Input Data</span>
                </a>
            </li>
            <li class="{{ set_active('admin.checkout.shipping') }}">
                <a class="step col-step text-center p-3" id="shipping" href="{{ route('admin.checkout.shipping') }}">
                    <span class="number">2</span>
                    <span class="desc">Metode Pembayaran</span>
                </a>
            </li>
            <li class="{{ set_active('admin.checkout.payment') }}">
                <a class="step col-step text-center p-3" id="payment" href="{{ route('admin.checkout.payment') }}">
                    <span class="number">3</span>
                    <span class="desc">Konfirmasi Pembayaran</span>
                </a>
            </li>
        </ul>
    </div>
</div>