@extends('front.layouts.ec')
@section('title', 'Penawaran Saya')
@section('content')
    <div class="page-white page-user pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('user.offer') !!}
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
                            {{ __('Penawaran Saya') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="penawaran_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Tipe</th>
                                                <th>Harga Project</th>
                                                <th>Harga Penawaran</th>
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
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal_kerjasama" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="form_kerja_sama" class="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="konveksi-title">Form Kerjasama </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row py-3">

                            <input type="hidden" class="" value="" id="offer_id" class="offer_id" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary " id="btnSave">Save</button>
                    </div>

                </div>
            </form>

        </div>
    </div> --}}

    <div class="modal fade" id="modal_offer" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Detail </h4>
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
                                <label id="" class="form-label control-label">Harga Penawaran</label>
                                <div class="controls">
                                    <span class="label " name="offer_price" id="offer_price"></span>
                                </div>
                            </div>
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
                <input type="hidden" class="penawaran_id " name="penawaran_id" id="penawaran_id" value=""/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary " id="btnApproveModal">Approve</button>
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

            var penawaran_table = $("#penawaran_table").DataTable({
                ajax: {
                    url: "{{ route('api.penawaran_list') }}",
                    data: function ( d ){
                        d.penjahit_id = "{{ \Lintas\libraries\CMemberLogin::get('id') }}";
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
                        filename: 'Report Penawaran',
                        title: 'Report Penawaran',
                    },
                    {
                        extend: "excel",
                        className: "datatable-buttons",
                        exportOptions: {
                            orthogonal: 'exportxlsx'
                        },
                        filename: 'Report Penawaran',
                        title: 'Report Penawaran',
                    },
                ],
                'columns': [
                    { data: "project" },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var type = data.type;
                            var label = '';
                            if(type == "bid")
                                label = "badge badge-secondary";
                            else if(type == "nego")
                                label = "badge badge-primary";
                            var txt = "<span class='"+label+"'>"+ type +"</span>";
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
                            var label = '';
                            if(status == null || status == "" || status == "Pending")
                                label = "badge badge-secondary";
                            else if(status == "Cancel")
                                label = "badge badge-danger";
                            else if(status == "Confirm")
                                label = "badge badge-success";
                            var txt = "<span class='"+label+"'>"+ status +"</span>";
                            return txt;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var button = '';
                            btn_group = "<div class='btn-group btn-group-toggle ml-auto' data-toggle='buttons'>";
                            btn_group += "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action</button>";
                                act_group = "<div class='dropdown-menu'>";
                                    // if(data.status_confirm == "Confirm") {
                                    //     act_group += "<a class='dropdown-item btnFormKerjasama' href='javascript:void(0)'" + "data-id="+data.id+">Form Kerja Sama</a>";
                                    // }
                                    act_group += "<a class='dropdown-item btnDetail' href='javascript:void(0)'" + "data-id="+data.id+">Detail</a>";
                                act_group += "</div>";
                            btn_group += act_group;
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    }

                ]
            });


            $("#penawaran_table").on('click', '.btnDetail', function () {
                var id = $(this).data('id');
                var url = '{{ route("api.penawaran_get_data") }}';
                //url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        penawaran_id : id
                    },
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
                            var id = data.id;
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
                            var ikm_name = data.ikm_name;
                            var display = (data.is_approve_ikm == 1 ? "block" : "none");
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
                            $("#offer_price").html(offer_price);
                            $("#offer_price_system").html(offer_price_system);
                            $("#note").html(note);
                            $("#ikm_name").html(ikm_name);
                            $("#penawaran_id").val(id);
                            $("#btnApproveModal").css("display", display);
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
            $("#btnApproveModal").on("click", function() {
                var penawaran_id = $("#penawaran_id").val();
                var url = '{{ route("api.penawaran_approve") }}';
                //url = url.replace(":id", id);

                swal({
                    title: "Apakah kamu yakin konfirmasi penawaran ini?",
                    text: "Konfirmasi penawaran tidak dapat dibatalkan.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: url,
                            data: {
                                penawaran_id: penawaran_id,
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
                                    penawaran_table.ajax.reload();
                                    $("#modal_offer").modal('hide');
                                } else {
                                    $.konveksi.showModal(msg);
                                }
                            }
                        });
                    }
                });
                return false;
            })


            // $("#penawaran_table").on('click', '.btnFormKerjasama', function () {
            //     var id = $(this).data('id');
            //     $("#offer_id").val(id);
            //     $("#modal_kerjasama").modal('show');
            // })
            // $("#btnSave").click(function() {
            //     $.ajax({
            //         url: "",
            //         data: $("#form_kerja_sama").serialize(),
            //         method: "POST",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         success: function(response) {

            //         }
            //     });
            // });




        });
    </script>
@endsection