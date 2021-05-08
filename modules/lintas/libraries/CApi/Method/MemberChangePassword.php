<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use App\Models\Penjahit;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;

class MemberChangePassword extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $request = $this->request();
        $date = date("Y-m-d H:i:s");
        $member_id = Arr::get($request, 'member_id');
        $current_password = Arr::get($request, 'current_password');
        $password = Arr::get($request, 'password');
        $confirm_password = Arr::get($request, 'confirm_password');
        $passthru = Arr::get($request, 'passthru', "");
        $password1 = cdbutils::get_value("select password from penjahit where id =".($member_id)." and status > 0");
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
            $modelMember = Penjahit::where('status', '>', 0)->whereId($member_id)->first();
            if($modelMember != null){
                $memberCurrentPassword=$modelMember->password;
                if(strlen($memberCurrentPassword)==0){
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
                $is_exists = cdbutils::get_value('select count(*) from penjahit where id = ' . ($member_id) . ' and password = (' . bcrypt($current_password) . ')');
                if ($is_exists == 0 && $passthru == "") {
                    $err_code++;
                    $err_message = "Kata sandi lama yg dimasukkan salah";
                }

            }
        }

        if ($err_code == 0) {
            try {
                $data_member = array(
                    'password' => bcrypt($password),
                    'updated_at' => $date,
                );
                Penjahit::whereId($member_id)->update($data_member);
                $data = $data_member;
            } catch (\Exception $ex) {
                $err_code = 2000;
                $err_message = 'Error '.$ex->getMessage();
            }
        }

        if ($err_code == 0) {
            $data_member = cdbutils::get_row('select * from penjahit where id = '.($member_id));
            $param = array(
                'user_id' => null,
                'before' => $data_member,
                'after' => $data,
            );
            //clog::activity($param, 'MemberChangePassword', __("Change Password Member [" . $data_member->name . "] Successfully Updated !"));
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}