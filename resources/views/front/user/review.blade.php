@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-md-6 text-center d-flex aligns-items-center">
             <img class="img-responsive" src="{{ asset('public/img/review.png') }}" style="width:250px">
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form id="form_review" enctype="multipart/form-data">
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Invoice</label>
                            <div class="controls">
                                <span class="label " name="invoice" id="invoice">{{ $invoice }}</span>
                            </div>
                            <input type="hidden" value="{{ $invoice_id }}" id="invoice_id" name="invoice_id"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Kode Transaksi</label>
                            <div class="controls">
                                <span class="label " name="kode_transaksi" id="kode_transaksi">{{ $transaction_code }}</span>
                            </div>
                            <input type="hidden" value="{{ $transaction_id }}" id="transaction_id" name="transaction_id"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Ikm</label>
                            <div class="controls">
                                <span class="label " name="ikm_name" id="ikm_name">{{ $ikm_name }}</span>
                            </div>
                            <input type="hidden" value="{{ $ikm_id }}" id="ikm_id" name="ikm_id"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Project</label>
                            <div class="controls">
                                <span class="label " name="project" id="project">{{ $project_name }}</span>
                            </div>
                            <input type="hidden" value="{{ $project_id }}" id="project_id" name="project_id"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Note</label>
                            <div class="controls">
                                <textarea class="form-control summernote "
                                    placeholder="Note.." id="note" tabindex="9"
                                    name="note">{{ old('note') }}</textarea>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Rating</label>
                            <div class="controls">
                                <div class='rating-stars text-center'>
                                    <ul id='stars'>
                                        <li class='star' title='Poor' data-value='1'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Fair' data-value='2'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Good' data-value='3'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Excellent' data-value='4'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='WOW!!!' data-value='5'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" value="" id="rating_value" name="rating_value"/>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="button" class="btn btn-primary lnj-color btnSubmit">
                                Submit Review
                            </button>
                            {{-- <a id="" href="{{ route('admin.checkout.address') }}" class="btn btn-secondary">
                                Revisi
                            </a> --}}
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#stars li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10);
                $(this).parent().children('li.star').each(function(e){
                  if (e < onStar) {
                    $(this).addClass('hover');
                  } else {
                    $(this).removeClass('hover');
                  }
                });
              }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                  $(this).removeClass('hover');
                });
              });

              $('#stars li').on('click', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');
                for (i = 0; i < stars.length; i++) {
                  $(stars[i]).removeClass('selected');
                }
                for (i = 0; i < onStar; i++) {
                  $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                $("#rating_value").val(ratingValue);
            });



            $(".btnSubmit").click(function() {
                var url = "{{ route('api.review_insert') }}";
                $.ajax({
                    url: url,
                    method: "post",
                    data: $("#form_review").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            // var data = response.data;
                            $.konveksi.showModal("Success insert on review");
                            setTimeout(function() {
                                $("#note").val();
                                window.location.href="{{ route('home') }}";
                            }, 200);
                        }
                    },
                    error: function(err, errThrown, textStatus) {
                        $.konveksi.showModal(errThrown);
                    }
                });
            })

        });
    </script>
@endsection