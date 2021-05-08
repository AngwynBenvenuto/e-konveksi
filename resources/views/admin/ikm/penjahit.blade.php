<?php
    //$rating = Arr::get($data, 'rating', 3);
    $rating = round($rating, 2);
?>
@extends('admin.layouts.ec')
@section('title', ucwords($name_display))
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
                                    {{ ucwords($name) }}
                                    <span style="color:#ff5722"><?php echo "(Penjahit)"; ?></span>
                                </div>
                                <div class="form-control-static">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $alamat ?: '-' }}
                                </div>
                                <div class="btn-group flex-wrap" style="margin-top:10px">
                                    <a class="btn btn-primary text-center"
                                        href="{{ route('admin.hire', $vendor_id) }}">
                                        <span>Panggil Saya</span>
                                    </a>
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
            <div class="card">
                <div class="card-header">{{ __('Bid') }}</div>
                <div class="card-body">
                    @if(count($penawaranList) == 0)
                        <div class=" form-request-info text-center">
                            <span style="color:red;">{{ __('Data belum ada') }}</span><br />
                        </div>
                    @else
                        <div class="row">
                            @if($penawaranList != null)
                                @foreach($penawaranList as $row)
                                    <div class="col-md-2 align-left">
                                        <p class="user-bid text-center">
                                            <a class="short-username">{{ $row['name'] }}</a><br>
                                            <a class="short-price" href="#">{{ config('cart.currency')." ".\Lintas\helpers\utils::formatCurrency($row['price']) }}</a>
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
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
                                    $ikm_name = '';
                                    $ikm=\App\Models\Ikm::find($row->ikm_id);
                                    if($ikm!=null)
                                    {
                                        $ikm_name=$ikm->name;
                                    }
                                ?>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $ikm_name }}</h5>
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
@endsection