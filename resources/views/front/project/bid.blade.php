@extends('front.layouts.ec')
@section('title', 'Bid')
@section('content')
    <div class="page-white page-bid pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('project.bid', $url) !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center d-flex aligns-items-center">
                    <img class="img-responsive" src="{{ asset('public/img/bid.png') }}" style="width:350px"
                        onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                </div>
                <div class="col-md-6">
                    <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
                    <div class="box">
                        <h5>Create New Bid</h5>
                        <form method="POST" enctype="multipart/form-data">
                            @method('POST')
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">Nama Project</div>
                                    <div class="col-md-9">
                                        <div class="form-control-static">{{ $nama }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>{{ __('Budget') }}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-control-static">
                                            {{ config('cart.currency') }} {{ number_format($harga, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">Owner</div>
                                    <div class="col-md-9">
                                        <div class="form-control-static">
                                            {{ $owner_nama }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">Ukuran</div>
                                    <div class="col-md-9">
                                        <div class="form-control-static">
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
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">Deskripsi</div>
                                    <div class="col-md-9">
                                        <div class="form-control-static">
                                            {!! $deskripsi !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}"  style="position:relative">
                                <label class="form-label" for="price">Harga</label>
                                <span class="input-group-addon lnj-style-currency">{{ config('cart.currency') }}</span>
                                <input class="form-control input-harga number-format {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                    name="price" type="text" value="{{ old('price') }}" autocomplete="off"
                                    tabindex="" id="price" class="price" style="width:90%;margin-left:20px">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                                <input type="hidden" id="price_hidden" name="price_hidden" value=""/>
                                <div class="help-block-message">
                                    <i>Anda bisa menawar lebih rendah atau lebih tinggi dari budget.</i>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label class="form-label" for="message">Message</label>
                                <textarea class="form-control custom-textarea summernote {{ $errors->has('message') ? ' is-invalid' : '' }}"
                                    tabindex="" name="message" id="message" autocomplete="off">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-default bg-primary" id="buttonSubmit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#price").on('keyup', function() {
                var harga = $("#price").autoNumeric("get");
                $("#price_hidden").val(harga);
                this.value = parseInt(harga);
            });
        })
    </script>
@endsection