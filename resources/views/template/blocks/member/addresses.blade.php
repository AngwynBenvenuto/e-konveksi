<div class="container-address mb-3">	
    <div class=" member-addresses-title mb-2">
        <div class="row">
            <div class="col-12">				
                <div class="member-addresses-title-text font-weight-bold">
                    <?php echo __('Address'); ?>
                </div>
            </div>				
        </div>
    </div>			
    <div class=" member-addresses d-flex flex-column no-gutters row-bordered ui-bordered mb-4">	
        <?php
            foreach ($billingAddress as $addressIndex => $bAddress):
                $sAddress = array_get($shippingAddress, $addressIndex);
                $classMainAddress = '';
                $isMainAddress = array_get($bAddress, 'is_main_address');
                if ($isMainAddress) {
                    $classMainAddress = ' main-member-address';
                }
        ?>
            <div class="member-address p-2  <?php echo $classMainAddress; ?>">	
                <div class=" row ">	
                    <div class=" col-md-8">	
                        <div class=" member-address-title font-weight-bold">
                            <?php echo __('Shipping Address'); ?>
                        </div>
                        <div class=" member-address-desc">	
                            <?php echo array_get($sAddress, 'name'); ?><br />
                            <?php echo array_get($sAddress, 'address'); ?><br />
                            <?php echo array_get($sAddress, 'province_name'); ?> - <?php echo array_get($sAddress, 'city_name'); ?> - <?php echo array_get($sAddress, 'district_name'); ?>
                        </div>
                        <div class=" member-address-title font-weight-bold">
                            <?php echo __('Billing Address'); ?>
                        </div>
                        <div class=" member-address-desc">	
                            <?php echo array_get($bAddress, 'name'); ?><br />
                            <?php echo array_get($bAddress, 'address'); ?><br />
                            <?php echo array_get($bAddress, 'province_name'); ?> - <?php echo array_get($bAddress, 'city_name'); ?> - <?php echo array_get($bAddress, 'district_name'); ?>
                        </div>
                    </div>				
                    <div class=" col-md-4 ">
                        <div class="clearfix">
                            <div class=" member-address-action pull-right">
                                <a href="{{ route('user.address.edit', [array_get($bAddress, 'penjahit_address_id'), array_get($sAddress, 'penjahit_address_id')]) }}" class="text-info"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('user.address.delete', [array_get($bAddress, 'penjahit_address_id'), array_get($sAddress, 'penjahit_address_id')]) }}" class="text-danger btn-confirm"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        <?php if (!$isMainAddress): ?>
                            <div class="">		
                                <a href="{{ route('user.address.setmain', [array_get($bAddress, 'penjahit_address_id'), array_get($sAddress, 'penjahit_address_id')]) }}" class="pull-right link-member-address-default" >
                                    <?php echo __('Jadikan Alamat Utama'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>