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
                    <form id="form_search_horizontal" class="form-horizontal">
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
                        <table id="penawaran_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Pembuat</th>
                                    <th>Tipe</th>
                                    <th>Harga Project</th>
                                    <th>Harga Penawaran</th>
                                    <th>Dibuat</th>
                                    <th>Diubah</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_offer" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Detail </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form_detail" class="">
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
                                    <label id="" class="form-label control-label">Harga Penawaran</label>
                                    <div class="controls">
                                        <span class="label " name="offer_price" id="offer_price"></span>
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
                    </form>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_confirmation" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Are You Sure? </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form_confirmation" class="">
                        <div class="row">
                            <div class="col-md-12 text-center">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <a class="btn btn-primary btn-chat text-center text-white">Chat</a>
                            </div>
                            <div class="col-md-6 text-center">
                                <a class="btn btn-secondary btn-cancel text-center text-white">Cancel</a>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="" id="cancelId"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_chat" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Chat </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form_chat" class="">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Ke</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="To.." id="to" autocomplete="off" readonly
                                        name="to" value="{{ old('to', '') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Dari</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="Dari.." id="from" autocomplete="off" readonly
                                        name="from" value="{{ old('from', '') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Message</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" style="position:relative">
                                    <textarea class="form-control" style="height:50px"
                                        placeholder="Message.." id="message" autocomplete="off"
                                        name="message">{{ old('message', '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="to_id" value="" id="to_id"/>
                        <input type="hidden" name="to_id_unique" value="" id="to_id_unique"/>
                        <input type="hidden" name="from_id" value="" id="from_id"/>
                        <input type="hidden" name="from_id_unique" value="" id="from_id_unique"/>
                        <input type="hidden" name="project_id" value="" id="project_id"/>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="button" href="javascript:;" class="btn btn-primary lnj-color btnSubmitChat">
                                Send
                            </button>
                        </div>
                    </form>
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

            //
            var ikm_id = "{{ \Lintas\libraries\CUserLogin::get('id') }}";
            var table = $("#penawaran_table").DataTable({
                ajax: {
                    url: "{{ route('api.penawaran_list') }}",
                    data: function ( d ){
                        d.ikm_id = ikm_id;
                    },
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
                        filename: 'Admin | Report Penawaran',
                        title: 'Admin | Report Penawaran',
                    },
                    {
                        extend: "excel",
                        className: "datatable-buttons",
                        exportOptions: {
                            orthogonal: 'exportxlsx'
                        },
                        filename: 'Admin | Report Penawaran',
                        title: 'Admin | Report Penawaran',
                    },
                ],
                'columns': [
                    { data: "project" },
                    { data: "project_creator" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var label = data.type == "nego" ? "badge badge-secondary" : "badge badge-primary";
                            var txt = "<span class='"+label+"'>"+ data.type +"</span>";
                            return txt;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return "{{ config('cart.currency') }}" + " " + (Number(data.price).format(2, 3));
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return "{{ config('cart.currency') }}" + " " + (Number(data.offer_price).format(2, 3));
                        }
                    },
                    { data: "created_at" },
                    { data: "updated_at" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var status = data.status_confirm;
                            var label = status == "Confirm" ? "badge badge-success" : status == "Cancel" ? "badge badge-danger" : "badge badge-secondary";
                            var txt = "<span class='"+label+"'>"+ status +"</span>";
                            return txt;
                        }
                    },
                    {
                        "data": null,
                        render: function(data, type, row) {
                            var is_approve_penjahit = data.is_approve_penjahit;
                            var is_approve_ikm = data.is_approve_ikm;
                            var status = data.status_confirm;

                            var button = '';
                            btn_group = "<div class='btn-group btn-group-toggle ml-auto' data-toggle='buttons'>";
                            btn_group += "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action</button>";
                                act_group = "<div class='dropdown-menu'>";
                                    act_group += "<a class='dropdown-item btnDetail' href='javascript:void(0)'" + "data-id="+data.id+">Detail</a>";
                                    if(status == "Pending" && is_approve_ikm == "0") {
                                        act_group += "<a class='dropdown-item btnApprove' href='javascript:void(0)'" + "data-id="+data.id+">Approve</a>";
                                        act_group += "<a class='dropdown-item btnCancel' href='javascript:void(0)'" + "data-id="+data.id+">Cancel</a>";
                                    }
                                    //else {
                                        //act_group += "<a class='dropdown-item btnCheckout' href='javascript:void(0)'" + "data-id="+data.id+">Checkout</a>";
                                    //}
                                act_group += "</div>";
                            btn_group += act_group;
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    }
                ]
            });


            //approve
            $("#penawaran_table").on('click', '.btnApprove', function () {
                var id = $(this).data('id');
                var url = '{{ route("api.penawaran_approve") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        penawaran_id : id,
                        ikm_id: "{{ \Lintas\libraries\CUserLogin::get('id') }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            table.ajax.reload();
                        } else {
                            $.konveksi.showModal(msg);
                        }

                    }
                });
                return false;
            });


            //cancel
            $("#penawaran_table").on('click', '.btnCancel', function () {
                var id = $(this).data('id');
                $("#cancelId").val(id);
                $("#modal_confirmation").modal('show');
            });
            $(".btn-chat").click(function() {
                $("#modal_confirmation").modal('hide');
                var id = $("#cancelId").val();
                var url = '{{ route("api.penawaran_get_data") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: { penawaran_id : id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.errCode == 0) {
                            $("#to").val(response.data.penjahit_name);
                            $("#to_id").val(response.data.penjahit_id);
                            $("#to_id_unique").val(response.data.penjahit_code);
                            $("#from").val(response.data.ikm_name);
                            $("#from_id").val(response.data.ikm_id);
                            $("#from_id_unique").val(response.data.ikm_code);
                            $("#project_id").val(response.data.project_id);
                            $("#modal_chat").modal('show');
                        } else {
                            $.konveksi.showModal(response.errMsg);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
                //next do send
            });
            $(".btnSubmitChat").click(function() {
                $.ajax({
                    url: "{{ route('api.chat.send') }}",
                    method: "post",
                    data: {
                        project_id: $("#project_id").val(),
                        message: $("#message").val(),
                        receiver: $("#to_id").val(),
                        receiver_unique: $("#to_id_unique").val(),
                        sender: $("#from_id").val(),
                        sender_unique: $("#from_id_unique").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.errCode == 0) {
                            $("#modal_chat").modal('hide');
                        } else {
                            $.konveksi.showModal(response.errMsg);
                        }
                    },
                     error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            });
            $(".btn-cancel").click(function() {
                $("#modal_confirmation").modal('hide');
                var id = $("#cancelId").val();
                var url = '{{ route("api.penawaran_cancel") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        penawaran_id : id,
                        ikm_id: "{{ \Lintas\libraries\CUserLogin::get('id') }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            table.ajax.reload();
                        } else {
                            $.konveksi.showModal(msg);
                        }

                    }
                });
            });



            //detail
            $("#penawaran_table").on('click', '.btnDetail', function () {
                var id = $(this).data('id');
                var url = '{{ route("api.penawaran_get_data") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: { penawaran_id : id },
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
                            var price = data.project_price;
                            var offer_price = data.offer_price;
                            var offer_price_system = data.offer_price_system;
                            var note = data.note;
                            var penjahit_name = data.penjahit_name;
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
                            $("#offer_price").html(offer_price);
                            $("#offer_price_system").html(offer_price_system);
                            $("#note").html(note);
                            $("#modal_offer").modal('show');
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            });

            // $("#penawaran_table").on('click', '.btnCheckout', function () {
            //     var id = $(this).data('id');
            //     var url = '';//route("admin.checkout.address", ":id")
            //     url = url.replace(":id", id);
            //     window.location.href = url;
            // });

        });
    </script>
@endsection