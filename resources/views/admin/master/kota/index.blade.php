@extends('admin.layouts.ec')
@section('title', 'Kota')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary btnAdd lnj-color mb-2">Tambah</button>
            {{-- <button class="btn btn-primary btnGenerate lnj-color mb-2">Generate</button> --}}
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List Kota </h5>
                </div>
                <div class="ibox-content">
                    <table id="kota_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Provinsi</th>
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
    <script>
        $(document).ready(function() {
            var table = $("#kota_table").DataTable({
                ajax: "{{ route('admin.master.kota.show') }}",
                columns: [
                    { "data": "name" },
                    { "data": "province" },
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
                                    act_group += "<a class='dropdown-item btnEdit' href='javascript:void(0)'" + "data-id="+data.id+">Edit</a>";
                                act_group += "</div>";
                            btn_group += act_group;
                            btn_group += "</div>";
                            button += btn_group;
                            return button;
                        }
                    },
                ],
                responsive: true,
                processing: true,
                'order': [[0, 'asc']],
            });

            $(".btnAdd").click(function() {
                window.location.href = "{{ route('admin.master.kota.create') }}";
            });

            // $(".btnGenerate").click(function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         url: "",
            //         data: {},
            //         success: function() {
            //             table.ajax.reload();
            //         }
            //     })
            //     return false;
            // });

            $("#kota_table").on('click', '.btnEdit', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.master.kota.edit", ":id") }}';
                url = url.replace(":id", id);
                window.location.href = url;
            });



        });

    </script>
@endsection