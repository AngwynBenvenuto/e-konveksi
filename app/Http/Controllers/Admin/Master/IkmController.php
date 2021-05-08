<?php

namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use App\Models\Ikm;
use App\Models\User;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use Lintas\libraries\CData;

class IkmController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.master.ikm.index');
    }

    public function ikmList() {
        $errCode = 0;
        $errMsg = "";
        $data = array();

        if($errCode == 0) {
            $modelIkm = Ikm::where('status', '>', 0)->get();
            if($modelIkm != null) {
                $ikm = $modelIkm->toArray();
                if($ikm != null) {
                    foreach($ikm as $row) {
                        $data[] = array(
                            'id' => Arr::get($row, 'id'),
                            'name' => Arr::get($row, 'name'),
                            'email' => Arr::get($row, 'email'),
                            'address' => Arr::get($row, 'address'),
                            'birthdate' => Arr::get($row, 'birthdate'),
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

    public function ikmShow($id = null) {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $province = '';
        $city = '';
        $district = '';

        if(strlen($id) > 0) {
            $modelIkm = Ikm::where('status', '>', 0)
                            ->whereId($id)
                            ->first();
            if($modelIkm != null) {
                $ikm = $modelIkm->toArray();
                if($ikm != null) {
                    $province_id = Arr::get($ikm, 'province_id');
                    if($province_id != null)
                        $province = \App\Models\Province::find($province_id)->name;

                    $city_id = Arr::get($ikm, 'city_id');
                    if($city_id != null)
                        $city = \App\Models\City::find($city_id)->name;

                    $district_id = Arr::get($ikm, 'district_id');
                    if($district_id != null)
                        $district = \App\Models\District::find($district_id)->name;
                    
                    $img = Arr::get($ikm, 'image_url');
                    if($img == null) {
                        $img = asset('public/img/no_image.png');
                    }
                    $gender = Arr::get($ikm, 'gender');
                    $gender_text = $gender == "1" ? "Laki-laki" : "Perempuan";
                    $data = array(
                        'id' => Arr::get($ikm, 'id'),
                        'name' => Arr::get($ikm, 'name'),
                        'name_display' => Arr::get($ikm, 'name_display'),
                        'image_url' => $img,
                        'code' => Arr::get($ikm, 'code'),
                        'province' => $province,
                        'city' => $city,
                        'district' => $district,
                        'gender' => $gender_text,
                        'address' => Arr::get($ikm, 'address'),
                        'phone' => Arr::get($ikm, 'phone'),
                        'qr_code' => Arr::get($ikm, 'qr_code'),
                        'created_at' => (string)Arr::get($ikm, 'created_at'),
                        'updated_at' => (string)Arr::get($ikm, 'updated_at'),
                        'status' => Arr::get($ikm, 'status'),
                    );
                }
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $data;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);
    }

    public function create() {
        return $this->edit();
    }

    public function edit($id = null) {
        $data = array();
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';
        $name = '';
        $name_display = '';
        $province_id = '';
        $city_id = '';
        $districts_id = '';
        $email = '';
        $address = '';
        $phone = '';
        $image_url = '';
        $gender = '';
        $code = '';
        $qr_code = '';
        $birthdate = '';
        $province = CData::getProvince(array());
        $city = CData::getCity(array());
        $districts = CData::getDistricts(array());

        if(strlen($id) > 0) {
            try{
                $modelIkm = Ikm::find($id);
                if($modelIkm != null) {
                    $ikm = $modelIkm->toArray();
                    if(count($ikm) > 0) {
                        $name = Arr::get($ikm, 'name');
                        $name_display = Arr::get($ikm, 'name_display');
                        $province_id = Arr::get($ikm, 'province_id');
                        $city_id = Arr::get($ikm, 'city_id');
                        $districts_id = Arr::get($ikm, 'districts_id');
                        $email = Arr::get($ikm, 'email');
                        $address = Arr::get($ikm, 'address');
                        $phone = Arr::get($ikm, 'phone');
                        $image_url = Arr::get($ikm, 'image_url');
                        $birthdate = Arr::get($ikm, 'birthdate');
                        $gender = Arr::get($ikm, 'gender');
                        $code = Arr::get($ikm, 'code');
                        $qr_code = Arr::get($ikm, 'qr_code');
                    }
                } else {
                    $errCode = 454;
                    $errMsg = "Ikm not found";
                }
            } catch(\Exception $ex) {
                $errCode++;
                $errMsg = "Error ".$ex->getMessage();
            }
        }

        if($request != null) {
            $name = Arr::get($request, 'name');
            $name_display = Arr::get($request, 'name_display');
            $province_id = Arr::get($request, 'province_id');
            $city_id = Arr::get($request, 'city_id');
            $districts_id = Arr::get($request, 'districts_id');
            $email = Arr::get($request, 'email');
            $address = Arr::get($request, 'address');
            $phone = Arr::get($request, 'phone');
            $image_url = Arr::get($request, 'image_url');
            $birthdate = Arr::get($request, 'birthdate');
            $gender = Arr::get($request, 'gender');
            $qr_code = Arr::get($request, 'qr_code');
            $code = Arr::get($request, 'code');

            if($errCode == 0) {
                if(strlen($name) == 0) {
                    $errCode = 144;
                    $errMsg = "Name harus diisi";
                }
                else if(strlen($name_display) == 0) {
                    $errCode = 145;
                    $errMsg = "Name display harus diisi";
                }
                else if(strlen($email) == 0) {
                    $errCode = 146;
                    $errMsg = "Email harus diisi";
                }
                else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errCode = 1577;
                    $errMsg = 'Email is not valid';
                }
                else if(strlen($gender) == 0) {
                    $errCode = 147;
                    $errMsg = "Jenis kelamin harus dipilih";
                }
                else if(strlen($phone) == 0) {
                    $errCode = 148;
                    $errMsg = "Telepon harus diisi";
                }
            }

            if($errCode == 0) {
                DB::beginTransaction();

                try{
                    $param = array();
                    if(strlen($code) == 0) {
                        $param['code'] = utils::generateIkm($name);
                    }
                    $param['name'] = $name;
                    $param['name_display'] = $name_display;
                    $param['email'] = $email;
                    $param['address'] = $address;
                    $param['birthdate'] = $birthdate;
                    $param['gender'] = $gender;
                    $param['province_id'] = $province_id;
                    $param['city_id'] = $city_id;
                    $param['phone'] = $phone;
                    if(strlen($id) > 0) {
                        $param['id'] = $id;
                    }

                    $model = Ikm::find($id);
                    if(strlen($id) == 0) {
                        $model = new Ikm;
                    }
                    $model->fill($param);
                    $saved = $model->save();
                    if($saved) {
                        try {
                            $ikm_dt = array();
                            $ikm_dt['ikm_id'] = $model->id;
                            $ikm_dt['username'] = $name;
                            $ikm_dt['email'] = $email;
                            $ikm_dt['password'] = bcrypt('12345');

                            $model_user = User::where('ikm_id', '=', $model->id)->first();
                            if($model_user == null) {
                                $model_user = new User;
                            }
                            $model_user->fill($ikm_dt);
                            $model_user->save();
                        } catch(\Exception $e) {
                            $errCode = 4245;
                            $errMsg = $e->getMessage();
                        }
                    }
                } catch(\Exception $e) {
                    $errCode = 1111;
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
                return redirect(route('admin.master.ikm'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        $data['name'] = $name;
        $data['name_display'] = $name_display;
        $data['email'] = $email;
        $data['code'] = $code;
        $data['qr_code'] = $qr_code;
        $data['province_id'] = $province_id;
        $data['province'] = $province;
        $data['city_id'] = $city_id;
        $data['city'] = $city;
        $data['districts_id'] = $districts_id;
        $data['districts'] = $districts;
        $data['gender'] = $gender;
        $data['birthdate'] = $birthdate;
        $data['phone'] = $phone;
        $data['image_url'] = $image_url;
        $data['address'] = $address;
        $title = 'Tambah Ikm';
        if (strlen($id) > 0) {
            $title = 'Update Ikm';
        }
        $data['title'] = $title;
        return view('admin.master.ikm.detail', $data);
    }

    public function delete($id = null) {
        $data = array();
        $errCode =0 ;
        $errMsg = "";
        $request = array_merge($_GET, $_POST);
        
        if($errCode == 0) {
            if(strlen($id) == 0) {
                $errCode = 24;
                $errMsg = "ID required";
            }
        }

        if($errCode == 0) {
            try{
                $param = array();
                if(strlen($id) > 0) {
                    $param['id'] = $id;
                }

                $modelIkm = Ikm::find($id);
                if($modelIkm != null) {
                    $modelIkm->delete();
                }
            } catch(\Exception $e) {
                $errCode = 4245;
                $errMsg = $e->getMessage();
            }

            if($errCode == 0) {
                return redirect(route('admin.master.ikm'));
            } else {
                cmsg::add('error', $errMsg);
            }
        } 
    }
}
