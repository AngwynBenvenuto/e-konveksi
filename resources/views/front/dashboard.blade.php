@extends('front.layouts.ec')
@section('title', 'Home')
@section('content')
    <div class="home-container">
        <div>
            <div id="slideCarousel" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php
                        $i = 0;
                        $htmlIndicator = "";
                        foreach ($slides as $slide):
                            $imageUrl = Arr::get($slide, 'image_url');
                            $linkUrl = Arr::get($slide, 'url_link');
                            if (strlen($linkUrl) == 0) {
                                $linkUrl = 'javascript:;';
                            }
                            $classActive = $i == 0 ? ' active' : '';
                            $htmlIndicator .= '<li data-target="#slideCarousel" data-slide-to="' . $i . '" class="' . $classActive . '"></li>';
                    ?>
                        <div class="carousel-item <?php echo $classActive; ?>">
                            <a href="<?php echo $linkUrl; ?>" class="unstyled d-block ">
                                <img class="d-block img-responsive w-100" src="<?php echo $imageUrl; ?>" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                            </a>
                        </div>
                    <?php
                        $i++;
                        endforeach;
                    ?>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#slideCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ trans('Previous') }}</span>
                </a>
                <a class="carousel-control-next" href="#slideCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ trans('Next') }}</span>
                </a>
            </div>
        </div>

        <!-- Project -->
        <div class="container py-3">
            <div class="row">
                <div class="col-12 recent-news">
                    <div class="card vendor_card">
                        <div class="card-header">
                            <div class="card-header-title">
                                {{ __('Baru') }}
                                <span style="font-size:13px;top:5px;position:relative;">
                                    <a class="pull-right text-white" href="{{ route('project') }}">
                                        {{ __('Lihat semua »') }}
                                    </a>
                                </span>
                            </div>   
                        </div>
                        <div class="card-body">
                            @if(count($project) == 0)
                                <div class=" form-request-info text-center">		
                                    <span style="color:red;">{{ __('Tidak ditemukan') }}</span><br />
                                    {{ __('Saat ini data project belum ada.') }}
                                </div>
                            @else
                                <div class="swiper-wrapper-category">
                                    <div class="swiper-container swiper-container-auto swiper-container-category">
                                        <div class="swiper-wrapper">
                                            @foreach ($project as $row_project)
                                                <div class="swiper-slide">
                                                    {!! \Lintas\libraries\CBlocks::render('project-card', array('project' => $row_project, 'col_class' => 'unstyled')) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next swiper-button-category ">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                        <div class="swiper-button-prev swiper-button-category ">
                                            <i class="fas fa-chevron-left "></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.swiper-container.swiper-container-category').each(function () {
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
        });
    </script>
@endsection