<div id="card-apps-navigation" class="card nav-wizard">
    <div class="form-wizard">
        <ul class="nav nav-pills nav-justified steps">
            <li class="{{ set_active('checkout.address') }}">
                <a class="step col-step text-center p-3" id="address" href="{{ route('checkout.address') }}">
                    <span class="number">1</span>
                    <span class="desc">Input Data</span>
                </a>
            </li>
            <li class="{{ set_active('checkout.shipping') }}">
                <a class="step col-step text-center p-3" id="shipping" href="{{ route('checkout.shipping') }}">
                    <span class="number">2</span>
                    <span class="desc">Pembayaran</span>
                </a>
            </li>
            <li class="{{ set_active('checkout.payment') }}">
                <a class="step col-step text-center p-3" id="payment" href="{{ route('checkout.payment') }}">
                    <span class="number">3</span>
                    <span class="desc">Konfirmasi</span>
                </a>
            </li>
        </ul>
    </div>
</div>