<?php
    use Lintas\helpers\cchat;
    use Lintas\libraries\CMemberLogin;

    $penjahit_id = CMemberLogin::get('id');
    $chats = cchat::list($penjahit_id)['result'];
    if($chats == null):
        echo "Tidak ada data";
    else:
        $owner_image = '';
        $owner_user = '';
        $owner_code = '';
        $owner_id = '';

        foreach ($chats as $chat) :
            // if($chat->sender == $penjahit_id) {
            // } else {
                if($chat->id) {
                    $url = "#";

                    $project_id = $chat->project_id;
                    $project = \App\Models\Project::whereId($project_id)->first();
                    if($project != null) {
                        $owner_id = $project->ikm_id;
                        $owner = \App\Models\Ikm::find($owner_id);
                        if($owner != null) {
                            $owner_image = $owner->image_url;
                            $owner_user = $owner->name;
                            $owner_code = $owner->code;
                            $owner_id = $owner->id;
                        }

                        $url_attributes = "
                            data-project_id='{$project_id}'
                            data-owner_image='{$owner_image}'
                            data-owner_username='{$owner_user}'
                            data-owner_code='{$owner_code}'
                            data-owner_id='{$owner_id}'
                        ";
                    }
                }
                $chat_class = isset($chat->is_opened) ? '' : "unread-chat";

?>
    <a class="list-group-item <?php echo $chat_class; ?>" data-chat-id="<?php echo $chat->id; ?>" <?php echo $url_attributes; ?> >
        <div class="media-left">
            <span class="avatar avatar-xs">
                <img src="#" alt="" />
                <!--  if user name is not present then -->
            </span>
        </div>
        <div class="media-body w100p">
            <div class="media-heading">
                <span class="text-off pull-right" style='color:#999'><small><?php echo $chat->created_at; ?></small></span>
            </div>
            <div class="media m0" style="display:block">
                <div>{{ $chat->project_name }}</div>
                <div>
                    <?php
                        // $sender_name = '';
                        // $sender_id = $chat->sender;
                        // $sender = \App\Models\Ikm::find($sender_id);
                        // if($sender != null) {
                        //     $sender_name = $sender->name;
                        // }
                        // echo "<span style='color:#999'>".$sender_name."</span>"."<b>". " membalas: "."</b>";
                        // if($chat->sender != $penjahit_id) {
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