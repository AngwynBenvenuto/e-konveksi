<?php
namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\cmsg;

class RoleController extends AdminController {
    public function index() {
        return view('admin.setting.access.role.index');
    }

    public function show() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
            
        if($errCode == 0) {
            $roles = Role::where('status', '>', 0)->get();
            if($roles != null) {
                $role = $roles->toArray();
                if($role != null) {
                    foreach($role as $row) {
                        $data[] = array(
                            'id' => Arr::get($row, 'id'),
                            'name' => Arr::get($row, 'name'),
                            'description' => Arr::get($row, 'description'),
                            'created_at' => (string)Arr::get($row, 'created_at'),
                            'updated_at' => (string)Arr::get($row, 'updated_at'),
                            'status' => (Arr::get($row, 'status') == 1 ? "Active" : "Nonactive"),
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

        $name = '';
        $description = '';
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';

        if(strlen($id) > 0) {
            try{
                $modelRole = Role::find($id);
                if($modelRole != null) {
                    $role = $modelRole->toArray();
                    $name = Arr::get($role, 'name');
                    $description = Arr::get($role, 'description');
                } else {
                    $errCode = 141;
                    $errMsg = "Role not found.";
                }
            } catch(\Exception $ex) {
                $errCode = 520;
                $errMsg = $ex->getMessage();
            }
        } 

        if($request != null) {
            $name = Arr::get($request, 'name');
            $description = Arr::get($request, 'description');
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
                $param['description'] = $description;
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $role = Role::find($id);
                    if(strlen($id) == 0) {
                        $role = new Role;
                    }
                    $role->fill($param);
                    $role->save();
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
                return redirect(route('admin.master.role'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        $data['name'] = $name;
        $data['description'] = $description;
        $title = 'Tambah Role';
        if (strlen($id) > 0) {
            $title = 'Update Role';
        }
        $data['title'] = $title;
        return view('admin.setting.access.role.detail', $data);
    }

}