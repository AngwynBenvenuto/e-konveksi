<?php
    use Lintas\libraries\CUserLogin;
    $id = CUserLogin::get('id');
    $code = CUserLogin::get('code');
    $name = CUserLogin::get('name');
    $name_display = CUserLogin::get('name_display');
    $image = CUserLogin::get('image_url');
    $userName = $name_display." [".$name."]";
?>
@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.dashboard') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="col-md-4">
                <div class="input-field mt-4">
                    <label class="active" for="project"><?php echo __('Project'); ?></label>
                    <select id="project" name="project" class="form-control select2" >
                        <option value="" disabled selected><?php echo __('Choose Project'); ?></option>
                        <?php
                            foreach ($project as $k => $v) :
                                $selected = '';
                                if (Arr::get($v, 'id') == $project_id) {
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
    </div>
    <div id="chat-realtime">
        <div class="row app-one">
            <div class="col-sm-4 side">
                <div class="side-one">
                    <div class="row heading">
                        <div class="col-sm-2 col-xs-2 heading-avatar">
                            <div class="heading-avatar-icon">
                                <img class="me" src="{{ $image }}"
                                    onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                            </div>
                        </div>
                    </div>
                    <div class="row searchBox" style="display:none">

                    </div>
                    <div class="row sideBar"></div>
                </div>
            </div>
            <div class="col-md-8 conversation" style="display:none">
                <div class="row heading">
                    <div class="col-sm-1 col-md-1 col-xs-3 heading-avatar">
                        <div class="heading-avatar-icon">
                            <img class="you" src="">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-4 heading-name">
                        <p id="heading-name-meta"></p>
                        <span id="heading-online"></span>
                    </div>
                </div>
                <div class="row message-admin" id="conversation">
                    <p class="messages">
                    </p>
                </div>
                <div class="row imagetmp" style="display: none;">
                    <div id="reviewImg"></div>
                </div>
                <div class="row reply">
                    <div class="col-sm-1 col-xs-1 reply-recording" align="center" style="display:none"></div>
                    <div class="col-sm-11 col-xs-11 reply-main">
                        <textarea class="form-control" rows="1" id="comment"
                            data-id="45de3556-f631-4741-b005-e8cae61d90f5"
                            data-type="original-input"></textarea>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-send" id="send">
                        <i class="fas fa-paper-plane fa-2x pull-right" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            //getProject();
            //getListChat();
            reloadChatList();

            document.getElementById("send").addEventListener("click", () => {
                // const a = new Date();
                // const b = a.getDate();
                // const c = (a.getMonth() + 1);
                // const d = a.getFullYear();
                // const e = a.getHours();
                // const f = a.getMinutes();
                // const g = a.getSeconds();
                // var receiver = $(".side-one .sideBar-body").data('receiver_id');
                //var sender = "";//$id
                //var project = $(".side-one .sideBar-body").data('project');
                //const date = `${d}-${c < 10 ? `0${c}` : c}-${b < 10 ? `0${b}` : b} ${e < 10 ? `0${e}` : e}:${f < 10 ? `0${f}` : f}:${g < 10 ? `0${g}` : g}`;
                var project = $('.side-one .sideBar-body').closest(".active").data('project');
                var penjahit_id = $('.side-one .sideBar-body').closest('.active').data('penjahit_id');
                var penjahit_code = $('.side-one .sideBar-body').closest('.active').data('penjahit_code');
                if (document.getElementById('comment').value != '') {
                    var url = "{{ route('api.chat.send') }}";//
                    var data = {
                        project_id: project,
                        message: document.getElementById('comment').value,
                        receiver: penjahit_id,
                        receiver_unique: penjahit_code,
                        sender: "{{ $id }}",
                        sender_unique: "{{ $code }}"
                    };
                    requestAjax(url, "POST", data, res => {
                        reloadChatByPenjahit(project, penjahit_id);
                        //$(".sideBar-message-content").html(document.getElementById('comment').value);
                        document.getElementById('comment').value = "";
                        scrollBottom();
                    });
                } else {
                    alert('Please input a message.');
                }
            });

           $('body').on('click', '.side-one .sideBar-body', function() {
                // const a = $(this).data('id');
                // const b = $(this).data('name');
                // const receiver = $(this).data('receiver_id');
                // const sender = ""; $id
                // const project = $(this).data('project');
                // const av = $(this).data('avatar');
                // const st = $(this).data('status');
                var project = $(this).data('project');
                var penjahit_id = $(this).data('penjahit_id');
                var name = $(this).data('penjahit_name');
                var image = $(this).data('image');
                $('.side-one .sideBar-body').removeClass("active");
                $('.conversation').css({'display':'block'});
                $(this).addClass("active");
                headingHTML(name, image, status);
                reloadChatByPenjahit(project, penjahit_id);

           });
        });

        function reloadChatList() {
            $("#project").on("change", function() {
                var value = $("#project option:selected").val();
                var url = "{{ route('api.chat.chatbox') }}";
                var data = {
                    project_id: value
                };
                requestAjax(url, "POST", data, res => {
                    $('.side-one .sideBar').empty();
                    $('#conversation .messages').empty();

                    var error = res.errCode;
                    var msg = res.errMsg;
                    if(error == 0) {
                        var data = res.data;
                        if (data.length > 0) {
                            data.forEach(a => {
                                sideOneHTML(a);
                            });
                        }
                        //console.log(res.data);
                    }
                });
            });
        }
        function reloadChatByPenjahit(project, penjahit_id) {
            var url = "{{ route('api.chat.penjahit') }}";
            var data = {
                project_id: project,
                penjahit_id: penjahit_id,
            };
            requestAjax(url, "POST", data, res => {
                //$("p.messages").empty();
                //$('.side-one .sideBar').empty();
                $('#conversation .messages').empty();

                var error = res.errCode;
                var msg = res.errMsg;
                if(error == 0) {
                    var data_chat = res.data;
                    if(data_chat.length > 0) {
                        data_chat.forEach(a => {
                            messageHTML(a, false);
                        })
                    }
                }
            });
            return false
        }

        //function reloadChat(c, receiver, sender) {
            // var url = "";
            // var data = {
            //     project_id: c,
            //     receiver: receiver,
            //     sender: sender,
            // };
        //     requestAjax(url, "POST", data, res => {
        //         $('p.messages').empty();
        //         var error = res.errCode;
        //         var msg = res.errMsg;
        //         if(error == 0) {
        //             var data_chat = res.data;
        //             if(data_chat.length > 0) {
        //                 data_chat.forEach(a => {
        //                     messageHTML(a, null, ""); $id
        //                 })
        //             }
        //         }
        //     });
        //     return false
        // }

        // function getListChat() {
        //     var url = "";
        //     var data = {
        //         id: "",
        //     };
        //     requestAjax(url, "POST", data, res => {
        //         var error = res.errCode;
        //         var msg = res.errMsg;
        //         if(error == 0) {
        //             var data = res.data;
        //             if (data.length > 0) {
        //                 data.forEach(a => {
        //                     sideOneHTML(a);
        //                 });
        //             }
        //         }
        //     });
        // }

        function headingHTML(name, image, status) {
            document.getElementsByClassName('you')[0].src = image || '{{ asset('public/img/no_image.png') }}';
            document.getElementById('heading-name-meta').innerHTML = name;
        }

        function messageHTML(a, bottom = false) {
            let image = '';
            let b = "";
            let user_id = "{{ $id }}";
            let user_code = "{{ $code }}";
            if (a.sender == user_id && a.sender_unique == user_code) {
                b += '<div class="row message-body">';
                b += '  <div class="col-sm-12 message-main-sender">';
                    b += '	<div class="sender">';
                    b += `      <div class="message-text">${image != '' ? `<a title="Zoom" href="${image}" class="placeholder"><img class="imageDir" src="${image}"/></a>` : ''}${urltag(htmlEntities(a.message))}</div>`;
                    b += `      <span class="message-time pull-right">${a.time}</span>`;
                    b += '	</div>';
                b += '  </div>';
                b += '</div>';
            } else {
                b += '<div class="row message-body">';
                b += '  <div class="col-sm-12 message-main-receiver">';
                    b += '	<div class="receiver">';
                    b += `      <div class="message-text">${image != '' ? `<a title="Zoom" href="${image}" class="placeholder"><img class="imageDir" src="${image}"/></a>` : ''}${urltag(htmlEntities(a.message))}</div>`;
                    b += `      <span class="message-time pull-right">${a.time}</span>`;
                    b += '	</div>';
                b += '  </div>';
                b += '</div>';
            }
            if (bottom == false) {
                $('#conversation .messages').append(b);
            } else {
                $('#conversation .messages').prepend(b);
            }
        }

        function sideOneHTML(a) {
            let b = "";
            b += `<div class="row sideBar-body" data-penjahit_id="${a.penjahit_id}" data-penjahit_code="${a.penjahit_code}" data-penjahit_name="${a.penjahit_name}" data-image="${a.penjahit_image}" data-project="${a.project_id}">`;
            b += '	<div class="col-sm-3 col-xs-3 sideBar-avatar">';
            b += '  	<div class="avatar-icon">';
            b += `            <span class="contact-status"></span>`;
            b += `            <img src="${a.penjahit_image || '{{ asset('public/img/no_image.png') }}'}" >`;
            b += '  	</div>';
            b += '	</div>';
            b += '	<div class="col-sm-9 col-xs-9 sideBar-main">';
            b += '  	<div class="row">';
            b += '			<div class="col-sm-8 col-xs-8 sideBar-name">';
            b += `                <span class="name-meta">${a.penjahit_name}</span>`;
            b += '			</div>';
            b += '			<div class="col-sm-4 col-xs-4 pull-right sideBar-time">';
            //b += `                <span class="time-meta pull-right">${a.time}</span>`;
            b += '			</div>';
            b += '			<div class="col-sm-12 sideBar-message">';
            //b +=                '<div class="sideBar-message-content"></div>';
            // if (a.selektor != undefined) {
            //     if (a.selektor == "to") {
            //         b += `<i class="fa fa-check"></i> ${a.message}`;
            //     }
            // } else {
            //     b += `${a.message}`;
            // }
            b += '  		</div>';
            b += '  	</div>';
            b += '	</div>';
            b += '</div>';
            $('.side-one .sideBar').prepend(b);
        }

        //
        function scrollBottom() {
            setTimeout(() => {
                const container = $('#conversation');
                const scroll_top = container[0].scrollHeight;
                container.animate({ scrollTop: scroll_top }, 500);
                $("body .message-scroll").hide();
                $("body .message-previous").hide();
            }, 1000);
        }

        function htmlEntities(a) {
            return String(a).replace(/</g, '&lt;').replace(/>/g, '&gt;')
        }

        function urltag(d, e) {
            const f = {
                youtube: {
                    regex: /(^|)(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*)(\s+|$)/ig,
                    template: "<iframe class='yutub' src='//www.youtube.com/embed/$3' frameborder='0' allowfullscreen></iframe>"
                },
                link: {
                    regex: /((^|)(https|http|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,
                    template: "<a href='$1' target='_BLANK'>$1</a>"
                },
                email: {
                    regex: /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi,
                    template: '<a href=\"mailto:$1\">$1</a>'
                }
            };
            const g = $.extend(f, e);
            $.each(g, (a, {regex, template}) => {
                d = d.replace(regex, template)
            });
            return d;
        }

        function requestAjax(url, method, data, callback) {
            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(response) {
                    callback(response);
                }
            });
        }



    </script>
@endsection