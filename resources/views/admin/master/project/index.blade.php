@extends('admin.layouts.ec')
@section('title', 'Project')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary btnAdd lnj-color mb-2">Tambah</button>
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List Project </h5>
                </div>
                <div class="ibox-content">
                    <table id="project_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Project</th>
                                <th>Kode</th>
                                <th>Harga</th>
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
            Number.prototype.format = function (n, x, s, c) {
                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                        num = this.toFixed(Math.max(0, ~~n));
                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
            };

            var table = $("#project_table").DataTable({
                ajax: "{{ route('admin.master.project.show') }}",
                columns: [
                    { "data": "name" },
                    { "data": "code" },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            return "{{ config('cart.currency') }}" + " " + Number(data.price).format(2, 3);
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
                'order': [[0, 'asc']],
            });

            
            //
            $(".btnAdd").click(function() {
                window.location.href = "{{ route('admin.master.project.create') }}";
            });

            //
            $("#project_table").on('click', '.btnEdit', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.master.project.edit", ":id") }}';
                url = url.replace(":id", id);
                window.location.href = url;
            });

        });
    </script>
@endsection