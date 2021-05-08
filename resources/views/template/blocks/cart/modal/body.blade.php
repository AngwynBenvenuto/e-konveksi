<?php
    use Illuminate\Support\Arr;
    use Lintas\libraries\CBlocks;
    
    if(count($detailGrouping) > 0):
        echo CBlocks::render('cart/modal/vendor', array('item' => $detailGrouping));
        // foreach ($detailGrouping as $k => $product):
        // endforeach;  
    else:
?>
    <div class="empty-cart-info p-3 m-3 text-center">
        <h5>{{ __('Cart Kosong') }}</h5>
        <h6>{{ __('Saat ini kamu tidak memiliki item.') }}</h6>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function() {
        var ajaxProcess = null;
        var href = $('.cart-continue').attr('href');

        $('.qty-touchspin').each(function () {
            var stock = $(this).attr('stock');
            $(this).TouchSpin({min: 1, max: 5});
        });
        $('.qty-touchspin-update').each(function () {
            var updateAssigned = $(this).data('update-assigned');
            if (!updateAssigned) {
                $(this).change(function () {
                    var element = $(this);
                    var product_id = $(this).attr('product-id');
                    var row_id = $(this).attr('rowId');
                    var qty = $(this).val();
                    var container_sell_price = $('.sell-price[product-id=' + product_id + ']');
                    var container_subtotal = $('.subtotal[product-id=' + product_id + ']');
                    var container_total = $('#totalharga');
                    var container_quantity = $('.qty[product-id=' + product_id + ']');
                    var btn_payment = $('.cart-continue');

                    if (ajaxProcess) {
                        ajaxProcess.abort();
                    }

                    if (qty) {
                        var url = "";
                        url = url.replace(":id", product_id);
                        ajaxProcess = $.ajax({
                            url: url,
                            method: "POST",
                            dataType: 'json',
                            data: {
                                'product_id': product_id,
                                'rowId': row_id,
                                'qty': qty,
                                '_token': "{{ csrf_token() }}"
                            },
                            beforeSend: function () {
                                btn_payment.removeAttr('href');
                                btn_payment.attr('disabled', 'disabled');
                                element.attr('disabled', 'disabled');
                            },
                            success: function (response) {
                                var error = response.errCode;
                                var msg = response.errMsg;
                                if(error == 0) {
                                    window.location.reload(true);
                                } else {
                                    $.konveksi.showModal(msg);
                                }
                            },
                            error: function (event, xhr) {
                                if (xhr.status === 0) {
                                    if (xhr.statusText === 'abort') {
                                        // Has been aborted
                                    } else {
                                        $.konveksi.showModal('error when update cart');
                                    }
                                }
                            },
                            complete: function () {
                                btn_payment.attr('href', href);
                                btn_payment.removeAttr('disabled');
                                element.removeAttr('disabled');
                                ajaxProcess = null;
                            },

                        });
                    }
                });
                $(this).data('update-assigned', 1);
            }
        });



        $('.btn-delete-cart').each(function () {
            var clickAssigned = $(this).data('click-assigned');
            if (!clickAssigned) {
                $(this).click(function (e) {
                    var project_id = $(this).attr('project-id');
                    var row_id = $(this).attr('rowId');

                    //do ajax delete
                    var request = $.ajax({
                        url: "{{ url('/cart/deleteCart') }}" + "/" + project_id,
                            method: "POST",
                            dataType: 'json',
                            data: {
                                'project_id': project_id,
                                'rowId': row_id,
                                '_token': "{{ csrf_token() }}"
                            },
                            beforeSend: function () {
                            },
                            success: function (response) {
                                var error = response.errCode;
                                var msg = response.errMsg;
                                if(error == 0) {
                                    window.location.reload(true);    
                                } else {
                                    $.konveksi.showModal(msg);
                                }
                            },
                            error: function (event, xhr) {
                                if (xhr.status === 0) {
                                    if (xhr.statusText === 'abort') {
                                        // Has been aborted
                                    } else {
                                        $.konveksi.showModal('error when delete cart');
                                    }
                                }
                            },
                            complete: function () {
                                
                            },

                    });

                    $(this).data('click-assigned', 1);
                });
            }

        });


        
    });
</script>