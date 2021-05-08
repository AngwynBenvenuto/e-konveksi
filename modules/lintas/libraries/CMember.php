<?php
namespace Lintas\libraries;
use Lintas\libraries\CApiDirect;

class CMember {
    public static function updateProfile($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberUpdateProfile', $options);
    }

    public static function updateProfileImage($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberUpdateProfileImage', $options);
    }

    public static function getListMemberAddress($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberListAddress', $options);
    }

    public static function setMemberMainAddress($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberSetMainAddress', $options);
    }

    public static function changePassword($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberChangePassword', $options);
    }

    public static function getMemberAddressType($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberGetAddressType', $options);
    }

    public static function setMemberAddressType($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberSetAddressType', $options);
    }

    public static function deleteMemberAddress($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('MemberDeleteAddress', $options);
    }
}