@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.setting.user') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_user" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">
                                <label>IKM</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <select id="ikm_id" name="ikm_id" class="form-control select2" >
                                        <option value="" disabled selected><?php echo __('Choose IKM'); ?></option>
                                        <?php
                                            foreach ($ikm as $k => $v) :
                                                $selected = '';
                                                if (Arr::get($v, 'id') == $ikm_id) {
                                                    $selected = ' selected="selected"';
                                                }
                                        ?>
                                            <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Username</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control "
                                        placeholder="Username.." id="username" autocomplete="off"
                                        name="username" value="{{ old('username', $username) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Email</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="email" class="form-control "
                                        placeholder="Email.." id="email" autocomplete="off"
                                        name="email" value="{{ old('email', $email) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Password</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="password" class="form-control "
                                        placeholder="Password.." id="password" autocomplete="off"
                                        name="password" value="{{ old('password', $password) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Information</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" id="note" style="position:relative;height:100px"
                                        name="note">{{ old('note', $note) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="submit" href="javascript:;" class="btn btn-primary lnj-color btnSubmit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".btnBack").click(function() {
                window.history.go(-1);
            });


        });

    </script>

@endsection