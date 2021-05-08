<?php

namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use App\Models\Country;
use Illuminate\Support\Arr;
use Lintas\helpers\cmsg;
use DB;

class CityController extends MasterController {
    public function index() {
        return view('admin.master.kota.index');
    }

    // public function generate_city_data() {
    //     $dataCity = array();
    //     $json = \File::get(public_path("/data/city.json"));
    //     $data = json_decode($json);
    //     foreach ($data as $row) {
    //         $dataCity = array(
    //             'province_id' => $row->province_id,
    //             'country_id' => $row->country_id,
    //             'code' => $row->code,
    //             'area_code' => $row->area_code,
    //             'name' => trim($row->name),
    //             'is_posted' => $row->is_posted,
    //             'created_at' => date('Y-m-d H:i:s'),
    //         );
    //         DB::table('city')->insert($dataCity);
    //     }
    // }

    public function show() {
        $errCode = 0;
        $errMsg = "";
        $kotas = "";
        $data = array();

        if($errCode == 0) {
            $kotas = City::with(['province'])
                        //->whereRaw('country_id = 94')
                        ->where('status','>', 0)
                        ->orderByRaw("province_id asc")
                        ->get();
            if($kotas != null) {
                $kota = $kotas->toArray();
                if($kota != null) {
                    foreach($kota as $row){
                        $name = Arr::get($row, 'name');
                        // $country_id = Arr::get($row, 'country_id');
                        // $country = Arr::get($row, 'country');
                        // if($country != null)
                        //     $country_name = Arr::get($country, 'name');
                        $province_id = Arr::get($row, 'province_id');
                        if($province_id != null) {
                            $province = \App\Models\Province::find($province_id);
                            if($province != null) {
                                $province_name = $province->name;
                            }
                        }
                        $data[] = array(
                            'id' => Arr::get($row, 'id'),
                            'name' => $name,
                            //'country' => $country_name,
                            'province_id' => $province_id,
                            'province' => $province_name,
                            'created_at' => (string)Arr::get($row, 'created_at'),
                            'updated_at' => (string)Arr::get($row, 'updated_at'),
                            'status' => Arr::get($row, 'status'),

                        );
                    }
                }
            }
        }

        $array = array();
        if($errCode == 0) {
            if(count($data) > 0) {
                foreach($data as $rows){
                    $array['data'][] = $rows;
                }
            } else {
                $array['data'] = array();
            }
        }
        return response()->json($array, 200);
    }

    public function create() {
        return $this->edit();
    }

    public function edit($id = null) {
        $data = array();
        // $country = Country::where('status', '>', 0)
        //             ->get()
        //             ->toArray();
        $province = Province::where('status', '>', 0)
                    ->whereRaw('country_id = 94')
                    ->get()
                    ->toArray();

        $name = '';
        $country_id = '';
        $province_id = '';
        $code = '';
        $area_code = '';
        $is_posted = '';
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';

        if(strlen($id) > 0) {
            try{
                $modelKota = City::find($id);
                if($modelKota != null) {
                    $kota = $modelKota->toArray();
                    $name = Arr::get($kota, 'name');
                    //$country_id = Arr::get($kota, 'country_id');
                    $province_id = Arr::get($kota, 'province_id');
                    $code = Arr::get($kota, 'code');
                    $area_code = Arr::get($kota, 'area_code');
                    $is_posted = Arr::get($kota, 'is_posted');
                } else {
                    $errCode = 1414;
                    $errMsg = "Kota not found.";
                }
            } catch(\Exception $ex) {
                $errCode = 520;
                $errMsg = $ex->getMessage();
            }
        }


        if($request != null) {
            $name = Arr::get($request, 'name');
            //$country_id = Arr::get($request, 'country_id');
            $province_id = Arr::get($request, 'province_id');
            $code = Arr::get($request, 'code');
            $area_code = Arr::get($request, 'area_code');
            if ($errCode == 0) {
                // if (strlen($country_id) == 0) {
                //     $errCode = 132;
                //     $errMsg = 'Country ID required';
                // }
            }
            if ($errCode == 0) {
                if (strlen($province_id) == 0) {
                    $errCode = 133;
                    $errMsg = 'Provinsi ID required';
                }
            }
            if ($errCode == 0) {
                if (strlen($name) == 0) {
                    $errCode = 134;
                    $errMsg = 'Nama required';
                }
            }

            DB::beginTransaction();
            if($errCode == 0){
                $param = array();
                $param['name'] = $name;
                //$param['country_id'] = $country_id;
                $param['province_id'] = $province_id;
                $param['code'] = $code;
                $param['area_code'] = $area_code;
                $param['is_posted'] = $is_posted;
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $city = City::find($id);
                    if(strlen($id) == 0) {
                        $city = new City;
                    }
                    $city->fill($param);
                    $city->save();
                } catch(\Exception $e) {
                    $errCode = 4245;
                    $errMsg = $e->getMessage();
                }
            }

            if($errCode == 0) {
                DB::commit();
                $msg = " Success insert";
                if(strlen($id) > 0)
                    $msg = " Success modified";
                cmsg::add('success', $name.$msg);
                sleep(5);
                return redirect(route('admin.master.kota'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        //$data['country'] = $country;
        $data['province'] = $province;
        $data['name'] = $name;
        //$data['country_id'] = $country_id;
        $data['province_id'] = $province_id;
        $data['code'] = $code;
        $data['area_code'] = $area_code;
        $data['is_posted'] = $is_posted;
        $title = 'Tambah Kota';
        if (strlen($id) > 0) {
            $title = 'Update Kota';
        }
        $data['title'] = $title;
        return view('admin.master.kota.detail', $data);
    }


}