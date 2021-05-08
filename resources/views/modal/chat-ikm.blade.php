<?php
    use \Lintas\libraries\CUserLogin;

    $project_id = "";
    $ikm_id = CUserLogin::get('id');
    $ikm_username = CUserLogin::get('name');
    $ikm_image = CUserLogin::get('image_url');
    $ikm_code = CUserLogin::get('code');
    $penjahit_id = "";
    $penjahit_image = "";
    $penjahit_username = "";
    $penjahit_code = "";
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
            <img class="agent circle penjahit-img" src=""
                alt=""
                onerror="this.src='{{ asset('public/img/no_image.png') }}'">
        </div>
    </div>
    <div class="chat">
        <div class="chat-title">
            <h1 class="penjahit-username"></h1>
            <h2>
                <span style="font-size:10px;color:#999" class="penjahit-subuser"></span>
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
        /*
        penjahit
        ----------
        owner -> ikm
        penjahit -> penjahit


        ikm
        ---------
        penjahit -> penjahit
        ikm -> ikm (yang login)
        */
        var project_id,
            ikm_id,
            ikm_image,
            ikm_username,
            ikm_code,
            penjahit_id,
            penjahit_code,
            penjahit_image,
            penjahit_username = '';

        $(".unread-chat").click(function() {
            $(".avenue-messenger").toggleClass('hidden');
            $('.messages-content').mCustomScrollbar();

            project_id = $(this).data('project_id');
            ikm_id = $(this).data('ikm_id');
            ikm_code = $(this).data('ikm_code');
            ikm_username = $(this).data('ikm_username');
            ikm_image = $(this).data('ikm_image');
            penjahit_id = $(this).data('penjahit_id');
            penjahit_code = $(this).data('penjahit_code');
            penjahit_username = $(this).data('penjahit_username');
            penjahit_image = $(this).data('penjahit_image');
            $(".penjahit-img").attr('src', penjahit_image);
            $(".penjahit-username").html(penjahit_username);
            $(".penjahit-subuser").html('(Penjahit)');
            getMessage();
        });

        //$("#btnChat").click(function() {
            // $(".avenue-messenger").toggleClass('hidden');
            // $('.messages-content').mCustomScrollbar();
            // project_id = $(this).data('project_id');
            // owner_id = $(this).data('owner_id');
            // owner_code = $(this).data('owner_code');
            // owner_username = $(this).data('owner_username');
            // owner_image = $(this).data('owner_image');
            // penjahit_id = "{{ $penjahit_id }}";
            // penjahit_code = "{{ $penjahit_code }}";
            // $(".owner-img").attr('src', owner_image);
            // $(".owner-username").html(owner_username);
            // getMessage();
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
        //    return false;
        //});
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
                    url: "{{ route('api.chat.ikm') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        project_id: project_id,
                        user_login_id: "{{ \Lintas\libraries\CUserLogin::get('id') }}",
                        ikm_id: ikm_id,
                        ikm_code: ikm_code,
                    },
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        $('.mCSB_container').empty();
                        if(response.errCode == 0) {
                            var data = response.data;
                            var userid = "{{ $ikm_id }}";
                            var usercode = "{{ $ikm_code }}";
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
                    receiver: penjahit_id,
                    receiver_unique: penjahit_code,
                    sender: ikm_id,
                    sender_unique: ikm_code,
                    message: msg
                },
                dataType: 'json',
                success: function(response) {
                    var html = '';
                    if(response.errCode == 0) {
                        var data = response.data;
                        var userid = "{{ $ikm_id }}";
                        var usercode = "{{ $ikm_code }}";
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
            var bubble = (obj.receiver == userid && obj.receiver_unique == usercode) ? "message" : "message message-personal";
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