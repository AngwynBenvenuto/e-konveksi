<?php
namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Ikm;
use Lintas\helpers\cmsg;
use Auth, Hash, DB;
use Illuminate\Support\Arr;

class UserController extends AdminController {
    public function index() {
        return view('admin.setting.access.user.index');
    }

    public function show() {
        $errCode = 0;
        $errMsg = "";
        $data = array();

        if($errCode == 0) {
            $users = User::with(['ikm','roles'])->where('status','>', '=')->get();
            if($users != null) {
                foreach($users as $row) {
                    $data[] = array(
                        'id' => $row->id,
                        // 'first_name' => $row->first_name,
                        // 'last_name' => $row->last_name,
                        'username' => $row->username,
                        'email' => $row->email,
                        'ikm' => $row->ikm_id == null ? null : $row->ikm->name,
                        //'role' => $row->role_id == null ? null : $row->roles->first()->name,
                        'note' => $row->note,
                        'created_at' => (string)$row->created_at,
                        'updated_at' => (string)$row->updated_at,
                        'status' => ($row->status == 1 ? "Active" : "Nonactive"),
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
        //$role = Role::where('status', '>', 0)->get()->toArray();
        $ikm = Ikm::where('status', '>', 0)->get()->toArray();

        $ikm_id = '';
        //$role_id = '';
        $username = '';
        $email = '';
        $password = '';
        $note = '';
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';

        if(strlen($id) > 0) {
            try{
                $modelUser = User::find($id);
                if($modelUser != null) {
                    $user = $modelUser->toArray();
                    $ikm_id = Arr::get($user, 'ikm_id');
                    //$role_id = Arr::get($user, 'role_id');
                    $username = Arr::get($user, 'username');
                    //$first_name = Arr::get($user, 'first_name');
                    //$nama_belakang = Arr::get($user, 'last_name');
                    $password = Arr::get($user, 'password');
                    $email = Arr::get($user, 'email');
                    $note = Arr::get($user, 'note');
                } else {
                    $errCode = 1414;
                    $errMsg = "User not found.";
                }
            } catch(\Exception $ex) {
                $errCode = 520;
                $errMsg = $ex->getMessage();
            }
        } 

        if($request != null) {
            $ikm_id = Arr::get($request, 'ikm_id');
            //$role_id = Arr::get($request, 'role_id');
            $username = Arr::get($request, 'username');
            //$nama_depan = Arr::get($request, 'first_name');
            //$nama_belakang = Arr::get($request, 'last_name');
            $password1 = Arr::get($request, 'password');
            $email = Arr::get($request, 'email');
            $note = Arr::get($request, 'note');
            if ($errCode == 0) {
                if (strlen($username) == 0) {
                    $errCode = 134;
                    $errMsg = 'Nama required';
                }
                else if(strlen($email) == 0) {
                    $errCode = 135;
                    $errMsg = 'Email required';
                }
                else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errCode = 136;
                    $errMsg = 'Email is not valid';
                }
                // else if(strlen($password1) > 0) {
                //     $errCode = 137;
                //     $errMsg = 'Password required';
                // }
            }      
            
            DB::beginTransaction();
            if($errCode == 0){
                $param = array();
                $param['ikm_id'] = $ikm_id;
                //$param['role_id'] = $role_id;
                $param['username'] = $username;
                $param['email'] = $email;
                $param['note'] = $note;
                if(strlen($password1) == 0) {
                    $param['password'] = bcrypt('12345');
                } else {
                    if(strlen($id) > 0 && strlen($password1) > 0) {
                        $param['password'] = bcrypt($password1);
                    }
                }
                
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $user = User::find($id);
                    if(strlen($id) == 0) {
                        $user = new User;
                    }
                    $user->fill($param);
                    $user->save();
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
                cmsg::add('success', $username.$msg);
                return redirect(route('admin.setting.user'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }

        $data['ikm'] = $ikm;
        //$data['role'] = $role;
        $data['ikm_id'] = $ikm_id;
        //$data['role_id'] = $role_id;
        $data['username'] = $username;
        $data['password'] = $password;
        $data['email'] = $email;
        $data['note'] = $note;
        $title = 'Tambah User';
        if (strlen($id) > 0) {
            $title = 'Update User';
        }
        $data['title'] = $title;
        return view('admin.setting.access.user.detail', $data);
    }
    
    
}