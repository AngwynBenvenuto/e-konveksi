<?php

namespace Lintas\helpers;
use DB;
use Illuminate\Support\Arr;

class clog {
    public static function activity($param, $activity_type = "", $description = "") {
        $data_before = array();
        $data_after = array();
        if (!is_array($param)) {
            $user_id = $param;
        } else {
            $user_id = Arr::get($param, 'user_id');
            $data_before = Arr::get($param, 'before', array());
            $data_after = Arr::get($param, 'after', array());
        }

        $data_before = json_encode($data_before);
        $data_after = json_encode($data_after);
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $session_id = session_id();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $arrbrowser = get_browser($user_agent, true);
        if($arrbrowser) {
            $browser = $arrbrowser['browser'];
            $browser_version = $arrbrowser['version'];
            $platform = $arrbrowser['platform'];
            $platform_version = $arrbrowser['majorver']."".$arrbrowser['minorver'];
        }
        $nav_name = "";
        $nav_label = "";
        $action_label = "";
        $action_name = "";
        $data = array(
            "org_id" => null,
            "activity_date" => date("Y-m-d H:i:s"),
            "user_agent" => $user_agent,
            "browser" => $browser,
            "browser_version" => $browser_version,
            "platform" => $platform,
            "platform_version" => $platform_version,
            "remote_addr" => $ip_address,
            "user_id" => $user_id,
            "action" => $action_name,
            "action_label" => $action_label,
            "activity_type" => $activity_type,
            "description" => $description,
            "app_id" => null,
            "data_before" => $data_before,
            "data_after" => $data_after,
        );
        //DB::table('log_activity')->insert($data);
    }

    public static function login($user_id) {
        $ip_address = $_SERVER['REMOTE_ADDR']; 
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $session_id = session_id();
        $arrbrowser = get_browser($user_agent, true);
        if($arrbrowser) {
            $browser = $arrbrowser['browser'];
            $browser_version = $arrbrowser['version'];
            $platform = $arrbrowser['platform'];
            $platform_version = $arrbrowser['majorver']."".$arrbrowser['minorver'];
        }
        $data = array(
            "login_date" => date("Y-m-d H:i:s"),
            "user_agent" => $user_agent,
            "browser" => $browser,
            "browser_version" => $browser_version,
            "platform" => $platform,
            "platform_version" => $platform_version,
            "remote_addr" => $ip_address,
            "user_id" => $user_id,
            "session_id" => $session_id,
            "org_id" => null,
            "app_id" => null,
        );
        //DB::table('log_login')->insert($data);
    }

    public static function login_fail($username, $password, $error_message) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $session_id = session_id();
        $arrbrowser = get_browser($user_agent, true);
        if($arrbrowser) {
            $browser = $arrbrowser['browser'];
            $browser_version = $arrbrowser['version'];
            $platform = $arrbrowser['platform'];
            $platform_version = $arrbrowser['majorver']."".$arrbrowser['minorver'];
        }
        $data = array(
            "login_fail_date" => date("Y-m-d H:i:s"),
            "org_id" => null,
            "user_agent" => $user_agent,
            "username" => $username,
            "password" => $password,
            "error_message" => $error_message,
            "browser" => $browser,
            "browser_version" => $browser_version,
            "platform" => $platform,
            "platform_version" => $platform_version,
            "remote_addr" => $ip_address,
            "session_id" => $session_id,
            "app_id" => null,
        );
        //DB::table('log_login_fail')->insert($data);
    }
}