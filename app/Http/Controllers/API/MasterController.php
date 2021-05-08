<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use App\Models\Ikm;
use App\Models\Penjahit;

class MasterController extends Controller {
    public function ikm() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $ikm_id = '';

        if($request != null) {
            $ikm_id = Arr::get($request, 'ikm_id');

            if($errCode == 0) {
                if(strlen($ikm_id) == 0) {
                    $errCode = 14;
                    $errMsg = "Ikm required";
                }
            }

            if($errCode == 0) {
                try{
                    $model = Ikm::find($ikm_id);
                    if($model == null) {
                        $errCode = 14555;
                        $errMsg = "Data not found";
                    } else {
                        $dt = $model->toArray();
                        if($dt != null) {
                            $data = array(
                                'name' => Arr::get($dt, 'name'),
                                'email' => Arr::get($dt, 'email'),
                                'address' => Arr::get($dt, 'address'),
                                'phone' => Arr::get($dt, 'phone'),
                                'province_id' => Arr::get($dt, 'province_id'),
                                'city_id' => Arr::get($dt, 'city_id'),
                                'postal_code' => Arr::get($dt, 'postal_code')
                            );
                        }
                    }
                } catch(\Exception $e) {
                    $errCode = 154;
                    $errMsg = $e->getMessage();
                }
            }
        }

        $return = array();
        if($errCode == 0) {
            $return['errCode'] = $errCode;
            $return['errMsg'] = $errMsg;
            $return['data'] = $data;
        } else {
            $return['errCode'] = $errCode;
            $return['errMsg'] = $errMsg;
        }
        return response()->json($return, 200);
    }

    public function penjahit() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $penjahit_id = '';

        if($request != null) {
            $penjahit_id = Arr::get($request, 'penjahit_id');

            if($errCode == 0) {
                if(strlen($penjahit_id) == 0) {
                    $errCode = 14;
                    $errMsg = "Penjahit required";
                }
            }

            if($errCode == 0) {
                try{
                    $model = Penjahit::find($penjahit_id);
                    if($model == null) {
                        $errCode = 14555;
                        $errMsg = "Data not found";
                    } else {
                        $dt = $model->toArray();
                        if($dt != null) {
                            $data = array(
                                'name' => Arr::get($dt, 'name'),
                                'email' => Arr::get($dt, 'email'),
                                'address' => Arr::get($dt, 'address'),
                                'phone' => Arr::get($dt, 'phone'),
                                'province_id' => Arr::get($dt, 'province_id'),
                                'city_id' => Arr::get($dt, 'city_id'),
                                'postal_code' => Arr::get($dt, 'postal_code')
                            );
                        }
                    }
                } catch(\Exception $e) {
                    $errCode = 154;
                    $errMsg = $e->getMessage();
                }
            }
        }

        $return = array();
        if($errCode == 0) {
            $return['errCode'] = $errCode;
            $return['errMsg'] = $errMsg;
            $return['data'] = $data;
        } else {
            $return['errCode'] = $errCode;
            $return['errMsg'] = $errMsg;
        }
        return response()->json($return, 200);
    }
}