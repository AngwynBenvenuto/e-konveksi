<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use Auth;
use Lintas\libraries\CMember;
use Lintas\libraries\CData;
use Lintas\libraries\CMemberLogin;
use Lintas\libraries\CApi\Exception as ApiException;
use App\Models\Penjahit;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->update();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $data = array();
        $errCode = 0;
        $errMessage = "";
        
        $memberLogin = CMemberLogin::get();
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
                    $response = CMember::updateProfile($options);
                    $response = CMember::updateProfileImage($options);
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
                
                //refresh
                $sess = CMemberLogin::refreshSession();
                $memberLogin = CMemberLogin::dataUser($sess);
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
            }
        }

        $data['name'] = $name;
        $data['name_display'] = $name_display;
        $data['tanggal_lahir'] = $tanggal_lahir;
        $data['nomor_telepon'] = $nomor_telepon;
        $data['province'] = CData::getProvince(array());
        $data['province_id'] = $province_id;
        $data['city'] = CData::getCity(array('province_id' => $province_id));
        $data['city_id'] = $city_id;
        $data['address'] = $address;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['email'] = $email;
        $data['image_url'] = $image_url;
        $data['title'] = "Profile";
        return view('front.user.account', $data);
    }

    public function changePassword() {
        $err_code = 0;
        $err_message = "";
        $data = array();
        $params = array();
        $options = array();
        $member_login_id = '';
        $request = array_merge($_GET, $_POST);
        
        if(Auth::check()) {
            $member_login_id = CMemberLogin::get('id');
        }

        if($request != null) {
            $password = Arr::get($request, 'password');
            $new = Arr::get($request, 'new_password');
            $confirm = Arr::get($request, 'password_confirmation');
            
            $options['member_id'] = $member_login_id;
            $options['current_password'] = $password;
            $options['password'] = $new;
            $options['confirm_password'] = $confirm;
            
            $dataupdate = array();
            $dataupdate['updated_at'] = date("Y-m-d H:i:s");
            
            $result_change = false;
            try {
                $result_change = CMember::changePassword($options);
            } catch (ApiException $ex) {
                $err_code = 1454;
                $err_message = $ex->getMessage();
            } catch (\Exception $ex) {
                $err_code = 577;
                $err_message = '[FATAL ERROR] ' . $ex->getMessage();
            }
            
            if ($err_code == 0) {
                Penjahit::whereId($member_login_id)->update($dataupdate);
                cmsg::add('success', __('Password anda berhasil diperbarui, jangan lupa menggunakan password baru anda untuk login kembali'));
            } else {
                cmsg::add('error', $err_message);
            }
            
        }

        $data['title'] = "Ubah Password";
        return view('front.user.change_password', $data);
    }
    

}
