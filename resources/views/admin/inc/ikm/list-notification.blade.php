<?php
    use Lintas\helpers\cnotif;
    use Lintas\libraries\CUserLogin;

    $ikm_id = CUserLogin::get('id');
    $penjahit_id = null;
    $notifications = cnotif::list($ikm_id, $penjahit_id)['result'];
    if($notifications == null) :
        echo "Tidak ada data";
    else :
        $txt_penjahit = '';
        foreach ($notifications as $notification) :
            $type = $notification->type;
            $url = "#";
                if($notification->id) {
                $url_attributes = "href='$url'";
            }
            $notification_class = $notification->is_opened > 0 ? '' : "unread-notification";
?>
    <a class="list-group-item <?php echo $notification_class; ?>" data-notification-id="<?php echo $notification->id; ?>" <?php echo $url_attributes; ?> >
        <div class="media-left">
            <span class="avatar avatar-xs">
                <img src="#" alt="" />
                <!--  if user name is not present then -->
            </span>
        </div>
        <div class="media-body w100p">
            <div class="media-heading">
                <span class="text-off pull-right"><small><?php echo $notification->created_at; ?></small></span>
            </div>
            <div class="media m0" style="display:block">
                <b style='color:#999'>
                    <?php echo sprintf($notification->name) ?>
                </b>
                <div>{!! $notification->description !!}</div>
            </div>
        </div>
    </a>
<?php
        endforeach;
    endif;
?>