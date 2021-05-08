<?php
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Gloudemans\Shoppingcart\Facades\Cart;

$productId = utils::getObject($item, 'id');
$rowId = utils::getObject($item, 'rowId');
$productName = utils::getObject($item, 'name');
$productStock = utils::getObject($item, 'stock');
$productQty = utils::getObject($item, 'qty');
$productSellPrice = utils::getObject($item, 'price');
$productImage = "";
$subTotal = $productQty * $productSellPrice;
?>
<div class="cart-list-item row no-gutters mb-1">
    <div class="col-4 pr-2">
        <div class="square">
            <div class="square-content">
                <div class="product-item-image image-absolute-wrapper ">
                    <img class="" src="<?php echo $productImage ?>" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                </div>
            </div>
        </div>
    </div>
    <div class="cart-list-item-right col-8 p-2">
        <div class="cart-list-item-name mb-1 row">
            <div class="col">
                {{ $productName }}

            </div>
            <div class="col-auto">
                <a href="javascript:;" id="deleteItem" product-id="<?php echo $productId ?>"
                        rowId="<?php echo $rowId ?>" 
                        class=" cart-list-item-delete btn-delete-cart">
                    <i class="fa fa-trash text-danger"></i>
                </a>
            </div>
        </div>
        <?php

        ?>
        <div class="row no-gutters align-items-center mb-1">
            <div class="col-auto mr-2">
                <span class="cart-list-item-new-price font-weight-bold">
                    <?php echo config('cart.currency') ?> 
                    <span class="sell-price" product-id="<?php echo $productId ?>">
                        <?php echo number_format($productSellPrice, 2) ?>
                    </span>
                </span>
            </div>
            <div class="col-auto">

            </div>
            <div class="cart-list-item-price col text-right hkg-bold">
                <?php echo config('cart.currency') ?> 
                <span class="subtotal" product-id="<?php echo $productId ?>">
                    <?php echo $subTotal; ?>
                </span>
            </div>
        </div>
        <div class="row no-gutters align-items-center justify-content-end">
            <div class="col-auto">
                <input type="text" product-id="{{ $productId }}" 
                    stock="{{ $productStock }}" 
                    rowId="{{ $rowId }}" 
                    sell_price_promo="{{ $productSellPrice }}" 
                    value="{{ $productQty }}" 
                    class="cart-list-item-qty qty-touchspin qty-touchspin-update py-0 m-0 text-center border " >
            </div>
        </div>
    </div>    
</div>