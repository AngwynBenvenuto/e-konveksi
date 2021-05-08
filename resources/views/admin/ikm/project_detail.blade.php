<?php
    $penjahit = Auth::check() == true ? Auth::user() : false;
    $penjahit_id = ($penjahit != false ? $penjahit->id : '');

?>
@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="div_back" class="" style="text-align:left;">
                <a id="" href="{{ route('admin.dashboard') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="gallery">
                <div class="gallery-img">
                    <div class="gallery-img-wrapper">
                        <div class="square">
                            <div class="square-content">
                                <div class=" image-absolute-wrapper img-zoom-container">
                                    <img id="image0" src="{{$image_url}}"
                                        class="img-fluid lnj" alt="#" data-fancy="img"
                                        onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-thumb my-3">
                    <div class="swiper-wrapper-container">
                        <div class="swiper-container swiper-container-thumbnail swiper-container-gallery-thumb">
                            <div class="swiper-wrapper">
                                @php $ii = 0; @endphp
                                @if($images != null)
                                    @foreach($images as $thumb)
                                        <div class="swiper-slide">
                                            <div class="square">
                                                <div class="square-content">
                                                    <div class="gallery-thumb-img image-absolute-wrapper<?php echo $ii == 0 ? ' active' : ''; ?>">
                                                        <img src="<?php echo array_get($thumb, 'image_url'); ?>"
                                                            class="gallery-thumb-img-det"
                                                            onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @php $ii++; @endphp
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h4 class="text-left product-name">{{ __(ucwords($name)) }}</h4>
                    </div>
                    <div class="product-share-container no-wrap ml-auto ">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Panduan
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($size_guide_anak != null)
                                        <a class="dropdown-item lnj" data-fancy="size_anak">Ukuran Anak</a>
                                    @endif
                                    @if($size_guide_dewasa != null)
                                        <a class="dropdown-item lnj" data-fancy="size_dewasa">Ukuran Dewasa</a>
                                    @endif
                                    @if($video != null)
                                        <a class="dropdown-item lnj" data-fancy="video">SOP</a>
                                    @endif
                                </div>
                            </div>
                            <div style="display:none">
                                <a class="fancybox-size_anak" data-fancybox href="{{ $size_guide_anak }}" title="size">
                                    <img src="{{ $size_guide_anak }}" alt="{{ $name }}" class="img-responsive" />
                                </a>
                                <a class="fancybox-size_dewasa" data-fancybox href="{{ $size_guide_dewasa }}" title="size">
                                    <img src="{{ $size_guide_dewasa }}" alt="{{ $name }}" class="img-responsive" />
                                </a>
                                <a class="fancybox-video" data-fancybox href="{{ $video }}" title="youtube">SOP</a>
                            </div>
                    </div>
                </div>
                <div class="product-sku font-weight-bold mb-2">{{ $kode }}</div>
                <div class="row product-info-container my-2">
                    <div class="col-md-4">
                        <div class="row row-info">
                            <div class="col-6">
                                <i class="fas fa-eye"></i> <span>{{ __('Dilihat') }}</span>
                            </div>
                            <div class="col-6">{{ $views ?: 0 }}</div>


                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row row-info">
                            <div class="col-6">
                                <i class="fas fa-clock"></i> <span>{{ __('Deadline') }}</span>
                            </div>
                            <div class="col-6">{{ $tanggal_mulai }}</div>
                            {{-- <div class="col-6">
                                <i class="fas fa-book-open"></i> <span>{{ __('Durasi Pengerjaan') }}</span>
                            </div>
                            <div class="col-6">{{ $waktu }}</div> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row row-info">
                            <div class="col-6">
                                <i class="fas fa-expand-arrows-alt"></i> <span>{{ __('Ukuran') }}</span>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    @if(!empty($ukuran))
                                        @foreach($ukuran as $ukuran_val)
                                            <div class="col-md-3">
                                                {{ array_get($ukuran_val, 'ukuran_nama') }}
                                                <div>{{ array_get($ukuran_val, 'qty') }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-3">-</div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="card col-12 ">
                        <div class="card-body">
                            <div class="text-justify">
                                {!! html_entity_decode($spesifikasi, ENT_QUOTES, 'UTF-8') !!}
                            </div>
                            <div class="text-justify mt-3">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.gallery-thumb-img').click(function (evt) {
                var image_src = $(this).find('img').attr('src');
                $('.gallery-img-wrapper img').attr('src', image_src);
                $('.gallery-thumb-img').removeClass('thumb-active');
                $(this).addClass('thumb-active');
                $('#myresult').attr('src', image_src);
            });

            $('.swiper-container.swiper-container-related').each(function () {
                new Swiper(this, {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'fraction',
                    },
                    navigation: {
                        nextEl: '.swiper-button-next.swiper-button-related',
                        prevEl: '.swiper-button-prev.swiper-button-related'
                    },
                    on: {
                        init: function () {
                            $(this.$el).addClass('swiper-initialized');
                        }
                    }
                });
            });

            $('.swiper-container.swiper-container-gallery-thumb').each(function () {
                new Swiper(this, {
                    slidesPerView: 'auto',
                    spaceBetween: 5,
                    pagination: {
                        el: '.swiper-pagination',
                        type: 'fraction',
                    },
                    navigation: {
                        nextEl: '.swiper-button-next.swiper-button-gallery-thumb',
                        prevEl: '.swiper-button-prev.swiper-button-gallery-thumb'
                    },
                    on: {
                        init: function () {
                            $(this.$el).addClass('swiper-initialized');
                        }
                    }
                });
            });

            $(".lnj").click(function() {
                var types = $(this).data('fancy');
                $(".fancybox-"+types).fancybox({
                    image: {
                        preload: true,
                    }
                }).trigger('click');
            })
        });

    </script>
@endsection