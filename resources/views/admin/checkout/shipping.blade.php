<?php
    // foreach($billing as $row):
    //     foreach($row as $key => $value):

    //     endforeach;
    // endforeach;
?>
@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="container">
            @include('admin/checkout/nav/wizard')
        </div>
        <div class="container">
            <form id="form_shipping" method="post" action="">
                @csrf

                <div class="row">

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="barang"><?php echo __('Barang'); ?></label>
                                        <select id="barang" name="barang[]" class='form-control select2-multiple' multiple="multiple">
                                            <?php
                                                foreach ($barang as $k => $v):
                                                    $selected = '';
                                                    // if (Arr::get($v, 'id') == $kurir_txt) {
                                                    //     $selected = ' selected="selected"';
                                                    // }
                                            ?>
                                                <option value="<?php echo Arr::get($v, 'name'); ?>" <?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="kurir"><?php echo __('Kurir'); ?></label>
                                        <select id="kurir_id" name="kurir_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Pilih kurir'); ?></option>
                                            <?php
                                                foreach ($kurir as $k => $v):
                                                    $selected = '';
                                                    if (Str::lower(Arr::get($v, 'name')) == $kurir_txt) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                <option value="<?php echo Str::lower(Arr::get($v, 'name')); ?>" <?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="bank"><?php echo __('Bank'); ?></label>
                                        <select id="bank_id" name="bank_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Pilih bank'); ?></option>
                                            <?php
                                                foreach ($bank as $k => $v):
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $bank_id_txt) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                <option value="<?php echo Arr::get($v, 'id'); ?>" <?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="metode_pembayaran"><?php echo __('Metode Pembayaran'); ?></label>
                                        <div class="form-control-static">
                                            <label>{{ __('Transfer') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="ongkos"><?php echo __('Ongkos Kirim'); ?></label>
                                        <div class="form-control-static">
                                            <div class="ongkos">
                                                <div class="des" id="des" style="margin-bottom:5px"></div>
                                                <div class="mb-3" id="info"></div>
                                                <select name="postchoose" id="postchoose" class="form-control custom-control">
                                                    <option class="" value="">Pilih Jenis Service</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php echo \Lintas\libraries\CBlocks::render('view-setting'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="total"><?php echo __('Subtotal'); ?></label>
                                        <div class="form-control-static">
                                            <div class="subtotal" id="subtotal"></div>
                                            <input type="hidden" name="subtotal"
                                                id="subtotal" class="subtotal" value="{{ $harga }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="input-field mt-4">
                                    <div class="form-group">
                                        <label class="active" for="total"><?php echo __('Total'); ?></label>
                                        <div class="form-control-static">
                                            <div class="total_txt" id="total_txt"></div>
                                            <input type="hidden" name="total"
                                                id="total" class="total" value="" />

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                <input type="submit" class="shipping-continue border-0 w-100 text-white py-3 btn btn-primary mb-3" value="<?php echo __('Lanjut ke konfirmasi pembayaran'); ?>" />
            </form>
        </div>
    </div>
    <script>
        Number.prototype.format = function (n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                    num = this.toFixed(Math.max(0, ~~n));
            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        };

        $(document).ready(function() {
            var harga = "{{ $harga }}";
            var harga_label = "{{ config('cart.currency') }} "+ (Number(harga).format(2, 3));
            $("#subtotal").html(harga_label);
            $("#kurir_id").on('change', function() {
                var courier = $(this).find(":selected").val();
                ajaxRequest(courier);
            });
            $("#postchoose").on('change', function() {
                var subtotal = "{{ $harga }}";
                var ongkos_kirim = $(this).find(":selected").val(); //dpt harga
                var total = (parseInt(subtotal) + parseInt(ongkos_kirim));
                var total_label = "{{ config('cart.currency') }} "+ (Number(total).format(2, 3));
                $("#total_txt").html(total_label);
                $("#total").val(total);
            });

            //select barang
            var barang = "{{ $barang_txt }}";
            if(barang != null) {
                var values = new Array();
                var ses_arr = barang.split(",");
                for(var i = 0; i < ses_arr.length; i++) {
                    values.push(ses_arr[i]);
                }
                $("#barang").val(values).trigger('change');
            }

            //selected dropdown
            var kurir = $("#kurir_id option:selected").val();
            if(kurir) {
                ajaxRequest(kurir);
            }
        })

        function ajaxRequest(courier = null) {
            var weight = 1;
            var origin = "{{ $origin }}";//get from step 1
            var destination = "{{ $destination }}"; //get from step 1 {{ $destination }}

            //post
            $.ajax({
                url: "{{ route('api.cost') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'origin': origin,
                    'destination': destination,
                    'weight': weight,
                    'courier': courier
                },
                dataType: "json",
                success: function(response) {
                    var error = response.errCode;
                    var message = response.errMsg;
                    if(error == 0) {
                        $.each(response.data, function(i, val) {
                            $('#des').html(
                                '<p style="margin:0;padding:0"><b>Destination</b>: ' + val.meta.destination.province + ' , ' + val.meta.destination.type + ' , ' + val.meta.destination.city_name + ' , ' + val.meta.destination.postal_code +'</p>'
                            );

                            //
                            $('select[name="postchoose"]').empty();
                            $('select[name="postchoose"]').append('<option class="form-control" value="">Pilih jenis service</option>');

                            $('#info').html('<h5 style="margin:0;padding:0">'+ val.code + ' - <small>' + val.name +'</small></h5>');
                            $.each(val.costs, function(key2, value2) {
                                $.each(value2.cost, function(key3, value3) {
                                    $('select[name="postchoose"]').append('<option class="form-control" value="'+ value3.value +'">'+ value2.service + ' - ' + value3.value + ' - ' + value3.etd +'</option>');
                                });
                            });
                        });
                    } else {
                        $.konveksi.showModal(message);
                    }
                },
                error: function(errCode, errThrown, textStatus) {
                    $.konveksi.showModal(textStatus);
                }
            })
        }

    </script>
@endsection