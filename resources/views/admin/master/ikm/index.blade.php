@extends('admin.layouts.ec')
@section('title', 'IKM')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <button class="btn btn-primary btnAdd lnj-color mb-2">Tambah</button>
                <div class="ibox-title">
                    <h5>List Ikm </h5>
                </div>
                <div class="ibox-content">
                    <table id="ikm_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Tanggal Lahir</th>
                                <th>Dibuat pada</th>
                                <th>Terakhir diubah</th>
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
    <div class="modal fade" id="modal_ikm" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Detail </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nama</label>
                                    <div class="controls">
                                        <span class="label " name="name" id="name"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nama Display</label>
                                    <div class="controls">
                                        <span class="label " name="name_display" id="name_display"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kode</label>
                                    <div class="controls">
                                        <span class="label " name="code" id="code"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Provinsi</label>
                                    <div class="controls">
                                        <span class="label " name="province" id="province"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kota</label>
                                    <div class="controls">
                                        <span class="label " name="city" id="city"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Alamat</label>
                                    <div class="controls">
                                        <span class="label " name="alamat" id="alamat"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Telepon</label>
                                    <div class="controls">
                                        <span class="label " name="phone" id="phone"></span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Jenis Kelamin</label>
                                    <div class="controls">
                                        <span class="label " name="gender" id="gender"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="img_ikm_div"
                                    style="background-repeat:no-repeat;background-size:100%;background-position:center;border:1px solid gray;margin:0px auto 10px auto;width:200px;height:200px;">
                                    <img src="" style="width:100%;height:100%;" id="img_ikm" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Created</label>
                                    <div class="controls">
                                        <span class="label " name="created" id="created"></span>
                                     </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Updated</label>
                                    <div class="controls">
                                        <span class="label " name="updated" id="updated"></span>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $("#ikm_table").DataTable({
                ajax: "{{ route('admin.master.ikm.list') }}",
                columns: [
                    { "data": "name" },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            return data.email || '-';
                        } 
                    },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            return data.address || '-';
                        } 
                    },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            return data.birthdate || '-';
                        } 
                    },
                    { "data": "created_at" },
                    { "data": "updated_at" },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            return data.status == "1" ? "Active" : "Nonactive";
                        } 
                    },
                    { 
                        "data": null,
                        render: function(data, type, row) {
                            var button = '';
                            btn_group = "<div class='btn-group btn-group-toggle ml-auto' data-toggle='buttons'>";
                            btn_group += "<button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action</button>";
                                act_group = "<div class='dropdown-menu'>";
                                    act_group += "<a class='dropdown-item btnDetail' href='javascript:void(0)'" + "data-id="+data.id+">Detail</a>";
                                    act_group += "<a class='dropdown-item btnEdit' href='javascript:void(0)'" + "data-id="+data.id+">Edit</a>";
                                    act_group += "<a class='dropdown-item btnDelete' href='javascript:void(0)'" + "data-id="+data.id+">Delete</a>";
                                act_group += "</div>";
                            btn_group += act_group;  
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    },
                ],
                responsive: true,
                'order': [[0, 'asc']]
            });

            $(".btnAdd").click(function() {
                window.location.href = "{{ route('admin.master.ikm.create') }}";
            });

            $("#ikm_table").on('click', '.btnEdit', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.master.ikm.edit", ":id") }}';
                url = url.replace(":id", id);
                window.location.href = url;
            });

            $("#ikm_table").on('click', '.btnDelete', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.master.ikm.delete", ":id") }}';
                url = url.replace(":id", id);
                window.location.href = url;
            });

            $("#ikm_table").on('click', '.btnDetail', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.master.ikm.show", ":id") }}';
                url = url.replace(":id", id);
                $.ajax({
                    url: url,
                    method: "post",
                    data: { id : id },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            var data = response.data;
                            var name = data.name;
                            var name_display = data.name_display;
                            var image_url = data.image_url;
                            var code = data.code;
                            var gender = data.gender;
                            var qr_code = data.qr_code;
                            var phone = data.phone;
                            var province = (data.province == "" ? '-' : data.province);
                            var city = (data.city == "" ? '-' : data.city);
                            var district = (data.district == "" ? '-' : data.district);
                            var alamat = (data.address == "" ? '-' : data.address);
                            var created = data.created_at;
                            var updated = data.updated_at;
                            $("#name").html(name);
                            $("#name_display").html(name_display);
                            $("#code").html(code);
                            $("#img_ikm").attr('src', image_url);
                            $("#gender").html(gender);
                            $("#qr_code").css('background-image', 'url('+qr_code+')');
                            $("#province").html(province);
                            $("#city").html(city);
                            $("#phone").html(phone);
                            //$("#district").html(district);
                            $("#alamat").html(alamat);
                            $("#created").html(created);
                            $("#updated").html(updated);
                            $("#modal_ikm").modal('show');
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    }, 
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }

                });
            });



        });
    </script>
@endsection