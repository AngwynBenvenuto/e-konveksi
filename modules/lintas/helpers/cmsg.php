<?php
namespace Lintas\helpers;
use Lintas\libraries\CMessage;
class cmsg {
    public static function add($type, $message) {
        $msg = session('cmsg_' . $type);
        if (!is_array($msg)) {
            $msgs = array();
        }
        $msgs[] = $message;
        \Session::put('cmsg_' . $type, $msgs);
    }
    
    public static function get($type) {
        $val = session('cmsg_' . $type);
        return $val;
    }
    
    public static function clear($type) {
        \Session::forget('cmsg_' . $type);
    }

    public static function clear_all() {
        self::clear('error');
        self::clear('warning');
        self::clear('info');
        self::clear('success');
    }
    
    public static function flash($type) {
        $msgs = cmsg::get($type);
        $message = "";
        if (is_array($msgs)) {
            foreach ($msgs as $msg) {
                $message .= "<p>" . $msg . "</p>";
            }
        } else if (is_string($msgs)) {
            if (strlen($msgs) > 0)
                $message = $msgs;
        }
        cmsg::clear($type);
        if (strlen($message) > 0) {
            $message = CMessage::factory()->set_type($type)->set_message($message)->html();
        }
        return $message;
    }
    
     public static function flash_all() {
        return cmsg::flash("error") . cmsg::flash("warning") . cmsg::flash("info") . cmsg::flash("success");
    }
}
