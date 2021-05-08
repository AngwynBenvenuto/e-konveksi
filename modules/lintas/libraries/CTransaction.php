<?php
namespace Lintas\libraries;
use Lintas\libraries\CApiDirect;

class CTransaction {
    public static function createTransaction($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('Transaction', $options);
    }

    public static function createFormKerjasama($options, $orgId = null) {
        return CApiDirect::instance($orgId)->exec('FormKerjasama', $options);
    }
}