@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-sm-3">
            @include('admin/inc/ikm/side')
        </div>
        <div class="col-sm-9">
            <div class="ibox d-none">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="" class="form-horizontal">
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Tanggal</label>
                            <div class="controls">
                                <input type="text" id="start_date" class="form-control datepicker" autocomplete="off" />
                                <span class="input-group-addon" style="border:0;background:none">/</span>
                                <input type="text" id="end_date" class="form-control datepicker" autocomplete="off" />
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="form-actions clear-both  submit-form">
                            <a id="btn_submit" href="javascript:;" class="btn btn-primary">Tampilkan</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="transaction_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Project</th>
                                    <th>Harga Project</th>
                                    <th>Harga Penawaran</th>
                                    <th>Progress</th>
                                    <th>Dibuat</th>
                                    <th>Diubah</th>
                                    <th>Status</th>
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
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Total Transaksi</label>
                                <div class="controls">
                                    <span class="label " name="transaction_total" id="transaction_total"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label id="" class="form-label control-label">Penjahit</label>
                                <div class="controls">
                                    <span class="label " name="penjahit_name" id="penjahit_name"></span>
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


    <div class="modal fade" id="modalUploadTransfer" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Bukti Transfer</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <form id="formUploadTransfer" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <div style="margin-bottom:10px;color:#333;">Size file maksimal 20MB</div>
                                <input name="fileUploadTransfer" id="fileUploadTransfer" type="file" accept="image/*">
                                <label for="file-uploader" style="margin-top:5px;font-size:12px;color:#333">Hanya dapat mengupload tipe file gambar saja (.png, .jpg, .bmp, .gif, etc).</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" id="transactionID">
                        <hr>
                        <div>
                            <button class="btn btn-primary" id="btnUploadTransfer" type="button">Upload</button>
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
                        <div class="col-md-6" style="display:none">
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
                        <div class="col-md-6">
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
                    <input type="hidden" name="checkout_transaksi_id" id="checkout_transaksi_id" value=""/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary " id="btnApprove">Setujui Transaksi</button>
                    <button type="button" class="btn btn-warning " id="btnRevisi">Revisi</button>
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
                                <legend class="scheduler-border">Penjahit</legend>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nama</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_name" id="revisi_penjahit_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Alamat</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_address" id="revisi_penjahit_address"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Telepon</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_phone" id="revisi_penjahit_phone"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Provinsi</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_province_name" id="revisi_penjahit_province_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kota</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_city_name" id="revisi_penjahit_city_name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Bank</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_bank" id="revisi_penjahit_bank"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Jasa Kurir</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_courier" id="revisi_penjahit_courier"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Bayar</label>
                                    <div class="controls">
                                        <span class="label" name="revisi_penjahit_total_payment" id="revisi_penjahit_total_payment"></span>
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
                                <label id="" class="form-label control-label">Metode Pembayaran</label>
                                <div class="controls">
                                    <span class="label" name="revisi_payment_method" id="revisi_payment_method"></span>
                                </div>
                            </div>
                        </div>
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


            var ikm_id = "{{ \Lintas\libraries\CUserLogin::get('id') }}";
            var transaction_table = $("#transaction_table").DataTable({
                ajax: {
                    url: "{{ route('api.transaksi_list') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function ( d ){
                        d.ikm_id = ikm_id;
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
                        title: 'Admin | Report Transaction',
                    },
                    {
                        extend: "excel",
                        className: "datatable-buttons",
                        exportOptions: {
                            orthogonal: 'exportxlsx'
                        },
                        filename: 'Report Transaction',
                        title: 'Admin | Report Transaction',
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
                    {
                        data: null,
                        render: function(data, type, row) {
                            return "{{ config('cart.currency') }}" + " " + (Number(data.transaction_price).format(2, 3));
                        }
                    },
                    { data: "progress" },
                    { data: "created_at" },
                    { data: "updated_at" },
                    { data: "status" },
                    {
                        data:null,
                        render: function(data, type, row) {
                            var button = '';
                            btn_group = "<div class='btn-group btn-group-toggle ml-auto' data-toggle='buttons'>";
                            btn_group += "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action</button>";
                                act_group = "<div class='dropdown-menu'>";
                                    act_group += "<a class='dropdown-item btnDetail' href='javascript:void(0)'" + "data-id="+data.id+">Detail</a>";
                                    /*
                                        pending -> ketika awal transaksi -> harus apa duluan?
                                        waited payment -> sebelum ada bukti pembayaran
                                        payment confirmed -> sudah dilihat bukti pembayaran dan ikm setuju (tugas penjahit)
                                        in progress -> waktu udah bayar dan udah ada pks (tugas penjahit)
                                        done -> udah setuju kedua pihak (setelah ada pks)
                                        cancel -> intinya batal (tapi ga ada difitur utama) x
                                        waited confirmed -> intinya lihat checkout
                                    */
                                    if(data.status == "Pending") {
                                        act_group += "<a class='dropdown-item btnKerjasama' href='javascript:void(0)'" + "data-id="+data.id+">Lanjut ke Form Kerjasama</a>";
                                    }
                                    else if(data.status == "Waited Payment") {
                                        act_group += "<a class='dropdown-item btnBuktiTransfer' href='javascript:void(0)'" + "data-id="+data.id+">Upload Bukti Pembayaran</a>";
                                    }
                                    else if(data.status == "Waited Confirmed" || data.status == "Waited Confirmation") {
                                        act_group += "<a class='dropdown-item btnLihatCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Lihat Checkout</a>";
                                    }
                                    else if(data.status == "Revisied") {
                                        act_group += "<a class='dropdown-item btnLihatRevisi' href='javascript:void(0)'" + "data-id="+data.id+">Lihat Revisi</a>";
                                    }
                                    else if(data.status == "Done") {
                                        act_group += "<a class='dropdown-item btnReview' href='javascript:void(0)'" + "data-id="+data.id+">Review</a>";
                                    }
                                act_group += "</div>";
                            btn_group += act_group;
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    }
                ]
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
                    data: { transaksi_id: id },
                    dataType: 'json',
                    success: function(response) {
                       var error = response.errCode;
                       var message = response.errMsg;
                       if(error == 0) {
                            var data = response.data;
                            var project_id = data.project_id;
                            var project_name = data.project_name;
                            var invoice = data.invoice;
                            var ul = '';
                            var li = '';
                            var html = '';
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
                            //var payment_ikm = "{{ config('cart.currency') }}" + " " + (Number(ikm_total_payment).format(2, 3));
                            var payment_penjahit = "{{ config('cart.currency') }}" + " " + (Number(penjahit_total_payment).format(2, 3));
                            var payment_total = (Number(penjahit_total_payment));
                            var label_payment_total = "{{ config('cart.currency') }}" + " " + (Number(payment_total).format(2, 3));

                            $("#checkout_invoice").html(invoice);
                            $("#checkout_transaksi_id").val(id);
                            $("#checkout_project_name").html(project_name);

                            //--
                            $("#buyer_penjahit_name").html(penjahit_name);
                            $("#buyer_penjahit_address").html(penjahit_address);
                            $("#buyer_penjahit_phone").html(penjahit_phone);
                            $("#buyer_penjahit_province_name").html(penjahit_province_name);
                            $("#buyer_penjahit_city_name").html(penjahit_city_name);
                            $("#buyer_penjahit_bank").html(penjahit_bank);
                            $("#buyer_penjahit_courier").html(penjahit_courier);
                            //$("#buyer_penjahit_method").html(penjahit_method);
                            $("#buyer_penjahit_total_payment").html(payment_penjahit);

                            //--
                            // $("#buyer_ikm_name").html(ikm_name);
                            // $("#buyer_ikm_address").html(ikm_address);
                            // $("#buyer_ikm_phone").html(ikm_phone);
                            // $("#buyer_ikm_province_name").html(ikm_province_name);
                            // $("#buyer_ikm_city_name").html(ikm_city_name);
                            // $("#buyer_ikm_bank").html(ikm_bank);
                            // $("#buyer_ikm_courier").html(ikm_courier);
                            // $("#buyer_ikm_method").html(ikm_method);
                            // $("#buyer_ikm_total_payment").html(payment_ikm);

                            $("#checkout_barang").html(html);
                            $("#checkout_payment_method").html(payment_method);
                            $("#checkout_payment_total").html(label_payment_total);
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



            $("#transaction_table").on('click', '.btnBuktiTransfer', function () {
                var id = $(this).data('id');
                $("#transactionID").val(id);
                $("#modalUploadTransfer").modal('show');
            });
            $("#btnUploadTransfer").click(function() {
                var transaction_id = $("#transactionID").val();;

                var form_data = new FormData();
                form_data.append('transaction_id', transaction_id);
                form_data.append('bukti_transfer', $("input[name=fileUploadTransfer]")[0].files[0]);

                var url = '{{ route("api.transaksi_bukti_transfer") }}';
                //url = url.replace(":id", transaction_id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            transaction_table.ajax.reload();
                            $("#modalUploadTransfer").modal('hide');
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
                    data: {
                        transaksi_id : id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        var html = '';
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
                            var penjahit_name = data.penjahit_name;
                            //var display = (data.transaction_status == "Approve" ? "block" : "none");
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
                            $("#penjahit_name").html(penjahit_name);
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

            //modal action
            //approve checkout
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
                            data: { transaksi_id: transaksi_id },
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
            //revisi checkout
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
                                    ikm_id: "{{ \Lintas\libraries\CUserLogin::get('id') }}"
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
            //batal


            //revisied
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
                            var payment_method = dt.payment_method;
                            var payment_total = dt.payment_total;
                            var note = dt.note;
                            var ul = '';
                            var li = '';
                            var html ='';
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
                            var dataPenjahit = dt.penjahit;
                            if(dataPenjahit != null) {
                                $.each(dataPenjahit, function(i, val) {
                                    penjahit_name = val.penjahit_name;
                                    penjahit_address = val.penjahit_address;
                                    penjahit_phone = val.penjahit_phone;
                                    penjahit_province_name = val.penjahit_province_name;
                                    penjahit_city_name = val.penjahit_city_name;
                                    penjahit_bank = val.penjahit_bank;
                                    penjahit_courier = val.penjahit_courier;
                                    penjahit_total_payment = val.penjahit_payment_total;

                                    $("#revisi_penjahit_name").html(penjahit_name);
                                    $("#revisi_penjahit_address").html(penjahit_address);
                                    $("#revisi_penjahit_phone").html(penjahit_phone);
                                    $("#revisi_penjahit_province_name").html(penjahit_province_name);
                                    $("#revisi_penjahit_city_name").html(penjahit_city_name);
                                    $("#revisi_penjahit_bank").html(penjahit_bank);
                                    $("#revisi_penjahit_courier").html(penjahit_courier);
                                    $("#revisi_penjahit_total_payment").html(penjahit_total_payment);
                                });
                            }
                            //

                            var label_payment_total = "{{ config('cart.currency') }}" + " " + (Number(payment_total).format(2, 3));
                            $("#revisi_transaksi_id").val(transaksi_id);
                            $("#revisi_invoice").html(invoice);
                            $("#revisi_project_name").html(project_name);
                            $("#revisi_barang").html(html);
                            $("#revisi_payment_method").html(payment_method);
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
                        window.location.href = "{{ route('admin.checkout.address') }}";
                    }
                });
            })
            // $("#transaction_table").on('click', '.btnCheckout', function () {
            //     var id = $(this).data('id');
            //     $.ajax({
            //         url: "",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         method: "POST",
            //         data: { transaksi_id: id },
            //         success: function(response) {
            //             window.location.href = "";
            //         }
            //     });
            // });

            //$("#btnApprove").click(function() {
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
            //                         //window.location.href = "";
            //                     } else {
            //                         $.konveksi.showModal(msg);
            //                     }
            //                 }
            //             });
            //         }
            //     });
            // });

            $("#transaction_table").on("click", ".btnKerjasama", function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('api.transaksi_session') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    data: { transaksi_id: id },
                    success: function(response) {
                        window.location.href = "{{ route('admin.kerjasama') }}";
                    }
                });
            });


            $("#transaction_table").on("click", ".btnReview", function() {
                var transaksi_id = $(this).data('id'); //id transaksi
                var url = "{{ route('admin.review', ':id') }}";
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


            // $("#transaction_table").on('click', '.btnApprove', function () {
            //     var id = $(this).data('id');
            //     var url = '';//route("admin.transaction.approve", ":id")
            //     url = url.replace(":id", id);
            //     $.ajax({
            //         url: url,
            //         method: "post",
            //         data: { id : id },
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             var error = response.errCode;
            //             var msg = response.errMsg;
            //             if(error == 0) {
            //                 transaction_table.ajax.reload();
            //             } else {
            //                 $.konveksi.showModal(msg);
            //             }
            //         }
            //     });
            //     return false;
            // });



        });
    </script>
@endsection