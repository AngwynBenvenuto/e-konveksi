<?php
    // $penjahit = Auth::check() == true ? Auth::user() : false;
    // $penjahit_id = ($penjahit != false ? $penjahit->id : '');

?>
@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="page-white page-product pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('project.view', $name, $url) !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gallery">
                        <div class="gallery-img">
                            <div class="gallery-img-wrapper">
                                <div class="square">
                                    <div class="square-content">
                                        <div class=" image-absolute-wrapper img-zoom-container">
                                            <img id="image0" src="{{ $image_url }}"
                                                class="img-fluid lnj" alt="{{ $image_name }}" data-fancy="img"
                                                onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                                            <div style="display:none">
                                                <a class="fancybox-img" data-fancybox href="{{ $image_url }}" title="size">
                                                    <img src="{{ $image_url }}" alt="{{ $image_name }}" class="img-responsive"
                                                        onerror="this.src='{{ asset('public/img/no_image.png') }}'"/>
                                                </a>
                                            </div>

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
                    <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
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
                                    <div class="col-6">
                                        <i class="fas fa-shopping-basket"></i> <span>{{ __('Ditawar') }}</span>
                                    </div>
                                    <div class="col-6">{{ $penawaranCount ?: 0 }}</div>

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
                                        {!! html_entity_decode($deskripsi, ENT_QUOTES, 'UTF-8') !!}
                                    </div>
                                    <div class="text-justify mt-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-left">
                                <div class="card vendor_card">
                                    <div class="card-header">
                                        {{ __('Pembuat Project') }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a>
                                                    <img class="media-object img-responsive img-rounded img-thumbnail"
                                                        src="{{ $owner_image }}" onerror="this.src='{{ asset('public/img/no_image.png') }}'"/>
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-control-static">
                                                    {{ ucwords($owner_user) }}
                                                    <span style="color:#ff5722">(IKM)</span>
                                                </div>
                                                <div class="form-control-static">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ $owner_alamat ?: '-' }}
                                                </div>
                                                @if(!Auth::guest())
                                                    <div class="form-control-static">
                                                        <a class="btn btn-primary btn-outline text-center " id="btnChat"
                                                            data-project_id="{{ $id }}"
                                                            data-owner_image="{{ $owner_image }}"
                                                            data-owner_username="{{ $owner_user }}"
                                                            data-owner_code="{{ $owner_code }}"
                                                            data-owner_id="{{ $owner_id }}" style="margin:5px 0">
                                                            <span>Chat</span>
                                                        </a>
                                                    </div>
                                                @endif
                                                <a href="{{ route('ikm.view', $owner_id) }}" class="font-weight-bold text-primary">Lihat selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 align-right">
                                <div class="card">
                                    <div class="card-header">
                                        {{ __('Penawaran Diterima') }}
                                    </div>
                                    <div class="card-body">
                                        @if($penawaranAccept != null)
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a><img class="media-object img-responsive img-rounded img-thumbnail"
                                                        src="{{ $penawaranAccept['penjahit_image'] }}"
                                                        onerror="this.src='{{ asset('public/img/no_image.png') }}'"/></a>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-control-static">{{ $penawaranAccept['penjahit_name'] }}</div>
                                                    <div class="form-control-static">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{ $penawaranAccept['penjahit_address'] ?: '-' }}
                                                    </div>
                                                    <div class="form-control-static">
                                                        <i class="far fa-clock"></i>
                                                        {{ $penawaranAccept['date_approve'] ?: '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if($tailor_id == $penjahit_id && $is_tailor == "1")
                                                <span>{{ __('Kamu sudah di hire oleh pemilik project '.$name.' segera lakukan penawaran')}}</span><br>
                                            @else
                                                <span>{{ __('Penawaran masih dibuka') }}</span><br>
                                            @endif
                                            <div class="btn-group flex-wrap" style="margin-top:10px">
                                                <a class="btn btn-primary text-center btn-add-cart <?php echo ($tailor_id != $penjahit_id && $is_tailor == "1" ? 'disabled' : ''); ?> "
                                                    <?php echo ($tailor_id != $penjahit_id && $is_tailor == "1" ? "disabled='disabled'" : ''); ?>
                                                    href="{{ route('project.bid', $url) }}">
                                                    <span>Tawar</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">{{ __('List') }}</div>
                                    <div class="card-body">
                                        @if(count($penawaranList) == 0)
                                            <div class=" form-request-info text-center">
                                                <span style="color:red;">{{ __('Data belum ada') }}</span><br />
                                                {{ __('Silahkan tekan tombol "Bid" atau "Nego" untuk melakukan penawaran pada '.$name) }}
                                            </div>
                                        @else
                                            <div class="row">
                                                @if($penawaranList != null)
                                                    @foreach($penawaranList as $row)
                                                        <div class="col-md-2 align-left">
                                                            <a><img class="media-object img-responsive img-rounded img-thumbnail img-sayang"
                                                                src="{{ $row['penjahit_image'] }}"
                                                                onerror="this.src='{{ asset('public/img/no_image.png') }}'"/></a>
                                                            <p class="user-bid text-center">
                                                                <a class="short-username" href="#">{{ $row['penjahit_name'] }}</a>
                                                            </p>

                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <h6 class="text-left text-large mt-5 mb-3">{{ __('Rekomendasi untuk Anda') }}</h6>
            <div class="mb-3">
                @if(count($related) == 0)
                    <div class=" form-request-info text-center">
                        <span style="color:red;">{{ trans('Rekomendasi Kosong') }}</span><br />
                        {{ trans('Maaf, saat ini rekomendasi untuk anda masih kosong.') }}
                    </div>
                @else
                    <div class="swiper-wrapper-container">
                        <div class="swiper-container swiper-container-auto swiper-container-related">
                            <div class="swiper-wrapper">
                                @foreach($related as $related_item)
                                    <div class="swiper-slide">
                                        {!! \Lintas\libraries\CBlocks::render('project-card', array('project' => $related_item, 'col_class' => 'unstyled')) !!}
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

        //
        //function chat() {
            // $(window).on('load', function() {
            //     $messages.mCustomScrollbar();
            //     setTimeout(function() {
            //         getMessage();
            //     }, 1000);
            // });
        //}
    </script>
@endsection