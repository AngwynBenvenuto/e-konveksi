<?php
    use Lintas\libraries\CUserLogin;
    $ikm_id = CUserLogin::get('id');
?>
@extends('admin.layouts.ec')
@section('title', 'Dashboard')
@section('content')
    @if($ikm_id != null)
        <div class="row">
            <div class="col-lg-12">
                <div id="div_back" class="" style="float:right;text-align:right;">
                    <a id="" href="{{ route('admin.master.project.create') }}" class="btn  btn-primary mb-2">
                        Buat Project
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-header-title">
                            {{ __('Penjahit Tersedia') }}
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($penjahit) == 0)
                            <div class=" form-request-info text-center">
                                <span style="color:red;">{{ __('Tidak ditemukan') }}</span><br />
                                {{ __('Saat ini data penjahit belum ada.') }}
                            </div>
                        @else
                        <div class="swiper-wrapper-category">
                                <div class="swiper-container swiper-container-auto swiper-container-category">
                                    <div class="swiper-wrapper">
                                        @foreach ($penjahit as $row_penjahit)
                                            <div class="swiper-slide">
                                                {!! \Lintas\libraries\CBlocks::render('penjahit-card', array('penjahit' => $row_penjahit, 'col_class' => 'unstyled')) !!}
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

                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-header-title">
                            {{ __('Project yang sudah dibuat') }}
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($project) == 0)
                            <div class=" form-request-info text-center">
                                <span style="color:red;">{{ __('Tidak ditemukan') }}</span><br />
                                {{ __('Saat ini data project belum ada.') }}
                            </div>
                        @else
                        <div class="swiper-wrapper-project">
                                <div class="swiper-container swiper-container-auto swiper-container-project">
                                    <div class="swiper-wrapper">
                                        @foreach ($project as $row_project)
                                            <div class="swiper-slide">
                                                {!! \Lintas\libraries\CBlocks::render('project-card-ikm', array('project' => $row_project, 'col_class' => 'unstyled')) !!}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next swiper-button-project ">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                    <div class="swiper-button-prev swiper-button-project ">
                                        <i class="fas fa-chevron-left "></i>
                                    </div>
                                </div>
                            </div>
                        @endif
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


                $('.swiper-container.swiper-container-project').each(function () {
                    new Swiper(this, {
                        slidesPerView: 'auto',
                        spaceBetween: 20,
                        pagination: {
                            el: '.swiper-pagination',
                            type: 'fraction',
                        },
                        navigation: {
                            nextEl: '.swiper-button-next.swiper-button-project',
                            prevEl: '.swiper-button-prev.swiper-button-project'
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
    @else
        <div class="row left">
            <div class="form-group ibox m-l-n" style="margin-left:20px">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="input-group input-daterange" id="periode">
                            <input type="text" id="start_date" class="form-control border" autocomplete="off">
                            <span class="input-group-addon">to</span>
                            <input type="text" id="end_date" class="form-control border" autocomplete="off">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <button type="button" href="javascript:;" class="btn btn-primary lnj-color btn-show" style="padding:5px 12px;margin-left:5px">
                                <i class="icon icon- fas fa-check  fas fa-check"></i> Tampilkan
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-small mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fas fa-user display-4 text-success "></div>
                                    <div class="ml-3">
                                        <div class="text-muted small">IKM</div>
                                        <div class="text-large countTotalUser"></div>
                                    </div>
                                    <a href="{{ route('admin.master.ikm') }}" class="btn btn-primary ml-auto">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-small mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fas fa-user display-4 text-success "></div>
                                    <div class="ml-3">
                                        <div class="text-muted small">Penawaran</div>
                                        <div class="text-large countTotalPenawaran"></div>
                                    </div>
                                    <a href="{{ route('admin.transaction.offer') }}" class="btn btn-primary ml-auto">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-small mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="fas fa-user display-4 text-success "></div>
                                    <div class="ml-3">
                                        <div class="text-muted small">Transaksi</div>
                                        <div class="text-large countTotalTransaksi"></div>
                                    </div>
                                    <a href="{{ route('admin.transaction.list') }}" class="btn btn-primary ml-auto">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-small mb-3">

                        </div>
                    </div>
                </div>


            </div>
        </div>
        <script>
            $(document).ready(function() {
                //daterange
                $('#start_date').datepicker('setDate', 'new Date()').on('changeDate', function(selected){
                    var minDate = new Date(selected.date.valueOf());
                    $('#end_date').datepicker('setStartDate', minDate);
                    $('#end_date').datepicker('update', minDate);
                });
                $(function(selected){
                    var minDate = $('#start_date').val();
                    $('#end_date').datepicker('setStartDate', minDate);
                });
                $('#end_date').datepicker('setDate', 'new Date()').on('changeDate', function(selected){
                });

                getAllData();
            });

            function getAllData() {
                $.ajax({
                    url: "{{ url('/admin/list') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        // start_date: $("#start_date").val(),
                        // end_date: $("#end_date").val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            var data = response.data;
                            var user = data.user;
                            var penawaran = data.penawaran;
                            var transaksi = data.transaksi;
                            if(user != null) {
                                var activeUser = user.active;
                                var disableUser = user.disable;
                                var totalUser = user.total;
                                $(".countActiveUser").html(activeUser);
                                $(".countNonactiveUser").html(disableUser);
                                $(".countTotalUser").html(totalUser);
                            }
                            if(penawaran != null) {
                                var activePenawaran = penawaran.active;
                                var disablePenawaran = penawaran.disable;
                                var totalPenawaran = penawaran.total;
                                $(".countActivePenawaran").html(activePenawaran);
                                $(".countNonactivePenawaran").html(disablePenawaran);
                                $(".countTotalPenawaran").html(totalPenawaran);
                            }
                            if(transaksi != null) {
                                var activeTransaksi = transaksi.active;
                                var disableTransaksi = transaksi.disable;
                                var totalTransaksi = transaksi.total;
                                $(".countActiveTransaksi").html(activeTransaksi);
                                $(".countNonactiveTransaksi").html(disableTransaksi);
                                $(".countTotalTransaksi").html(totalTransaksi);
                            }
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    },
                    error: function(err, errorThrown, textStatus) {
                        $.konveksi.showModal(errorThrown);
                    }
                });
            }


        </script>
    @endif
@endsection