<?php
use Lintas\helpers\cmsg;

$message_type = array('error', 'warning', 'info', 'success');
foreach ($message_type as $type) :
    $msgs = cmsg::get($type);
    $message = "";
    if (is_array($msgs)) {
        foreach ($msgs as $msg) {
            $message .= "<p>" . $msg . "</p>";
        }
    } else if (is_string($msgs)) {
        if (strlen($msgs) > 0) {
            $message = $msgs;
        }
    }

    if (strlen($message) > 0) :
        cmsg::clear($type);
        $class = $title = $type;
        switch ($type) {
            case 'error':
                $title = 'Error';
                $class = 'danger';
                break;
            case 'warning':
                $title = 'Warning';
                $class = 'warning';
                break;
            case 'info':
                $title = 'Info';
                $class = 'info';
                break;
            case 'success':
                $title = 'Success';
                $class = 'success';
                break;
        }

    ?>
        <div class="alert-container ">
            <div class="alert alert-dismissable alert-<?php echo $class; ?>">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?php echo $title; ?>!</strong> <?php echo $message; ?>
            </div>
        </div>
    <?php
    endif;
endforeach;