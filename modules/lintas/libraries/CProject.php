<?php
namespace Lintas\libraries;
use Lintas\libraries\CApiDirect;

class CProject {
    public static function projectUpdate($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('ProjectUpdate', $options);
    }

    public static function projectNonactive($options = array(), $orgId = null) {
        return CApiDirect::instance($orgId)->exec('ProjectNonactive', $options);
    }
}