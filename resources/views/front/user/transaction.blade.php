@extends('front.layouts.ec')
@section('title', 'Transaksi Saya')
@section('content')
    <div class="page-white page-user pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('user.transaction') !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        echo \Lintas\libraries\CBlocks::render('member/account/nav');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{ __('Transaksi Saya') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="transaction_table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Project</th>
                                            <th>Harga Project</th>
                                            <th>Dibuat</th>
                                            <th>Diubah</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailTransaction" aria-label="modalDetailTransaction" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Project</label>
                                <div class="controls">
                                    <span class="label " name="name" id="name"></span>
                                </div>
                            </div>
                            <div class="control-group ">
                                    <label id="" class="form-label control-label">Image</label>
                                    <div class="controls">
                                        <div class="profile-img border p-2">
                                            <div class="img-profile-container ">
                                                <img src="" alt=""
                                                    onerror="this.src='{{ asset('public/img/no_image.png') }}'"
                                                    class="account-profile-image w-100 z-depth-1 detail-project-img"/>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Ukuran</label>
                                <div class="controls">
                                    <div id="detail_ukuran">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Tipe</label>
                                <div class="controls">
                                    <span class="label " name="type" id="type"></span>
                                </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Pembuat</label>
                                <div class="controls">
                                    <span class="label " name="creator" id="creator"></span>
                                </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Harga</label>
                                <div class="controls">
                                    <span class="label " name="price" id="price"></span>
                                </div>
                            </div>
                            {{-- <div class="control-group ">
                                <label id="" class="form-label control-label">Total Transaksi</label>
                                <div class="controls">
                                    <span class="label " name="transaction_total" id="transaction_total"></span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label id="" class="form-label control-label">IKM</label>
                                <div class="controls">
                                    <span class="label " name="ikm_name" id="ikm_name"></span>
                                </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Catatan</label>
                                <div class="controls">
                                    <span class="label " name="note" id="note"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary " id="btnApprove">Setujui Transaksi</button>
                </div> --}}

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalProgress" aria-label="modalProgress" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Progress</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="update_progress_form">
                        <?php
                            $progress = array(
                                array(
                                    'class'=>'primary',
                                    'name'=>'membuat pola',
                                    'code'=>'membuat_pola'
                                ),
                                array(
                                    'class'=>'primary',
                                    'name'=>'memotong',
                                    'code'=>'memotong'
                                ),
                                array(
                                    'class'=>'primary',
                                    'name'=>'menjahit',
                                    'code'=>'menjahit'
                                ),
                                array(
                                    'class'=>'primary',
                                    'name'=>'finishing',
                                    'code'=>'finishing'
                                ),
                                array(
                                    'class'=>'primary',
                                    'name'=>'pengepakan',
                                    'code'=>'pengepakan'
                                ),
                                array(
                                    'class'=>'primary',
                                    'name'=>'pengiriman',
                                    'code'=>'pengiriman'
                                )
                            );
                        ?>
                        <div class="input-field mt-4">
                            <div class="form-group">
                                <label class="active"><?php echo __('Progress'); ?></label>
                                <select id="progress" name="progress" class="form-control custom-select" >
                                    <option value="" disabled selected><?php echo __('Pilih Progress'); ?></option>
                                    <?php
                                        foreach ($progress as $k => $v):
                                            $selected = '';
                                    ?>
                                        <option value="<?php echo Str::lower(Arr::get($v, 'code')); ?>"><?php echo Arr::get($v, 'name'); ?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>

                        </div>
                        <input type="hidden" id="transaksiIdProgress" class="" value=""/>
                        <div class="form-actions clear-both">
                            <a class="btn btn-primary submit-form" id="btnSubmitProgress" href="javascript:;">Submit</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalLihatCheckout" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Checkout</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div id="div-error">
                        <div class=" form-request-info text-center">
                            <span style="color:red;">{{ __('Data checkout tidak ada') }}</span>
                        </div>
                    </div>
                    <div id="div-checkout">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <label id="" class="form-label control-label">Invoice</label>
                                    <div class="controls">
                                        <span class="label" name="checkout_invoice" id="checkout_invoice"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Project</label>
                                    <div class="controls">
                                        <span class="label" name="checkout_project_name" id="checkout_project_name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">IKM</legend>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Nama</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_name" id="buyer_ikm_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Alamat</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_address" id="buyer_ikm_address"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Telepon</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_phone" id="buyer_ikm_phone"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Provinsi</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_province_name" id="buyer_ikm_province_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Kota</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_city_name" id="buyer_ikm_city_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Bank</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_bank" id="buyer_ikm_bank"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Jasa Kurir</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_courier" id="buyer_ikm_courier"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Bayar</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_ikm_total_payment" id="buyer_ikm_total_payment"></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Penjahit</legend>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Nama</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_name" id="buyer_penjahit_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Alamat</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_address" id="buyer_penjahit_address"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Telepon</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_phone" id="buyer_penjahit_phone"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Provinsi</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_province_name" id="buyer_penjahit_province_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Kota</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_city_name" id="buyer_penjahit_city_name"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Bank</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_bank" id="buyer_penjahit_bank"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Jasa Kurir</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_courier" id="buyer_penjahit_courier"></span>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <label id="" class="form-label control-label">Bayar</label>
                                        <div class="controls">
                                            <span class="label" name="buyer_penjahit_total_payment" id="buyer_penjahit_total_payment"></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Barang</label>
                                    <div class="controls">
                                        <span class="label" name="checkout_barang" id="checkout_barang"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Metode Pembayaran</label>
                                    <div class="controls">
                                        <span class="label" name="checkout_payment_method" id="checkout_payment_method"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Total Pembayaran</label>
                                    <div class="controls">
                                        <span class="label" name="checkout_payment_total" id="checkout_payment_total"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="checkout_transaksi_id" id="checkout_transaksi_id" value=""/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success " id="btnApprove">Setujui Transaksi</button>
                    <button type="button" class="btn btn-primary " id="btnFormPKS">Lihat Form PKS</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKonfirmasiBayar" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Bukti Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_submit_bukti_revisi" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-8">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Bukti</label>
                                    <div class="controls">
                                        <img id="pembayaran_bukti_img" class="" src=""
                                            class="img-responsive" style="width:130px"
                                            onerror="this.src='{{ asset('public/img/no_image.png') }}'"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="pembayaran_trans_id" id="pembayaran_trans_id" value=""/>
                        <hr>
                        <div>
                            <button class="btn btn-primary" id="btnKonfirmasiPembayaran" type="button">Setujui Bukti Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRevisi" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revisi</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_submit_revisi" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kode Transaksi</label>
                                    <div class="controls">
                                        <span class="label" name="transaksi_code" id="transaksi_code"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Tanggal Transaksi</label>
                                    <div class="controls">
                                        <span class="label" name="transaksi_date" id="transaksi_date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Invoice</label>
                                    <div class="controls">
                                        <span class="label" name="delivery_invoice" id="delivery_invoice"></span>
                                    </div>
                                    <input type="hidden" name="invoice" id="invoice" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Note</label>
                                    <div class="controls">
                                        <textarea class="form-control summernote "
                                            placeholder="Note.." id="note" tabindex="9"
                                            name="note">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="transaksi_id" id="transaksi_id" value=""/>
                        <input type="hidden" name="delivery_id" id="delivery_id" value=""/>
                        <input type="hidden" name="ikm_id_rev" id="ikm_id_rev" value=""/>
                        <input type="hidden" name="penjahit_id_rev" id="penjahit_id_rev" value=""/>
                        <hr>
                        <div>
                            <button class="btn btn-primary" id="btnSubmitRevisi" type="button">Submit Revisi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalFormPKS" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form PKS</h4>
                    <button type="button" class="close" id="btnClosePKS">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_pks" enctype="multipart/form-data" action="{{ route('api.pks_download') }}">
                        @csrf
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" readonly
                                id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}"/>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">No ID Perusahaan</label>
                            <input type="text" class="form-control" readonly
                                id="nomor_perusahaan" name="nomor_perusahaan" value="{{ old('nomor_perusahaan') }}"/>
                        </div>
                        <div class="form-group">
                            <label id="" class="form-label control-label">Jangka Waktu</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control only-number" readonly
                                        id="jangka_waktu" name="jangka_waktu" value="{{ old('jangka_waktu') }}"/>
                                </div>
                                <div class="col-8" style="padding:0">
                                    <span style="position:relative;top:5px">Bulan</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Spesifikasi Project</label>
                            <div class="form-control-static">
                                <div class="row">
                                    <div class="col text-left">
                                        <img id="image0" class="detail_produk_img" src=""
                                            class="img-responsive" style="width:130px"
                                            onerror="this.src='{{ asset('public/img/no_image.png') }}'" style="width:150px;"/>
                                    </div>
                                    <div class="col text-left">
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Detail Project</legend>
                                            <div class="detail_produk"></div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Bahan Project</label>
                            <div class="form-control-static">
                                <div class="text-justify" id="bahan"></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label id="" class="form-label control-label">Ukuran + Jumlah Order</label>
                            <div class="form-control-static">
                                <div class="" id="ukuran_div"></div>
                            </div>
                        </div>
                        <input type="hidden" name="penjahit_id_pks" id="penjahit_id_pks" value=""/>
                        <input type="hidden" name="penjahit_name_pks" id="penjahit_name_pks" value=""/>
                        <input type="hidden" name="penjahit_address_pks" id="penjahit_address_pks" value=""/>
                        <input type="hidden" name="ikm_id_pks" id="ikm_id_pks" value=""/>
                        <input type="hidden" name="ikm_name_pks" id="ikm_name_pks" value=""/>
                        <input type="hidden" name="ikm_address_pks" id="ikm_address_pks" value=""/>
                        <input type="hidden" name="pks_date" id="pks_date" value=""/>
                        <input type="hidden" name="transaksi_price" id="transaksi_price" value=""/>
                        <input type="hidden" name="project_id_pks" id="project_id_pks" value=""/>
                        <input type="hidden" name="project_name_pks" id="project_name_pks" value=""/>
                        <input type="hidden" name="project_date_pks" id="project_date_pks" value=""/>
                        <hr>
                        <div>
                            <button type="submit" class="btn btn-primary " id="btnDownloadPKS">Download Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalLihatRevisi" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Revisi</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group">
                                <label id="" class="form-label control-label">Invoice</label>
                                <div class="controls">
                                    <span class="label" name="revisi_invoice" id="revisi_invoice"></span>
                                </div>
                            </div>
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Project</label>
                                <div class="controls">
                                    <span class="label" name="revisi_project_name" id="revisi_project_name"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">IKM</legend>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nama</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_name" id="revisi_ikm_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Alamat</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_address" id="revisi_ikm_address"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Telepon</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_phone" id="revisi_ikm_phone"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Provinsi</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_province_name" id="revisi_ikm_province_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kota</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_city_name" id="revisi_ikm_city_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Bank</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_bank" id="revisi_ikm_bank"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Jasa Kurir</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_courier" id="revisi_ikm_courier"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Bayar</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_ikm_total_payment" id="revisi_ikm_total_payment"></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Barang</label>
                                <div class="controls">
                                    <span class="label" name="revisi_barang" id="revisi_barang"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Note</label>
                                <div class="controls">
                                    <span class="label" name="revisi_note" id="revisi_note"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="revisi_transaksi_id" id="revisi_transaksi_id" value=""/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary " id="btnCheckout">Lanjut Ke Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            Number.prototype.format = function (n, x, s, c) {
                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                        num = this.toFixed(Math.max(0, ~~n));
                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
            };

            var transaction_table = $("#transaction_table").DataTable({
                ajax: {
                    url: "{{ route('api.transaksi_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function ( d ){
                        d.penjahit_id = "{{ \Lintas\libraries\CMemberLogin::get('id') }}";
                    },
                    type: "post",
                    dataType: "json",
                },
                processing: true,
                responsive: true,
                dom: "B<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'<'#colvis'>p>>",
                buttons: [
                    {
                        extend: "csv",
                        className: "datatable-buttons",
                        exportOptions: {
                            orthogonal: 'exportxlsx'
                        },
                        filename: 'Report Transaction',
                        title: 'Report Transaction',
                    },
                    {
                        extend: "excel",
                        className: "datatable-buttons",
                        exportOptions: {
                            orthogonal: 'exportxlsx'
                        },
                        filename: 'Report Transaction',
                        title: 'Report Transaction',
                    },
                ],
                'columns': [
                    { data: "code" },
                    { data: "project" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return "{{ config('cart.currency') }}" + " " + (Number(data.price).format(2, 3));
                        }
                    },
                    // {
                    //     data: null,
                    //     render: function(data, type, row) {
                    //         return "{{ config('cart.currency') }}" + " " + (Number(data.payment).format(2, 3));
                    //     }
                    // },
                    { data: "created_at" },
                    { data: "updated_at" },
                    { data: "status" },
                    { data: "progress" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var button = '';
                            btn_group = "<div class='btn-group btn-group-toggle ml-auto' data-toggle='buttons'>";
                            btn_group += "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action</button>";
                                act_group = "<div class='dropdown-menu'>";
                                    act_group += "<a class='dropdown-item btnDetail' href='javascript:void(0)'" + "data-id="+data.id+">Detail</a>";
                                     /*
                                        pending -> ketika awal perpindahan dari penawaran ke transaksi (di dua"nya)
                                        waited payment -> sebelum ada bukti pembayaran & upload bukti pembayaran (tugas ikm)
                                        payment confirmed -> sudah dilihat bukti pembayaran dan penjahit setuju -> di penjahit trus dapat 'lihat checkout' (detail checkout,pks, bs revisi)
                                        in progress -> waktu udah bayar dan udah ada pks(oenjahit uda setuju checkout) -> penjahit update progress pengerjaan
                                        waited confirmed -> (tugas ikm) -> ikm dapat 'lihat checkout' ikm
                                        done -> udah setuju kedua pihak
                                    */
                                    if(data.status == "Waited Payment") {
                                        act_group += "<a class='dropdown-item btnBuktiPembayaran' href='javascript:void(0)'" + "data-id="+data.id+">Konfirmasi Bukti Pembayaran</a>";
                                    }
                                    else if(data.status == "Payment Confirmed") {
                                        act_group += "<a class='dropdown-item btnLihatCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Lihat Checkout</a>";
                                        //act_group += "<a class='dropdown-item btnProgress' href='javascript:void(0)'" + "data-id="+data.id+">Update Progress</a>";
                                    }
                                    else if(data.status == "In Progress") {
                                        if(data.progress == "pengiriman")
                                            act_group += "<a class='dropdown-item btnCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Checkout</a>";
                                        else
                                            act_group += "<a class='dropdown-item btnProgress' href='javascript:void(0)'" + "data-id="+data.id+">Update Progress</a>";
                                    }
                                    else if(data.status == "Revisied") {
                                        act_group += "<a class='dropdown-item btnLihatRevisi' href='javascript:void(0)'" + "data-id="+data.id+">Lihat Revisi</a>";
                                    }
                                    //else if(data.status == "Waited Confirmed" || data.status == "Waited Confirmation") {
                                        // act_group += "<a class='dropdown-item btnLihatCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Lihat Checkout</a>";
                                    //}
                                    else if(data.status == "Done") {
                                        act_group += "<a class='dropdown-item btnReview' href='javascript:void(0)'" + "data-id="+data.id+">Review</a>";
                                    }
                                    // if(data.status == 'Approve' && data.progress == 'pengiriman') {
                                    //     act_group += "<a class='dropdown-item btnCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Checkout</a>";
                                    // }
                                    // else if(data.status == "Payment Confirm" && data.payment_confirmed != '') {
                                    //     act_group += "<a class='dropdown-item btnBuktiPembayaran' href='javascript:void(0)'" + "data-id="+data.id+">Bukti Pembayaran</a>";
                                    // }
                                    // else if(data.progress != 'pengiriman') {
                                    //     act_group += "<a class='dropdown-item btnProgress' href='javascript:void(0)'" + "data-id="+data.id+">Update Progress</a>";
                                    // }
                                act_group += "</div>";
                            btn_group += act_group;
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    }
                ]
            });


            $("#transaction_table").on("click", ".btnBuktiPembayaran", function() {
                var id = $(this).data('id');
                var url = "{{ route('api.transaksi_lihat_bukti_transfer') }}";
                $.ajax({
                    url: url,
                    method: "post",
                    data: { transaksi_id: id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            $("#pembayaran_trans_id").val(id);
                            $("#pembayaran_bukti_img").attr('src', response.data.bukti_upload);
                            $("#modalKonfirmasiBayar").modal('show');
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                })

            });
            $("#btnKonfirmasiPembayaran").click(function() {
                var url = '{{ route("api.transaksi_confirm_transfer") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: { transaksi_id: $("#pembayaran_trans_id").val() },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                             $("#modalKonfirmasiBayar").modal('hide');
                            transaction_table.ajax.reload();
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            })

            $("#transaction_table").on('click', '.btnDetail', function () {
                var id = $(this).data('id');
                var url = '{{ route("api.transaksi_get_data") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: { transaksi_id : id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        var html='';
                        if(error == 0) {
                            var data = response.data;
                            var project = data.project;
                            var gambar_project = data.image_url;
                            var gambar_project_name = data.image_name;
                            var ukuran= data.ukuran;
                            var type = data.type;
                            var project_creator = data.project_creator;
                            var price = data.transaction_price;
                            var transaction_total = data.transaction_total;
                            // var offer_price_system = data.offer_price_system;
                            var note = data.note;
                            var ikm_name = data.ikm_name;
                            //var display = (data.transaction_status == "In Progress" ? "block" : "none");
                            $("#name").html(project);
                            $("#type").html(type);
                            html+="<div style='display:flex'>";
                            $.each(ukuran, function(i, val){
                                html+="<div style='width:50%'>";
                                    html+=val.ukuran_nama;
                                    html+="<div>"+val.qty+"</div>";
                                html+="</div>";
                            });
                            html+="</div>";
                            $("#detail_ukuran").html(html);
                            $(".detail-project-img").attr('src',gambar_project);
                            $("#creator").html(project_creator);
                            $("#price").html(price);
                            $("#ikm_name").html(ikm_name);
                            $("#transaction_total").html(transaction_total);
                            // $("#offer_price_system").html(offer_price_system);
                            $("#note").html(note);
                            //$("#btnApprove").css("display", display).data('id', id);
                            $("#modalDetailTransaction").modal('show');
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            });


            $("#transaction_table").on('click', '.btnLihatCheckout', function () {
                var id = $(this).data('id');
                var url = "{{ route('api.detail_checkout') }}";
                var penjahit_name,penjahit_address,
                    penjahit_phone,penjahit_province_name,
                    penjahit_city_name,penjahit_bank,
                    penjahit_courier,penjahit_method,
                    penjahit_total_payment,
                    ikm_name,ikm_address,ikm_phone,ikm_province_name,
                    ikm_city_name,ikm_bank,
                    ikm_courier,ikm_method,ikm_total_payment = '';
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        transaksi_id: id,
                    },
                    dataType: 'json',
                    success: function(response) {
                       var error = response.errCode;
                       var message = response.errMsg;

                        var html = "";
                        var ul = "";
                        var li = "";
                        if(error == 0) {
                            var data = response.data;
                            if(data.length == 0) {
                                $("#div-error").css('display', 'block');

                                $("#div-checkout").css('display', 'none');
                                $("#btnFormPKS").attr('disabled', true);
                                $("#btnRevisi").attr('disabled', true);
                            } else {
                                $("#div-error").css('display', 'none');

                                $("#div-checkout").css('display', 'block');
                                $("#btnFormPKS").attr('disabled', false);
                                $("#btnRevisi").attr('disabled', false);

                                var project_id = data.project_id;
                                var project_name = data.project_name;
                                var invoice = data.invoice;

                                var barang = data.barang;
                                if(barang != null) {
                                    var trys = barang.trim().split(",");
                                    ul += "<ul>";
                                    $.each(trys, function(i, val){
                                        li += "<li>";
                                        li += val;
                                        li += "</li>";
                                    })
                                    ul += li;
                                    ul += "</ul>";
                                    html = ul;
                                }

                                var dataPenjahit = data.penjahit;
                                if(dataPenjahit != null) {
                                    $.each(dataPenjahit, function(i, val) {
                                        penjahit_name = val.penjahit_name;
                                        penjahit_address = val.penjahit_address;
                                        penjahit_phone = val.penjahit_phone;
                                        penjahit_province_name = val.penjahit_province_name;
                                        penjahit_city_name = val.penjahit_city_name;
                                        penjahit_bank = val.penjahit_bank;
                                        penjahit_courier = val.penjahit_courier;
                                        //penjahit_method = val.penjahit_payment_method;
                                        penjahit_total_payment = val.penjahit_payment_total;
                                    });
                                }
                                var dataIkm = data.ikm;
                                if(dataIkm != null) {
                                    $.each(dataIkm, function(i, val_ikm) {
                                        ikm_name = val_ikm.ikm_name;
                                        ikm_address = val_ikm.ikm_address;
                                        ikm_phone = val_ikm.ikm_phone;
                                        ikm_province_name = val_ikm.ikm_province_name;
                                        ikm_city_name = val_ikm.ikm_city_name;
                                        ikm_bank = val_ikm.ikm_bank;
                                        ikm_courier = val_ikm.ikm_courier;
                                        //ikm_method = val_ikm.ikm_payment_method;
                                        ikm_total_payment = val_ikm.ikm_payment_total;
                                    });
                                }

                                var payment_method = data.payment_method;
                                var payment_ikm = "{{ config('cart.currency') }}" + " " + (Number(ikm_total_payment).format(2, 3));
                                //var payment_penjahit = "{{ config('cart.currency') }}" + " " + (Number(penjahit_total_payment).format(2, 3));
                                var payment_total = (Number(ikm_total_payment));
                                var label_payment_total = "{{ config('cart.currency') }}" + " " + (Number(payment_total).format(2, 3));

                                $("#checkout_invoice").html(invoice);
                                $("#checkout_transaksi_id").val(id);
                                $("#checkout_project_name").html(project_name);

                                //--
                                // $("#buyer_penjahit_name").html(penjahit_name);
                                // $("#buyer_penjahit_address").html(penjahit_address);
                                // $("#buyer_penjahit_phone").html(penjahit_phone);
                                // $("#buyer_penjahit_province_name").html(penjahit_province_name);
                                // $("#buyer_penjahit_city_name").html(penjahit_city_name);
                                // $("#buyer_penjahit_bank").html(penjahit_bank);
                                // $("#buyer_penjahit_courier").html(penjahit_courier);
                                // $("#buyer_penjahit_method").html(penjahit_method);
                                // $("#buyer_penjahit_total_payment").html(payment_penjahit);

                                //--
                                $("#buyer_ikm_name").html(ikm_name);
                                $("#buyer_ikm_address").html(ikm_address);
                                $("#buyer_ikm_phone").html(ikm_phone);
                                $("#buyer_ikm_province_name").html(ikm_province_name);
                                $("#buyer_ikm_city_name").html(ikm_city_name);
                                $("#buyer_ikm_bank").html(ikm_bank);
                                $("#buyer_ikm_courier").html(ikm_courier);
                                //$("#buyer_ikm_method").html(ikm_method);
                                $("#buyer_ikm_total_payment").html(payment_ikm);
                                $("#checkout_barang").html(html);
                                $("#checkout_payment_method").html(payment_method);
                                $("#checkout_payment_total").html(label_payment_total);
                            }
                            $("#modalLihatCheckout").modal('show');
                       } else {
                            $.konveksi.showModal(message);
                       }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            });
            $("#btnApprove").click(function() {
                swal({
                    title: "Apakah kamu yakin dengan aksi konfirmasi checkout ini?",
                    text: "Konfirmasi ini tidak bisa dibatalkan lagi.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if(isConfirm) {
                        var url = "{{ route('api.transaksi_approve') }}";
                        var transaksi_id = $("#checkout_transaksi_id").val();
                        $.ajax({
                            url: url,
                            data: {
                                transaksi_id: transaksi_id,
                                penjahit_id: "{{ \Lintas\libraries\CMemberLogin::get('id') }}"
                            },
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                var error = response.errCode;
                                var message = response.errMsg;
                                if(error == 0) {
                                    transaction_table.ajax.reload();
                                    $("#modalLihatCheckout").modal('hide');
                                } else {
                                    $.konveksi.showModal(message);
                                }
                            },
                            error: function(err, errThrown, textStatus) {
                                $.konveksi.showModal(errThrown);
                            }
                        });
                    }
                });
            });
            $("#btnRevisi").click(function(){
                swal({
                    title: "Apakah kamu yakin dengan aksi revisi checkout ini?",
                    text: "Permintaan revisi akan membuat ulang data untuk checkout.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if(isConfirm) {
                        $("#modalLihatCheckout").modal('hide').on('hidden.bs.modal', function(e) {
                            var url = "{{ route('api.detail_data_transaksi') }}";
                            $.ajax({
                                url: url,
                                data: {
                                    transaksi_id: $("#checkout_transaksi_id").val(),
                                    penjahit_id: "{{ \Lintas\libraries\CMemberLogin::get('id') }}"
                                },
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: "json",
                                success: function(response) {
                                    var error = response.errCode;
                                    var msg = response.errMsg;
                                    if(error == 0) {
                                        var dt = response.data;
                                        var project_id = dt.project_id;
                                        var delivery_id = dt.delivery_id;
                                        var delivery_invoice = dt.delivery_invoice;
                                        var transaksi_id = dt.transaksi_id;
                                        var transaksi_code = dt.transaksi_code;
                                        var transaksi_date = dt.transaksi_date;
                                        var ikm_id_rev = dt.ikm_id_rev;
                                        var penjahit_id_rev = dt.penjahit_id_rev;

                                        //html
                                        $("#transaksi_code").html(transaksi_code);
                                        $("#transaksi_date").html(transaksi_date);
                                        $("#delivery_invoice").html(delivery_invoice);

                                        //hidden
                                        $("#project_id").val(project_id);
                                        $("#delivery_id").val(delivery_id);
                                        $("#transaksi_id").val(transaksi_id);
                                        $("#invoice").val(delivery_invoice);
                                        $("#ikm_id_rev").val(ikm_id_rev);
                                        $("#penjahit_id_rev").val(penjahit_id_rev);
                                    } else {
                                         $.konveksi.showModal(msg);
                                    }
                                },
                                error: function(err, errThrown, textStatus) {
                                    $.konveksi.showModal(errThrown);
                                }
                            });
                            $("#modalRevisi").modal('show');
                            $(this).off('hidden.bs.modal');
                        });;
                    }
                });
            })
            $("#btnSubmitRevisi").click(function() {
                var url = "{{ route('api.revisi_insert') }}";
                $.ajax({
                    url: url,
                    data: $("#form_submit_revisi").serialize(),
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            $("#modalRevisi").modal('hide');
                            transaction_table.ajax.reload();
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            })
            $("#btnFormPKS").click(function() {
                var transaksi_id = $("#checkout_transaksi_id").val();
                var url = "{{ route('api.pks_detail') }}";

                var ukuran_html = '';
                var produk_html = '';

                $.ajax({
                    url: url,
                    method: "post",
                    data: { transaksi_id: transaksi_id },
                    dataType: 'json',
                    success: function(response) {
                       var error = response.errCode;
                       var message = response.errMsg;
                       if(error == 0) {
                            var data = response.data;
                            var nama_perusahaan = data.nama_perusahaan;
                            var nomor_perusahaan = data.nomor_perusahaan;
                            var jangka_waktu = data.jangka_waktu;
                            var transaksi_price = data.transaksi_price;
                            var bahan = data.bahan;
                            var project_img = data.image;
                            var ukuran = data.ukuran;
                            if(ukuran != null) {
                                if(ukuran.length > 0) {
                                    ukuran_html += '<div class="row col-md-6">';
                                    $.each(ukuran, function(i, val) {
                                        ukuran_html += "<div class='col-md-3'>";
                                        ukuran_html += val.ukuran_nama;
                                            var ukuran_sub = "<div>"+val.qty+"</div>";
                                        ukuran_html += ukuran_sub;
                                        ukuran_html += "</div>";
                                    });
                                    ukuran_html += '</div>';
                                } else {
                                    ukuran_html += '<div class="col-md-3">-</div>';
                                }
                            }
                            var project_id_pks = data.project_id;
                            var project_nama = data.project_nama;
                            var project_code = data.code;
                            if(project_nama != null && project_code != null) {
                                produk_html += '<div class="details">';
                                    var name = "<div><b>Project</b> "+project_nama+"</div>";
                                    var code = "<div><b>Code</b> "+project_code+"</div>";
                                produk_html += name;
                                produk_html += code;
                                produk_html += '</div>';
                            }
                            var ikm_id_pks = data.ikm_id;
                            var ikm_name_pks = data.ikm_name;
                            var ikm_address_pks = data.ikm_address;
                            var penjahit_id_pks = data.penjahit_id;
                            var penjahit_name_pks = data.penjahit_name;
                            var penjahit_address_pks = data.penjahit_address;
                            var pks_date = data.pks_date;
                            var project_date_pks = data.project_date;

                            $("#nama_perusahaan").val(nama_perusahaan);
                            $("#nomor_perusahaan").val(nomor_perusahaan);
                            $("#jangka_waktu").val(jangka_waktu);
                            $("#ukuran_div").html(ukuran_html);
                            $("#bahan").html(bahan);
                            $(".detail_produk").html(produk_html);
                            $(".detail_produk_img").attr('src', project_img);
                            $("#ikm_id_pks").val(ikm_id_pks);
                            $("#ikm_name_pks").val(ikm_name_pks);
                            $("#ikm_address_pks").val(ikm_address_pks);
                            $("#penjahit_id_pks").val(penjahit_id_pks);
                            $("#penjahit_name_pks").val(penjahit_name_pks);
                            $("#penjahit_address_pks").val(penjahit_address_pks);
                            $("#pks_date").val(pks_date);
                            $("#transaksi_price").val(transaksi_price);
                            $("#project_date_pks").val(project_date_pks);
                            $("#project_id_pks").val(project_id_pks);
                            $("#project_name_pks").val(project_nama);
                            $("#modalLihatCheckout").modal('hide').on('hidden.bs.modal', function(e) {
                                $("#modalFormPKS").modal('show');
                                $(this).off('hidden.bs.modal');
                            });
                       }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            })
            //action modal pks
            $("#btnClosePKS").click(function() {
                $("#modalFormPKS").modal('hide').on('hidden.bs.modal', function(e) {
                    $("#modalLihatCheckout").modal('show');
                    $(this).off('hidden.bs.modal');
                });
            });
            // $("#btnDownloadPKS").click(function() {
            //     var url = "";
            //     $.ajax({
            //         url: url,
            //         method: "post",
            //         data: $("#form_pks").serialize(),
            //         dataType: 'json',
            //         success: function(response) {
            //             //
            //         },
            //         error: function(err, errThrown, textStatus) {
            //             $.konveksi.showModal(errThrown);
            //         }
            //     });
            // });

            // $("#btnApprove").click(function() {
            //     var id = $(this).data('id');
            //     var url = '';
            //     url = url.replace(":id", id);
            //     swal({
            //         title: "Apakah kamu yakin?",
            //         text: "konfirmasi transaksi ini tidak dapat dibatalkan.",
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonColor: "#DD6B55",
            //         confirmButtonText: "Yes",
            //         cancelButtonText: "No",
            //         closeOnConfirm: true,
            //         closeOnCancel: true
            //     }, function(isConfirm) {
            //         if (isConfirm) {
            //             $.ajax({
            //                 url: url,
            //                 data: { id: id },
            //                 method: "POST",
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 dataType: "json",
            //                 success: function(response) {
            //                     var error = response.errCode;
            //                     var msg = response.errMsg;
            //                     if(error == 0) {
            //                         transaction_table.ajax.reload();
            //                         $("#modalDetailTransaction").modal('hide');

            //                         //munculkan modal update progress
            //                         $("#transaksiIdProgress").val(id);
            //                         $("#modalProgress").modal('show');
            //                     } else {
            //                         $.konveksi.showModal(msg);
            //                     }
            //                 }
            //             });
            //         }
            //     });
            // });


            $("#transaction_table").on("click", ".btnProgress", function() {
                var id = $(this).data('id'); //id transaksi
                $("#transaksiIdProgress").val(id);
                $("#modalProgress").modal('show');
            });
            $("#btnSubmitProgress").click(function() {
                $.ajax({
                   url: "{{ route('api.transaksi_update_progress') }}",
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   method: "POST",
                   data: {
                       transaksi_id: $("#transaksiIdProgress").val(),
                       progress: $("#progress option:selected").text()
                   },
                   dataType: 'json',
                   success: function(response) {
                       var error = response.errCode;
                       var msg = response.errMsg;
                       if(error == 0) {
                           $("#modalProgress").modal('hide');
                           transaction_table.ajax.reload();
                       } else {
                           $.konveksi.showModal(msg);
                       }
                   }
                })
            });


            //
            $("#transaction_table").on('click', '.btnLihatRevisi', function() {
                var id = $(this).data('id');
                var url = "{{ route('api.detail_revisi') }}";
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: { transaksi_id: id },
                    success: function(response) {
                        var error = response.errCode;
                        var message = response.errMsg;
                        if(error == 0) {
                            var dt = response.data;
                            var transaksi_id = dt.transaksi_id;

                            //tampilkan punya penjahit
                            var project_name = dt.project_name;
                            var invoice = dt.invoice;
                            var barang = dt.barang;
                            //var payment_method = dt.payment_method;
                            var payment_total = dt.payment_total;
                            var note = dt.note;
                            var ul = '';
                            var li = '';
                            if(barang != null) {
                                var trys = barang.trim().split(",");
                                ul += "<ul>";
                                $.each(trys, function(i, val){
                                    li += "<li>";
                                    li += val;
                                    li += "</li>";
                                })
                                ul += li;
                                ul += "</ul>";
                                html = ul;
                            }
                            var dataIkm = dt.ikm;
                            if(dataIkm != null) {
                                $.each(dataIkm, function(i, val) {
                                    ikm_name = val.ikm_name;
                                    ikm_address = val.ikm_address;
                                    ikm_phone = val.ikm_phone;
                                    ikm_province_name = val.ikm_province_name;
                                    ikm_city_name = val.ikm_city_name;
                                    ikm_bank = val.ikm_bank;
                                    ikm_courier = val.ikm_courier;
                                    ikm_total_payment = val.ikm_payment_total;

                                    $("#revisi_ikm_name").html(ikm_name);
                                    $("#revisi_ikm_address").html(ikm_address);
                                    $("#revisi_ikm_phone").html(ikm_phone);
                                    $("#revisi_ikm_province_name").html(ikm_province_name);
                                    $("#revisi_ikm_city_name").html(ikm_city_name);
                                    $("#revisi_ikm_bank").html(ikm_bank);
                                    $("#revisi_ikm_courier").html(ikm_courier);
                                    $("#revisi_ikm_total_payment").html(ikm_total_payment);
                                });
                            }
                            //

                            var label_payment_total = "{{ config('cart.currency') }}" + " " + (Number(payment_total).format(2, 3));
                            $("#revisi_transaksi_id").val(transaksi_id);
                            $("#revisi_invoice").html(invoice);
                            $("#revisi_project_name").html(project_name);
                            $("#revisi_barang").html(html);
                            //$("#revisi_payment_method").html(payment_method);
                            $("#revisi_payment_total").html(label_payment_total);
                            $("#revisi_note").html(note);
                            $("#modalLihatRevisi").modal('show');
                        }
                    }
                });
            });
            $("#btnCheckout").on('click', function() {
                $.ajax({
                    url: "{{ route('api.transaksi_session') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: { transaksi_id: $("#revisi_transaksi_id").val() },
                    success: function(response) {
                        window.location.href = "{{ route('checkout.address') }}";
                    }
                });
            })
            $("#transaction_table").on("click", ".btnCheckout", function() {
                var transaksi_id = $(this).data('id');
                var url = "{{ route('api.transaksi_session') }}";
                $.ajax({
                    url: url,//
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: { transaksi_id: transaksi_id },
                    success: function(response) {
                            window.location.href = "{{ route('checkout.address') }}";
                    }
                });
            });


            //
            $("#transaction_table").on("click", ".btnReview", function() {
                var transaksi_id = $(this).data('id'); //id transaksi
                var url = "{{ route('review', ':id') }}";
                url = url.replace(":id", 'transaksi_id=' + transaksi_id);
                window.location.href = url;
                // $.ajax({
                //     url: "",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     method: "POST",
                //     data: { id: id },
                //     success: function(response) {
                //         var error = response.errCode;
                //         var msg = response.errMsg;
                //         if(error == 0) {
                //             window.location.href = "";
                //         } else {
                //             $.konveksi.showModal(msg);
                //         }
                //     }
                // });
            });
        });

    </script>
@endsection