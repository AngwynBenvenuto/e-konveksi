<?php
namespace Lintas\libraries;
use Illuminate\Support\Arr;
use Auth;
use Lintas\helpers\utils;

class CMemberLogin {
    public static function get($key = null) {
        $dataUser = self::getSession(Auth::user());
        if($key == null) {
            return $dataUser;
        }
        return Arr::get($dataUser, $key);
    }

    public static function getSession($credential = '') {
        if($credential == null)
            return;

        $data = array();
        $data['id'] = $credential->id;
        $data['name'] = $credential->name;
        $data['code'] = $credential->code;
        $data['name_display'] = $credential->name_display;
        $data['birthdate'] = $credential->birthdate;
        $data['phone'] = $credential->phone;
        $data['province_id'] = $credential->province_id;
        $data['city_id'] = $credential->city_id;
        $data['address'] = $credential->address;
        $data['email'] = $credential->email;
        $data['image_url'] = $credential->image_url;
        $data['gender'] = $credential->gender;
        return $data;
    }

    public static function refreshSession() {
        $id = Auth::user()->id;
        Auth::logout();
        return Auth::loginUsingId($id);
    }

    public static function dataUser($param) {
        return self::getSession($param);
    }

}