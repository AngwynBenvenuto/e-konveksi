<?php
$type = 'project';
$id = array_get($project, 'id');
$name = array_get($project, 'name');
$url = array_get($project, 'url');
$code = array_get($project, 'code');
$price = array_get($project, 'price');
$stock = array_get($project, 'qty');
$imageUrl = '';
$images = $project->images;
foreach($images as $rows){
    $imageUrl = $rows->image_url;
}
$stockInfo = '';
if ($stock > 0) {
    $stockInfo = "".$stock.__(' Tersedia');
}
if ($stock <= 0) {
    $stockInfo = "".$stock.__(' Stok habis');
}

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
                    <a class="w-100" href="{{ url($type.'/view/'.$url) }}">
                        <img class="w-100" title="{{ $name }}" alt="{{ $name }}" 
                            src="{{ $imageUrl }}" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                        <div class="product-item-image-tag position-absolute w-100 text-right">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body product-item-info p-2 pb-1" style="margin-top:20px">
            <div class="row no-gutters align-items-center">
                <div class="product-item-name hkg-medium col text-uppercase">
                    <a class="" href="{{ url($type.'/view/'.$url) }}">
                        {{ $name }}
                    </a>
                </div>
                <div class="d-flex justify-content-start">
                    <div class="item-flag-container">
                    </div>
                </div>
                <div class="product-item-icon col-auto">
                </div>
            </div>
            <div class="product-item-price color-primary font-bold ">		
                                                              
            </div>
            <div class="product-item-vendor row no-gutters mt-2">
                <label>
                    <i class="fas fa-user"></i>
                    <?php
                        $name_display = '';
                        $ikm = $project->ikm();
                        if($ikm != null) {
                            $name_display = $ikm->first()->name_display;
                        }
                        echo $name_display;
                    ?>
                </label>
            </div>
            <div class="" style="margin-top: 19px"></div>
        </div>
    </div>
</div>