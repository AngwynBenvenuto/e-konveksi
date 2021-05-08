<?php
namespace Lintas\libraries;
use Lintas\libraries\Curl\Request\Body;
use Lintas\libraries\Curl\Request;
use Lintas\libraries\Curl\Exception;
use Illuminate\Support\Arr;
use Lintas\helpers\cobj;
use Lintas\helpers\utils;

class CCurl {
    public static $instance = null;

    public static function instance() {
        if (self::$instance == null || !isset(self::$instance)) {
            self::$instance = new CCurl();
        }
        return self::$instance;
    }

    public function execute($url = null, $param = array(), $key = '', $is_debug = false, $is_rajaongkir = '') {
        $err_code = 0;
        $err_message = "";
        $response = "";
        $error = array();
        $result = '';
        $data = array();

        if($err_code == 0) {
            if($url != null)
                $url = filter_var($url, FILTER_SANITIZE_URL);
        }

        if($err_code == 0) {
            if(strlen($url) == 0) {
                $err_code++;
                $err_message = "Url ".$url." is not found";
            }
            else if(!filter_var($url, FILTER_VALIDATE_URL)) {
                $err_code++;
                $err_message = "Url ".$url." is not valid, please insert a valid url";
            }
            // else if(!utils::urlExist($url)) {
            //     $err_code++;
            //     $err_message = "Url ".$url." is doesn't exists";
            // }
        }

        if($err_code == 0) {
            try {
                $headers = array('Accept' => 'application/json');
                if(strlen($key) > 0) {
                    $headers['key'] = $key;
                }
                $body = Body::form($param);
                $request = Request::post($url, $headers, $body);
                if($request) {
                    $response = $request->body;

                }
            } catch (\Exception $ex) {
                $err_code = 545;
                $err_message = "Upss something error in ". $ex->getMessage();
            }
        }

        if($err_code == 0) {
            if($is_debug == true){
                $error['errCode'] = $err_code;
                $error['errMsg'] = $err_message;
                $result = json_encode($error);
            } else if($is_rajaongkir == 1) {
                return $response;
            } else {
                if (cobj::get($response, 'errCode') > 0) {
                    throw new Exception(cobj::get($response, 'errMsg'), array(), cobj::get($response, 'errCode'));
                }
                $result = cobj::get($response, 'data', array());
            }
        }
        return $result;
    }


}