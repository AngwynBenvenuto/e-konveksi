<?php
    use Lintas\helpers\cchat;
    use Lintas\libraries\CUserLogin;

    $ikm_id = CUserLogin::get('id');
    //$project = \Session::get('project_id');
    $chats = cchat::list($ikm_id, )['result'];
    if($chats == null):
        echo "Tidak ada data";
    else:
        $penjahit_image = '';
        $penjahit_user = '';
        $penjahit_code = '';
        $penjahit_id = '';
        $ikm_image = '';
        $ikm_user = '';
        $ikm_code = '';
        $ikm_id = '';

        foreach ($chats as $chat) :
            // if($chat->sender != $ikm_id) {
            // } else {
                if($chat->id) {
                    $url = "#";

                    $project_id = $chat->project_id;

                    $project = \App\Models\Project::whereId($project_id)->first();
                    if($project != null) {
                        $ikm = \App\Models\Ikm::find($project->ikm_id);
                        if($ikm != null) {
                            $ikm_image = $ikm->image_url;
                            $ikm_user = $ikm->name;
                            $ikm_code = $ikm->code;
                            $ikm_id = $ikm->id;
                        }

                        $sender = $chat->sender;
                        $penjahit = \App\Models\Penjahit::find($sender);
                        if($penjahit != null) {
                            $penjahit_image = $penjahit->image_url;
                            $penjahit_user = $penjahit->name;
                            $penjahit_code = $penjahit->code;
                            $penjahit_id = $penjahit->id;
                        }

                        $url_attributes = "
                            data-project_id='{$project_id}'
                            data-penjahit_image='{$penjahit_image}'
                            data-penjahit_username='{$penjahit_user}'
                            data-penjahit_code='{$penjahit_code}'
                            data-penjahit_id='{$penjahit_id}'
                            data-ikm_image='{$ikm_image}'
                            data-ikm_username='{$ikm_user}'
                            data-ikm_code='{$ikm_code}'
                            data-ikm_id='{$ikm_id}'
                        ";
                    }

                }
                $chat_class = isset($chat->is_opened) ? '' : 'unread-chat';
?>
    <a class="list-group-item <?php echo $chat_class; ?>" data-chat-id="<?php echo $chat->id; ?>" <?php echo $url_attributes; ?> >
        <div class="media-left">
            {{-- <span class="avatar avatar-xs">
                <img src="#" alt="" />
                <!--  if user name is not present then -->
            </span> --}}
        </div>
        <div class="media-body w100p">
            <div class="media-heading">
                <span class="text-off pull-right" style='color:#999'><small><?php echo $chat->created_at; ?></small></span>
            </div>
            <div class="media m0" style="display:block">
                <div>
                    {{ $chat->project_name }}
                </div>
                <div>
                    <?php
                        // $receiver_name = '';
                        // if($chat->receiver != $ikm_id) {
                        //     $receiver = \App\Models\Penjahit::find($chat->receiver);
                        //     if($receiver != null) {
                        //         $receiver_name = $receiver->name;
                        //     }
                        //     echo "<span style='color:#999'>".$receiver_name."</span>"."<b>". " membalas: "."</b>";
                        // }
                        echo "<span style='color:#999'></span>"."<b>". " membalas: "."</b>";
                        echo "<span style='color:#888'>".htmlentities($chat->message)."</span>";
                    ?>
                </div>
            </div>
        </div>
    </a>
<?php
        //}
        endforeach;
    endif;
?>
