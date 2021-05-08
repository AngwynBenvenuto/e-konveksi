<?php
    $rating = round($rating, 2);
?>
@extends('front.layouts.ec')
@section('title', ucwords($name_display))
@section('content')
    <div class="page-vendor page-white pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('ikm', $vendor_id, $name_display) !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-img border p-2">
                                        <div class="img-profile-container ">
                                            <img src="{{ $image_url }}" alt="" 
                                                onerror="this.src='{{ asset('public/img/no_image.png') }}'"
                                                class="account-profile-image w-100 z-depth-1"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-control-static">
                                           {{ ucwords($name_display) }}
                                           <span style="color:#ff5722"><?php echo "(".$name.")"; ?></span>
                                        </div>
                                        <div class="form-control-static">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $alamat ?: '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row no-gutters row-bordered ui-bordered text-center mb-4" style="background:#fff;border: 1px solid rgba(24,28,33,0.06);">
                        <a href="javascript:void(0)" class="d-flex col flex-column text-dark py-3">
                            <div class="font-weight-bold">
                                <div class="product-item-rating-star">
                                    <div class="product-item-rating-star-bottom">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <?php
                                        $width = (double) $rating / 5 * 100;
                                    ?>
                                    <div class="product-item-rating-star-top" data-rating="<?php echo $rating; ?>" style="width:<?= $width ?>%;">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <?php echo "(".$rating.")"; ?>
                            </div>
                            <div class="text-muted small"><?php echo __('rating'); ?></div>
                        </a>
                    </div>

                    <div class="card" style="margin-top: 20px">
                        <div class="card-header">{{ __('Review') }}</div>
                        <div class="card-body">
                            @if(count($review) == 0)
                                <div class=" form-request-info text-center">
                                    <span style="color:red;">{{ __('Data belum ada') }}</span><br />
                                </div>
                            @else
                                @if($review!=null)
                                    <div class="list-group">
                                        @foreach ($review as $row)
                                        <?php
                                            $penjahit_name='';
                                            $penjahit=\App\Models\Penjahit::find($row->penjahit_id);
                                            if($penjahit!=null)
                                            {
                                                $penjahit_name=$penjahit->name;
                                            }
                                        ?>
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $penjahit_name }}</h5>
                                                <small>{{(string)$row->created_at}}</small>
                                            </div>
                                            <p class="mb-1">
                                                    {!! html_entity_decode($row->note, ENT_QUOTES, 'UTF-8') !!}
                                            </p>
                                        </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row no-gutters row-bordered ui-bordered text-center mb-4" style="margin-top: 30px;">
                        <a href="javascript:void(0)" class="d-flex col flex-column text-dark py-3">
                            <div class="font-weight-bold"><?php echo $project_count ?></div>
                            <div class="text-muted small"><?php echo __('Project'); ?></div>
                        </a>
                    </div>
                    <div class=" row ">			
                        <div class="col-md-12 mb-5">
                            <div class="">
                                <div class="swiper-wrapper-deal">
                                    <div class="swiper-container swiper-container-auto swiper-container-vendor" >
                                        <div class="swiper-wrapper">
                                            <?php
                                                foreach ($project as $project_item):
                                            ?>
                                                <div class="swiper-slide">
                                                    <?php
                                                        echo \Lintas\libraries\CBlocks::render('project-card', array('project' => $project_item, 'col_class' => 'unstyled'));
                                                    ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="swiper-button-next swiper-button-category ">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                        <div class="swiper-button-prev swiper-button-category ">
                                            <i class="fas fa-chevron-left "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.swiper-container.swiper-container-vendor').each(function () {
                new Swiper(this, {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'fraction',
                    },
                    navigation: {
                        nextEl: '.swiper-button-next.swiper-button-category',
                        prevEl: '.swiper-button-prev.swiper-button-category'
                    },
                    on: {
                        init: function () {
                            $(this.$el).addClass('swiper-initialized');
                        }
                    }
                });
            });
        })
    </script>
@endsection