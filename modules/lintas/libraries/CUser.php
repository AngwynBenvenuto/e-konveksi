<?php
namespace Lintas\libraries;
use Lintas\libraries\CApiDirect;
class CUser {
    public static function updateProfile($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('UserUpdateProfile', $options);
    }

    public static function updateProfileImage($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('UserUpdateProfileImage', $options);
    }

    public static function changePassword($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('UserChangePassword', $options);
    }

}