<?php
namespace Lintas\libraries;
class CApi {
    private static $instance = array();
    protected $org_id = null;
    protected function __construct($org_id) {
        $this->org_id = $org_id;
    }

    public static function instance($org_id = null) {
        if ($org_id == null) {
            $org_id = 1;
        }
        if (self::$instance == null) {
            self::$instance = array();
        }
        if (self::$instance == null) {
            self::$instance[$org_id] = new CApi($org_id);
        }
        return self::$instance[$org_id];
    }

    public function exec($method = null) {
        $response = array();
        $class_name = '\Lintas\libraries\CApi\Method\\'.$method;
        $logger = null;
        if (class_exists($class_name)) {
            $methodObject = new $class_name($method, $this->org_id);
            $methodObject->execute();
            // $logger = new CMApi_Logger($methodObject->sessionId());
            // $logger->logRequest($method, $methodObject->request());
            // if ($methodObject->getErrCode() == 0) {
            //     $methodObject->execute();
            // }
            $response = $methodObject->result();
        } else {
            $response = array(
                'err_code' => '11',
                'err_message' => 'Class not found',
            );
        }

        // if ($logger != null) {
        //     $logger->logResponse($method, $response);
        // }
        return $response;
    }

}

