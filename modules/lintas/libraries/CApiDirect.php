<?php

namespace Lintas\libraries;
use Lintas\libraries\CApi\Exception as ApiException;
use Illuminate\Support\Arr;

class CApiDirect {
    protected $method = "";
    public $org_id = null;
    private static $instance = array();

    public function __construct($org_id = null) {
        $this->org_id = $org_id; 
    }

    public static function instance($org_id = null) {
        if ($org_id == null) {
            $org_id = 1;
        }
        if (self::$instance == null) {
            self::$instance = array();
        }
        if (self::$instance == null || !isset(self::$instance[$org_id])) {
            self::$instance[$org_id] = new CApiDirect();
        }
        return self::$instance[$org_id];
    }

    public function exec($method = null, $options = array()) {
        $response = array();
        $class_name = '\Lintas\libraries\CApi\Method\\'.$method;
        if (class_exists($class_name)) {
            $is_direct = true;
            $session_id = str_pad($this->org_id, 21, "0", STR_PAD_LEFT);
            $method_object = new $class_name($method, $this->org_id, $session_id, $options);
            $method_object->execute();
            $response = $method_object->result();
        } else {
            $response = array(
                'err_code' => '11',
                'err_message' => 'Class ' . $class_name . ' not found',
            );
        }
        
        if (Arr::get($response, 'err_code') > 0) {
            throw new ApiException(Arr::get($response, 'err_message'), array(), Arr::get($response, 'err_code'));
        }
        return Arr::get($response, 'data');
    }

}