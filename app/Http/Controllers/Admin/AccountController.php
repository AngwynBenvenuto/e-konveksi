<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Auth, Hash;
use Lintas\helpers\cmsg;
use Lintas\libraries\CUser;
use Lintas\libraries\CData;
use Lintas\libraries\CUserLogin;
use Illuminate\Support\Arr;
use Lintas\libraries\CApi\Exception as ApiException;

class AccountController extends AdminController {
    public function __construct(){
    }


    public function systemRate() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = array_merge($_GET, $_POST);

        if($request != null) {
            $rate = Arr::get($request, 'rate');
            if($err_code == 0) {
                if(strlen($rate) == 0) {
                    $err_code = 14;
                    $err_message = "Rate required";
                }
            }

            if($err_code == 0) {
                $param = array();
                $param['app_name'] = 'E-Konveksi';
                $param['app_code'] = 'ek';
                $param['app_rate'] = $rate;

                try {

                } catch(\Exception $e) {
                    $err_code = 577;
                    $err_message = '[FATAL ERROR] ' . $e->getMessage();
                }
            }


            if ($err_code == 0) {
                cmsg::add('success', __('Rate telah diperbaharui.'));
            } else {
                cmsg::add('error', $err_message);
            }
        }

       return view('admin.setting.system');
    }

    public function changePassword() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = array_merge($_GET, $_POST);

        if(Auth::guard('admin')->check()) {
            $user_id = Auth::guard('admin')->user()->id;
            $ikm_id = Auth::guard('admin')->user()->ikm_id;
        }

        if($request != null) {
            $current = Arr::get($request, 'password');
            $new = Arr::get($request, 'new_password');
            $confirm = Arr::get($request, 'password_confirmation');

            if($err_code == 0) {
                if(strlen($current) == 0) {
                    $err_code = 14;
                    $err_message = "Password lama required";
                } else if(strlen($new) == 0) {
                    $err_code = 15;
                    $err_message = "Password baru required";
                } else if(strlen($confirm) == 0) {
                    $err_code = 16;
                    $err_message = "Konfirm password required";
                }
            }

            if($err_code == 0) {
                $options['user_id'] = $user_id;
                $options['ikm_id'] = $ikm_id;
                $options['current_password'] = $password;
                $options['password'] = $new;
                $options['confirm_password'] = $confirm;

                $result_change = false;
                try {
                    $result_change = CUser::changePassword($options);
                } catch (ApiException $ex) {
                    $err_code = 1454;
                    $err_message = $ex->getMessage();
                } catch (\Exception $ex) {
                    $err_code = 577;
                    $err_message = '[FATAL ERROR] ' . $ex->getMessage();
                }
            }

            if ($err_code == 0) {
                cmsg::add('success', __('Password anda berhasil diperbarui'));
            } else {
                cmsg::add('error', $err_message);
            }
        }

        return view('admin.setting.change_password');
    }


    public function profile() {
        $data = array();
        $errCode = 0;
        $errMessage = "";

        $memberLogin = CUserLogin::get();
        $member_id = Arr::get($memberLogin, 'id');
        $name = Arr::get($memberLogin, 'name');
        $name_display = Arr::get($memberLogin, 'name_display');
        $email = Arr::get($memberLogin, 'email');
        $tanggal_lahir = Arr::get($memberLogin, 'birthdate');
        $jenis_kelamin = Arr::get($memberLogin, 'gender');
        $nomor_telepon = Arr::get($memberLogin, 'phone');
        $province_id = Arr::get($memberLogin, 'province_id');
        $city_id = Arr::get($memberLogin, 'city_id');
        $address = Arr::get($memberLogin, 'address');
        $image_url =  Arr::get($memberLogin, 'image_url');

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $name = Arr::get($request, 'name');
            $name_display = Arr::get($request, 'name_display');
            $tanggal_lahir = Arr::get($request, 'tanggal_lahir');
            $jenis_kelamin = Arr::get($request, 'jenis_kelamin');
            $nomor_telepon = Arr::get($request, 'nomor_telepon');
            $province = Arr::get($request, 'province');
            $city = Arr::get($request, 'city');
            $address = Arr::get($request, 'address');
            $files = $_FILES;

            if($errCode == 0) {
                $options = array();
                $options['id'] = $member_id;
                $options['name'] = $name;
                $options['name_display'] = $name_display;
                $options['birthdate'] = $tanggal_lahir;
                $options['phone'] = $nomor_telepon;
                $options['province_id'] = $province;
                $options['city_id'] = $city;
                $options['address'] = $address;
                $options['gender'] = $jenis_kelamin;
                $options['files'] = $files;

                try {
                    $response = CUser::updateProfile($options);
                    $response = CUser::updateProfileImage($options);
                } catch(ApiException $ex) {
                    $errCode++;
                    $errMessage = $ex->getMessage();
                } catch(\Exception $ex) {
                    $errCode++;
                    $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
                }
            }

            if($errCode > 0) {
                cmsg::add('error', $errMessage);
            } else {
                cmsg::add('success', 'Update profile '.$name.' success');

                $memberLogin = CUserLogin::get();
                $member_id = Arr::get($memberLogin, 'id');
                $name = Arr::get($memberLogin,'name');
                $name_display = Arr::get($memberLogin,'name_display');
                $email = Arr::get($memberLogin,'email');
                $tanggal_lahir = Arr::get($memberLogin,'birthdate');
                $jenis_kelamin = Arr::get($memberLogin,'gender');
                $nomor_telepon = Arr::get($memberLogin,'phone');
                $province_id = Arr::get($memberLogin, 'province_id');
                $city_id = Arr::get($memberLogin, 'city_id');
                $address = Arr::get($memberLogin, 'address');
                $image_url = Arr::get($memberLogin,'image_url');
            }
        }

        $data['name'] = $name;
        $data['name_display'] = $name_display;
        $data['tanggal_lahir'] = $tanggal_lahir;
        $data['province'] = CData::getProvince(array());
        $data['province_id'] = $province_id;
        $data['city'] = CData::getCity(array('province_id' => $province_id));
        $data['city_id'] = $city_id;
        $data['address'] = $address;
        $data['nomor_telepon'] = $nomor_telepon;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['email'] = $email;
        $data['image_url'] = $image_url;
        return view('admin.setting.profile', $data);
    }


    // public function chat() {
    //     $data = array();
    //     $data['title'] = "Chat";
    //     return view('admin.ikm.chat', $data);
    // }

}
