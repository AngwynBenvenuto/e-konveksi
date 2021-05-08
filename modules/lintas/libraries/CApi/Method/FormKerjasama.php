<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;
use Lintas\helpers\utils;

class FormKerjasama extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();








        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}