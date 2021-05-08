@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
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
        </div>

        <div class="col-lg-12">
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
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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
            var table = $("#penawaran_table").DataTable({
                ajax: {
                    url: "{{ route('api.penawaran_list') }}",
                    data: function ( d ){
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

                ]
            });



        });
    </script>
@endsection