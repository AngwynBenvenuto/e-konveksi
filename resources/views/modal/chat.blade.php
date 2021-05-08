<?php
    use \Lintas\libraries\CMemberLogin;

    $owner = "";
    $owner_code = "";
    $owner_username = "";
    $owner_image = "";
    $project_id = "";
    $penjahit_id = CMemberLogin::get('id');
    $penjahit_code = CMemberLogin::get('code');
?>
<div class="avenue-messenger hidden">
    <div class="menu">
        <div class="items">
            <div class="button btn-closed closed">
                <i class="fas fa-times fa-sm"></i>
            </div>
        </div>
    </div>
    <div class="agent-face">
        <div class="half">
            <img class="agent circle owner-img" src=""
                alt=""
                onerror="this.src='{{ asset('public/img/no_image.png') }}'">
        </div>
    </div>
    <div class="chat">
        <div class="chat-title">
            <h1 class="owner-username"></h1>
            <h2>
                <span style="font-size:10px;color:#999" class="owner-subuser"></span>
            </h2>
        </div>
        <div class="messages">
            <div class="messages-content"></div>
        </div>
        <div class="message-box">
            <textarea type="text" class="message-input" placeholder="Type message..."></textarea>
            <button type="submit" class="message-submit">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var $messages = $('.messages-content'),
                d, h, m,
                i = 0;
        var project_id,
            owner_id,
            owner_image,
            owner_username,
            owner_code,
            penjahit_id,
            penjahit_code = '';

        $(".unread-chat").click(function() {
            $(".avenue-messenger").toggleClass('hidden');
            $('.messages-content').mCustomScrollbar();

            project_id = $(this).data('project_id');
            owner_id = $(this).data('owner_id');
            owner_code = $(this).data('owner_code');
            owner_username = $(this).data('owner_username');
            owner_image = $(this).data('owner_image');
            penjahit_id = "{{ $penjahit_id }}";
            penjahit_code = "{{ $penjahit_code }}";
            $(".owner-img").attr('src', owner_image);
            $(".owner-username").html(owner_username);
            $(".owner-subuser").html('(IKM)');
            getMessage();
        });

        $("#btnChat").click(function() {
            $(".avenue-messenger").toggleClass('hidden');
            $('.messages-content').mCustomScrollbar();
            project_id = $(this).data('project_id');
            owner_id = $(this).data('owner_id');
            owner_code = $(this).data('owner_code');
            owner_username = $(this).data('owner_username');
            owner_image = $(this).data('owner_image');
            penjahit_id = "{{ $penjahit_id }}";
            penjahit_code = "{{ $penjahit_code }}";
            $(".owner-img").attr('src', owner_image);
            $(".owner-username").html(owner_username);
            getMessage();
            // setTimeout(function() {
            //      $.ajax({
            //         url: "",
            //         method: "POST",
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         data: {
            //             project_id: "",
            //             ikm_id: "",
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             var html = '';
            //             $('.mCSB_container').empty();
            //             if(response.errCode == 0) {
            //                 var data = response.data;
            //                 var userid = "";
            //                 var usercode = "";
            //                 $.each(data, function(i, val) {
            //                     html += renderChat(val, userid, usercode);
            //                 });
            //                 $('.mCSB_container').append(html).addClass("new");
            //             }
            //             updateScrollbar();
            //         },
            //     });
            // }, 1000);
            return false;
        });
        $('.message-submit').click(function() {
            insertMessage();
        });
        $(window).on('keydown', function(e) {
            if (e.which == 13) {
                insertMessage();
                return false;
            }
        })
        $('.closed').click(function(){
            $(".avenue-messenger").toggleClass('hidden');
        });

        function displayChat() {
            $(".avenue-messenger").toggleClass('hidden');
        }

        function getMessage() {
            if ($('.message-input').val() != '') {
                return false;
            }
            updateScrollbar();
            setTimeout(function() {
                $.ajax({
                    url: "{{ route('api.chat.penjahit') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        project_id: project_id,
                        user_login_id: "{{ \Lintas\libraries\CMemberLogin::get('id') }}",
                        penjahit_id: owner_id,
                        penjahit_code: owner_code,
                    },
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        $('.mCSB_container').empty();
                        if(response.errCode == 0) {
                            var data = response.data;
                            var userid = owner_id;
                            var usercode = owner_code;
                            $.each(data, function(i, val) {
                                html += renderChat(val, userid, usercode);
                            });
                            $('.mCSB_container').append(html).addClass("new");
                        }
                        updateScrollbar();
                    },
                });
            }, 1000 + (Math.random() * 20) * 100);
        }

        function insertMessage() {
            msg = $('.message-input').val();
            if ($.trim(msg) == '') {
                return false;
            }
            $.ajax({
                url: "{{ route('api.chat.send') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    project_id: project_id,
                    receiver: owner_id,
                    receiver_unique: owner_code,
                    sender: penjahit_id,
                    sender_unique: penjahit_code,
                    message: msg
                },
                dataType: 'json',
                success: function(response) {
                    var html = '';
                    if(response.errCode == 0) {
                        var data = response.data;
                        var userid = owner_id;
                        var usercode = owner_code;
                        $.each(data, function(i, val) {
                            html += renderChat(val, userid, usercode);
                        });
                        $('.mCSB_container').append(html).addClass("new");
                    }
                    $('.message-input').val(null);
                    updateScrollbar();
                },
            });
            setTimeout(function() {
                getMessage();
            }, 1000 + (Math.random() * 20) * 100);
        }

        function renderChat(obj, userid = null, usercode = null) {
            var bubble = (obj.sender == userid && obj.sender_unique == usercode) ? "message" : "message message-personal";
            var html = '<div class="' + bubble + '">'+ obj.message + '</div>';
            return html;
        }

        function setDate(){
            d = new Date()
            if (m != d.getMinutes()) {
                m = d.getMinutes();
                if(m < 10)
                    m = '0'+d.getMinutes();
                $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
                $('<div class="checkmark-sent-delivered">&check;</div>').appendTo($('.message:last'));
                $('<div class="checkmark-read">&check;</div>').appendTo($('.message:last'));
            }
        }
        function updateScrollbar() {
            $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
                scrollInertia: 10,
                timeout: 0
            });
        }
    })


</script>