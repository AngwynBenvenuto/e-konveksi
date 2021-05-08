<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Lintas\libraries\CData;
use Lintas\libraries\CCurl;
use Lintas\libraries\RajaOngkir;
use App\Models\Province;
use App\Models\City;

class DataController extends Controller {
    public function province() {
        return CData::getProvince();
    }

    public function insertProvinceCity()
    {
        $this->provinceAll();
        $this->cityAll();
    }

    public function provinceAll() {
        $errCode = 0;
        $errMsg = '';
        $data = array();

        if($errCode == 0) {
            \DB::table('province')->delete();

            $provinsi = RajaOngkir::province()->all();
            foreach($provinsi as $row) {
                $dataProvinsi = array(
                    'name' => $row['province'],
                );
                $model = Province::whereId($row['province_id'])->first();
                if($model == null) {
                    $model = new Province;
                }
                $model->fill($dataProvinsi);
                $save = $model->save();
                if($save) {
                    $data = array(
                        'error' => 0,
                        'message' => 'Sukses insert province'
                    );
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

    public function city() {
        $province_id = request()->province_id;
        $options = array('province_id' => $province_id);
        return CData::getCity($options);
    }
    public function cityAll() {
        $errCode = 0;
        $errMsg = '';
        $data = array();

        if($errCode == 0) {
            //delete all city
            \DB::table('city')->delete();

            $kota = RajaOngkir::city()->all();
            foreach($kota as $row) {
                $dataKota = array(
                    'province_id' => $row['province_id'],
                    'name' => $row['city_name'],
                );
                $model = City::whereId($row['city_id'])->first();
                if($model == null) {
                    $model = new City;
                }
                $model->fill($dataKota);
                $save = $model->save();
                if($save) {
                    $data = array(
                        'error' => 0,
                        'message' => 'Sukses insert city'
                    );
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

    public function districts() {
        $city_id = request()->city_id;
        $options = array('city_id' => $city_id);
        return CData::getDistricts($options);
    }

    public function cost() {
        $services = array();
        $errCode = 0;
        $errMsg = "";
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $origin = Arr::get($request, 'origin');
            $destination = Arr::get($request, 'destination');
            $weight = Arr::get($request, 'weight');
            $courier = Arr::get($request, 'courier');
        }

        if($errCode == 0) {
            if(strlen($origin) == 0) {
                $errCode = 23;
                $errMsg = "Origin harus diisi";
            }
            else if(strlen($destination) == 0) {
                $errCode = 24;
                $errMsg = "Destination harus diisi";
            }
        }
       
        if($errCode == 0) {
            $dataReq = array(
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            );
            $url = 'https://api.rajaongkir.com/starter/cost';
            $key = '30078050e5cda99a787652ac8bfd718b';

            //
            $requestOngkir = CCurl::instance()->execute($url, $dataReq, $key, null, 1);
            if($requestOngkir != null) {
                $ongkirData = $requestOngkir->rajaongkir;
                $code = $requestOngkir->rajaongkir->status->code;
                if($code == 400){
                    $errCode = 14045;
                    $errMsg = $requestOngkir->rajaongkir->status->description;
                    //throw new \Exception($requestOngkir->rajaongkir->status->description, 1);
                } else{
                    $origin_det = $requestOngkir->rajaongkir->origin_details;
                    $des_det = $requestOngkir->rajaongkir->destination_details;
                    $result = $requestOngkir->rajaongkir->results;
                    if($result != null && 
                        ($origin_det != "false" || $origin_det != null) && 
                        ($des_det != "false" || $des_det != null)
                    ) {
                        foreach($result as $row) {
                            $code = $row->code;
                            $name = $row->name;
                            $costs = $row->costs;

                            $services[] = array(
                                'meta' => array(
                                    'destination' => array(
                                        'province' => $des_det->province,
                                        'type' => $des_det->type,
                                        'city_name' => $des_det->city_name,
                                        'postal_code' => $des_det->postal_code
                                    )
                                ),
                                'code' => $code,
                                'name' => $name,
                                'costs' => $costs
                            );
                        }
                    } else {
                        $services = array('error' => 2222, 'message' => 'Error undefined data.');
                    }
                }
            }
        }
        

        $arr = array();
        if($errCode == 0) {
            $arr['errCode'] = $errCode;
            $arr['errMsg'] = $errMsg;
            $arr['data'] = $services;
        } else {
            $arr['errCode'] = $errCode;
            $arr['errMsg'] = $errMsg;
        }
        return response()->json($arr, 200);
        //return $services;
    }



}