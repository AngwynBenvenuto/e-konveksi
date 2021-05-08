<?php

namespace Lintas\libraries;
use Lintas\helpers\cmsg;
use Lintas\libraries\CM;
class CAdmin extends CM {
    /**
     * 
     * @return boolean always return false
     */
    public static function notAccessible($moduleName = '') {
        cmsg::add('error', 'You do not have access to this ' .$moduleName. ' module, please call administrator');
        return false;
    }

    /**
     * 
     * @param string $permissionName
     * @return boolean
     */
    public static function havePermission($permissionName) {
        
    }

    /**
     * redirect when false
     * 
     * @param string $permissionName
     * @return boolean
     */
    public static function checkPermission($permissionName) {
        if (!self::havePermission($permissionName)) {
            self::notAccessible($permissionName);
            return false;
        }
        return true;
    }
    
    public static function error_show() {
        $msg = cmsg::flash_all();
        if (strlen($msg) > 0) {
            echo "<div class='col-lg-12 col-md-12 col-sm-12'>
                    <div class='row-fluid'>
                      <div class='span12'>{$msg}</div>
                    </div>
                  </div>";
        }
    }
}