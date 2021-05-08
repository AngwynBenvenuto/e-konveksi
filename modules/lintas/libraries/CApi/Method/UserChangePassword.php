<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use App\Models\User;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;

class UserChangePassword extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $request = $this->request();
        $date = date("Y-m-d H:i:s");
        $user_id = Arr::get($request, 'user_id');
        $ikm_id = Arr::get($request, 'ikm_id');
        $current_password = Arr::get($request, 'current_password');
        $password = Arr::get($request, 'password');
        $confirm_password = Arr::get($request, 'confirm_password');
        $passthru = Arr::get($request, 'passthru', "");
        $password1 = cdbutils::get_value("select password from user where id =".($user_id)." and status > 0");
        $first_password=0;

        if($err_code == 0) {
            if(strlen($current_password) == 0) {
                $err_code++;
                $err_message = __('Password harus diisi');
            }
            else if(strlen($password) == 0) {
                $err_code++;
                $err_message = __('Password Baru harus diisi');
            }
            else if(strlen($confirm_password) == 0) {
                $err_code++;
                $err_message = __('Konfirm Password harus diisi');
            }
            else if ($password != $confirm_password) {
                $err_code++;
                $err_message = "Password dan Konfirmasi Password kata sandi tidak sesuai";
            }
        }

        if ($err_code == 0) {
            $modelUser = User::where('status', '>', 0)->whereId($user_id)->first();
            if($modelUser != null){
                $userCurrentPassword=$modelUser->password;
                if(strlen($userCurrentPassword)==0){
                    $first_password=1;
                }
            }
        }

        if ($err_code == 0) {
            if($first_password==0 && !empty($password1)){
                if(strlen($current_password)==0){
                    $err_code++;
                    $err_message ='Kata sandi lama harus diisi';
                }
            }
            else if($first_password==0 && !empty($password1)){
                $is_exists = cdbutils::get_value('select count(*) from user where id = ' . ($user_id) . ' and password = (' . bcrypt($current_password) . ')');
                if ($is_exists == 0 && $passthru == "") {
                    $err_code++;
                    $err_message = "Kata sandi lama yg dimasukkan salah";
                }

            }
        }

        if ($err_code == 0) {
            try {
                $data_user = array(
                    'password' => bcrypt($password),
                    'updated_at' => $date,
                );
                User::whereId($user_id)->update($data_user);
                $data = $data_user;
            } catch (\Exception $ex) {
                $err_code = 2000;
                $err_message = 'Error '.$ex->getMessage();
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}