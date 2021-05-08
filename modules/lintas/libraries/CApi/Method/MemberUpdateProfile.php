<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use App\Models\Penjahit;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;

class MemberUpdateProfile extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $date = date("Y-m-d H:i:s");
        $request = $this->request();
        $member_id = Arr::get($request, 'id');
        $name = Arr::get($request, 'name');
        $name_display = Arr::get($request, 'name_display');
        $email = Arr::get($request, 'email');
        $nomor_telepon = Arr::get($request, 'phone');
        $tanggal_lahir = Arr::get($request, 'birthdate');
        $jenis_kelamin = Arr::get($request, 'gender');
        $province_id = Arr::get($request, 'province_id');
        $city_id = Arr::get($request, 'city_id');
        $address = Arr::get($request, 'address');
        $bank = Arr::get($request, 'bank');
        $account_holder = Arr::get($request, 'account_holder');
        $account_number = Arr::get($request, 'acoount_number');

        if ($err_code == 0) {
            if (strlen($member_id) == 0) {
                $err_code = 1345;
                $err_message = 'Member is required';
            }
        }

        if ($err_code == 0) {
            if (strlen($name) == 0) {
                $err_code = 1346;
                $err_message = 'Name is required';
            }
        }

        if ($err_code == 0) {
            DB::beginTransaction();
            try {
                $data_member = array(
                    'name' => $name,
                    'name_display' => $name_display,
                    'phone' => $nomor_telepon,
                    'birthdate' => $tanggal_lahir,
                    'gender' => $jenis_kelamin,
                    'updated_at' => $date,
                );
                if (strlen($account_holder) > 0) {
                    $data_member['account_holder'] = $account_holder;
                }
                if (strlen($account_number) > 0) {
                    $data_member['account_number'] = $account_number;
                }
                if (strlen($address) > 0) {
                    $data_member['address'] = $address;
                }
                if (strlen($province_id) > 0) {
                    $data_member['province_id'] = $province_id;
                }
                if (strlen($city_id) > 0) {
                    $data_member['city_id'] = $city_id;
                }

                Penjahit::whereId($member_id)->update($data_member);
                $data = $data_member;
            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Update Profile Not Succesfully ' . $e->getMessage();
            }
        }

        $email = '';
        if ($err_code == 0) {
            $data_member = cdbutils::get_row('select * from penjahit where id='.($member_id));
            $email = $data_member->email;
            $param = array(
                'user_id' => null,
                'before' => $data_member,
                'after' => $data,
            );
        }

        if ($err_code == 0) {
            DB::commit();
            //clog::activity($param, 'UpdateProfile', __("Update Profile Member [".$data_member->name."] Successfully Updated !"));
        } else {
            DB::rollback();
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}