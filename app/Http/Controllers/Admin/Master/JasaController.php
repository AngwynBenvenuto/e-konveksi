<?php

namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use Lintas\helpers\cmsg;
use Illuminate\Support\Arr;
use App\Models\DeliveryService;
use DB;

class JasaController extends MasterController {
    public function index() {
        return view('admin.master.jasa.index');
    }
    
    public function show() {
        $errCode = 0;
        $errMsg = "";
        $data = array();

        if($errCode == 0) {
            $serv = DeliveryService::where('status','>', 0)->get();
            if($serv != null) {
                $servs = $serv->toArray();
                foreach($servs as $row){
                    $data[] = array(
                        'id' => Arr::get($row, 'id'),
                        'name' => Arr::get($row, 'name'),
                        'description' => Arr::get($row, 'description'),
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
        $errCode = 0;
        $errMsg = '';
        $name = '';
        $description = '';
        $request = array_merge($_GET, $_POST);

        if(strlen($id) > 0) {
            try{
                $modelService = DeliveryService::find($id);
                if($modelService != null) {
                    $servs = $modelService->toArray();
                    $name = Arr::get($servs, 'name');
                    $description = Arr::get($servs, 'description');
                } else {
                    $errCode = 454;
                    $errMsg = "Jasa not found";
                }
            } catch(\Exception $ex) {
                $errCode++;
                $errMsg = "Error ".$ex->getMessage();
            }
        }

        if($request != null) {
            $name = Arr::get($request, 'name');
            $description = Arr::get($request, 'description');
            
            if($errCode == 0) {
                if(strlen($name) == 0) {
                    $errCode = 145;
                    $errMsg = "Name required";
                }
            }

            DB::beginTransaction();
            if($errCode == 0){
                $param = array();
                $param['name'] = $name;
                $param['description'] = $description;
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $serv = DeliveryService::find($id);
                    if(strlen($id) == 0) {
                        $serv = new DeliveryService;
                    }
                    $serv->fill($param);
                    $serv->save();
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
                return redirect(route('admin.master.jasa'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        $data['name'] = $name;
        $data['description'] = $description;
        $title = 'Tambah Jasa';
        if(strlen($id) > 0) {
            $title = 'Update Jasa';
        }
        $data['title'] = $title;
        return view('admin.master.jasa.detail', $data);
    }
    
}