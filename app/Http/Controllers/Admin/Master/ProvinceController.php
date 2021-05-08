<?php

namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Country;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\cmsg;

class ProvinceController extends MasterController {
    public function index() {
        return view('admin.master.provinsi.index');
    }

    public function show() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $provinsis = "";

        if($errCode == 0) {
            $provinsis = Province::where('status','>', 0)
                            //->whereRaw('country_id = 94')
                            //->
                            ->orderByRaw("id asc")
                            ->get();
            if($provinsis != null) {
                $provinsi = $provinsis->toArray();
                foreach($provinsi as $row){
                    $name = Arr::get($row, 'name');
                    // $country_id = Arr::get($row, 'country_id');
                    // $country = Arr::get($row, 'country');
                    // if($country != null)
                    //     $country_name = Arr::get($country, 'name');
                    $data[] = array(
                        'id' => Arr::get($row, 'id'),
                        'name' => $name,
                        //'country' => $country_name,
                        'created_at' => (string)Arr::get($row, 'created_at'),
                        'updated_at' => (string)Arr::get($row, 'updated_at'),
                        'status' => Arr::get($row, 'status'),

                    );
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
        $name = '';
        $country_id = '';
        $code = '';
        $zone = '';
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';

        if(strlen($id) > 0) {
            try{
                $modelProvinsi = Province::find($id);
                if($modelProvinsi != null) {
                    $provinsi = $modelProvinsi->toArray();
                    $name = Arr::get($provinsi, 'name');
                    //$country_id = Arr::get($provinsi, 'country_id');
                    $code = Arr::get($provinsi, 'code');
                    $zone = Arr::get($provinsi, 'zone');
                } else {
                    $errCode = 455;
                    $errMsg = "Provinsi not found.";
                }
            } catch(\Exception $ex) {
                $errCode = 520;
                $errMsg = $ex->getMessage();
            }
        }


        if($request != null) {
            $name = Arr::get($request, 'name');
            //$country_id = Arr::get($request, 'country_id');
            $code = Arr::get($request, 'code');
            $zone = Arr::get($request, 'zone');
            if ($errCode == 0) {
                if (strlen($name) == 0) {
                    $errCode = 134;
                    $errMsg = 'Nama required';
                }
            }

            DB::beginTransaction();
            if($errCode == 0){
                $param = array();
                $param['country_id'] = $country_id;
                $param['name'] = $name;
                $param['code'] = $code;
                $param['zone'] = $zone;
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $province = Province::find($id);
                    if(strlen($id) == 0) {
                        $province = new Province;
                    }
                    $province->fill($param);
                    $province->save();
                } catch(\Exception $e) {
                    $errCode = 4245;
                    $errMsg = $e->getMessage();
                }
            }

            if($errCode == 0) {
                DB::commit();
                $msg = " Success insert";
                if(strlen($id) > 0) {
                    $msg = " Success modified";
                }
                cmsg::add('success', $name.$msg);
                sleep(5);
                return redirect(route('admin.master.provinsi'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        //$data['country'] = $country;
        $data['name'] = $name;
        //$data['country_id'] = $country_id;
        $data['code'] = $code;
        $data['zone'] = $zone;
        $title = 'Tambah Provinsi';
        if (strlen($id) > 0) {
            $title = 'Update Provinsi';
        }
        $data['title'] = $title;
        return view('admin.master.provinsi.detail', $data);
    }

}