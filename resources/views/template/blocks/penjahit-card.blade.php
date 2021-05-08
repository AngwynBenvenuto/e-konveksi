<?php

$id = array_get($penjahit, 'id');
$name = array_get($penjahit, 'name');
$name_display = array_get($penjahit, 'name_display');
$email = array_get($penjahit, 'email');
$image_url = array_get($penjahit, 'image_url');
if (!isset($after_html)) {
    $after_html = '';
}
if (!isset($col_class)) {
    $col_class = ' col-6 col-xs-6 col-lg-3 ';
}
?>
<div class="product-item col-product mb-3 page-product <?php echo $col_class ?>">
    <div class="card product-item-card ">
        <div class="square w-100 d-flex aligns-items-center justify-content-center ">
            <div class="square-content ">
                <div class="product-item-image image-absolute-wrapper ">
                    <a class="w-100" href="{{ route('admin.penjahit.view', $id) }}">
                        <img class="w-100" title="{{ $name }}" alt="{{ $name }}" 
                            src="{{ $image_url }}" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                        <div class="product-item-image-tag position-absolute w-100 text-right">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body product-item-info p-2 pb-1" style="margin-top:20px">
            <div class="row no-gutters align-items-center">
                <div class="product-item-name hkg-medium col text-uppercase">
                    <a class="" href="{{ route('admin.penjahit.view', $id) }}">
                        {{ $name }}
                    </a>
                </div>
            </div>
            <div class="" style="margin-top: 19px"></div>
        </div>
    </div>
</div>