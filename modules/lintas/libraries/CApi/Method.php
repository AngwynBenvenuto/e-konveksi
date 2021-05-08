<?php
namespace Lintas\libraries\CApi;
use Lintas\libraries\CApi\MethodInterface;
abstract class Method implements MethodInterface {
    protected $method;
    protected $session;
    protected $err_code = 0;
    protected $err_message = "";
    protected $data = array();

    public function __construct($method, $org_id, $session_id = null, $request = null) {
        $this->method = $method;
        $this->org_id = $org_id;
        $this->request = $request;
    }

    public function request() {
        if ($this->request == null) {
            return array_merge($_GET, $_POST);
        }
        return $this->request;
    }

    public function result() {
        $return = array(
            'err_code' => $this->err_code,
            'err_message' => $this->err_message,
            'data' => $this->data,
        );
        return $return;
    }

}