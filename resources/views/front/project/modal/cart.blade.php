<!-- Cart -->
<?php
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Lintas\libraries\CBlocks;

$cart = Cart::content(); 
$itemCount = Cart::content()->count();
?>
<div class="modal modal-cart fade " role="dialog" id="cartModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">{{ __('Cart') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <?php echo CBlocks::render('cart/modal/body', array('detailGrouping' => $cart)); ?>
            </div>
            <div class="modal-footer justify-content-center border-top-0">
                <div class="btn-group">
                    <?php
                        $disabledClass = $itemCount === 0 ? ' disabled' : '';
                    ?>
                    <a href="{{ url('/cart')}}" 
                        class="btn btn-primary-dark <?php echo $disabledClass; ?>" 
                        role="button"><?php echo __('VIEW CART'); ?></a>
                    <a href="javascript:;" 
                        class="btn btn-secondary toshipping <?php echo $disabledClass; ?>" 
                        role="button"><?php echo __('CHECKOUT'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-delete-cart').each(function () {
            var clickAssigned = $(this).data('click-assigned');
            if (!clickAssigned) {
                $(this).click(function (e) {
                    var product_id = $(this).attr('product-id');
                    $.konveksi.confirm('Apakah anda yakin ingin menghapus barang ini?', function (confirmed) {
                        if (confirmed) {
                            $.ajax({
                                url: "{{ url('/cart/delete') }}",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    'product_id': product_id,
                                },
                                success: function (data) {
                                    window.location.reload(true);
                                }
                            });
                        }
                    });
                    $(this).data('click-assigned', 1);
                });
            }
        });
    });
</script>
