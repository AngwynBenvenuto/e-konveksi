@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-6 text-center d-flex aligns-items-center">
             <img class="img-responsive" src="{{ asset('public/img/kerjasama.jpg') }}" style="width:250px">
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">{{ __('Form Kerjasama') }}</div>
                <div class="card-body">
                    <form class="form_kerjasama" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group ">
                            <label id="" class="form-label control-label">Nama Perusahaan</label>
                            <input type="text" class="form-control"
                                id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}"/>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">No ID Perusahaan</label>
                            <input type="text" class="form-control"
                                id="nomor_perusahaan" name="nomor_perusahaan" value="{{ old('nomor_perusahaan') }}"/>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Penjahit</label>
                            <div class="form-control-static">
                                <div class="text-justify">
                                   {{ $penjahit }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Spesifikasi Produk</label>
                            <div class="form-control-static">
                                <div class="row">
                                    <div class="col text-left">
                                        <img id="image0" src="{{ $image }}"
                                            class="img-responsive" style="width:130px"
                                            onerror="this.src='{{ asset('public/img/no_image.png') }}'" style="width:150px;"/>
                                    </div>
                                    <div class="col text-left">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Detail</legend>
                                            <?php
                                                echo "<b>Nama Project: </b>".$project_nama."<br>";
                                                echo "<b>Kode: </b>".$code."<br>";
                                            ?>
                                        </fieldset>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Bahan</label>
                            <div class="form-control-static">
                                <div class="text-justify">
                                    {!! html_entity_decode($bahan, ENT_QUOTES, 'UTF-8') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Ukuran + Jumlah Order</label>
                            <div class="form-control-static">
                                <div class="row col-md-6">
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
                        <div class="form-group">
                            <label id="" class="form-label control-label">Jangka Waktu</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control only-number" style=""
                                        id="jangka_waktu" name="jangka_waktu" value="{{ old('jangka_waktu') }}"/>
                                </div>
                                <div class="col-8" style="padding:0">
                                    <span style="position:relative;top:5px">Bulan</span>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="submit" href="javascript:;"
                            class="btn btn-primary lnj-color btnSubmit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="div_back" class="mb-3" style="text-align:left;margin-top:10px">
                <a id="" href="{{ route('admin.checkout.address') }}" class="btn btn-primary btn-block btn-checkout mb-2">
                    Lanjut ke Halaman Checkout
                </a>
            </div>
        </div>
    </div>
@endsection