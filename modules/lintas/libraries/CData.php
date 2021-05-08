<?php
namespace Lintas\libraries;
use Lintas\libraries\CApiDirect;
class CData {
    public static function getProvince($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('GetProvince', $options);
    }

    public static function getCity($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('GetCity', $options);
    }

    public static function getDistricts($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('GetDistricts', $options);
    }
}