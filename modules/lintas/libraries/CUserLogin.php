<?php
namespace Lintas\libraries;
use Illuminate\Support\Arr;
use Auth;
use Lintas\helpers\utils;
use App\Models\Ikm;

class CUserLogin {
    public static function get($key = null) {
        $ikm_id = Auth::guard('admin')->check() ? Auth::guard('admin')->user()->ikm_id : '';
        $model_ikm = $ikm_id != null ? Ikm::find($ikm_id) : null;
        $dataUser = self::getSession($model_ikm);
        if($key == null) {
            return $dataUser;
        }
        return Arr::get($dataUser, $key);
    }

    public static function refreshSession() {
        $id = Auth::guard('admin')->user()->id;
        Auth::guard('admin')->logout();
        return Auth::guard('admin')->loginUsingId($id);
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
        $data['email'] = $credential->email;
        $data['province_id'] = $credential->province_id;
        $data['city_id'] = $credential->city_id;
        $data['address'] = $credential->address;
        $data['image_url'] = $credential->image_url;
        $data['gender'] = $credential->gender;
        return $data;
    }

    public static function dataUser($key = null) {

    }

}