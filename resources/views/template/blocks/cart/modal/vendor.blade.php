<?php
use Lintas\libraries\CBlocks;
use Gloudemans\Shoppingcart\Facades\Cart;

$product = array_get($item, 'product');
$vendorDisplay = "";
$vendorName = "";
$vendorLogo = "";
$cityName = "";
?>
<div class="card">
    <div class="card-header">
        <div class="cart-address row no-guttersmb-3">
            <div class="cart-address-icon col-auto p-2">
                <div class="image-profile-thumbnail-container">
                    <div class="square">
                        <div class="square-content">
                            <div class="vendor-profile-image image-profile-thumbnail image-absolute-wrapper">
                                <img class="img-responsive " src="<?php echo $vendorLogo; ?>" onerror="this.src='{{ asset('public/img/no_image.png') }}"/>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="cart-address-info col p-2">
                <?php echo $vendorName; ?><br>
                <i class="fas fa-map-marker-alt"></i> <?php echo $cityName; ?>
            </div>


        </div>
    </div>

    <div class="card-body">
        <div class="cart-list mb-3">
            @foreach ($product as $key => $products)
                {{ CBlocks::render('cart/modal/product/card', array('item' => $products)) }}
            @endforeach
            
        </div>
    </div>
</div>