<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Arr;
use Lintas\helpers\cdbutils;
use Lintas\helpers\cmsg;
use DB;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPasswordForm($token) {
        $err_code = 0;
        $err_message = "";
        $penjahit_id = "";
        $email = "";
        $new_password = "";
        $confirm_password = "";

        $request = array_merge($_GET, $_POST);
        
        if($err_code == 0) {
            $data_request_password = cdbutils::get_row("SELECT * FROM penjahit_password_resets WHERE token = '{$token}' AND status > 0");
            if ($data_request_password) {
                $data_penjahit = cdbutils::get_row("SELECT * FROM penjahit WHERE id = '{$data_request_password->penjahit_id}' AND status > 0");
                if (strtotime(date('Y-m-d H:i:s')) < $data_request_password->expired_date) {
                    $err_code++;
                    $err_message = "Masa berlaku token Anda telah habis. Lakukan reset password kembali!";
                }
                if ($data_request_password->is_done > 0) {
                    $err_code++;
                    $err_message = "Link sudah pernah digunakan";
                }
                if (empty($data_penjahit)) {
                    $err_code++;
                    $err_message = "Data User tidak ditemukan";
                }

                if($err_code == 0) {
                    $penjahit_id = $data_penjahit->id;
                    $email = $data_penjahit->email;
                }
            } else {
                $err_code = 1113;
                $err_message = "Token tidak ditemukan";
            }
        }

        if($request != null) {
            $new_password = Arr::get($request, 'password');
            $confirm_password = Arr::get($request, 'password_confirmation');
            if($err_code == 0) {
                if(strlen($new_password) == 0) {
                    $err_code = 11;
                    $err_message = "Password baru required";
                }
                else if(strlen($confirm_password) == 0) {
                    $err_code = 12;
                    $err_message = "Konfirmasi password required";
                }
                else if($new_password != $confirm_password) {
                    $err_code = 13;
                    $err_message = "Password baru dan konfirmasi tidak sama";
                }
            }

            if($err_code == 0) {
                try {
                    DB::table("penjahit")
                        ->where('id', $penjahit_id)
                        ->update(array('password' => bcrypt($new_password)));
                    DB::table("penjahit_password_resets")
                        ->where('id', $data_request_password->id)
                        ->update(array('is_done' => 1));
                } catch (\Exception $e) {
                    $err_code = 1444;
                    $err_message = $e->getMessage();
                }
            }

            
            if($err_code > 0) {
                cmsg::add('error', $err_message);
            } else {
                cmsg::add('success', 'Reset password success, now you can login.');
                sleep(10);
                redirect()->route('login');
            }
        }


        $data['email'] = $email;
        return view('auth.passwords.reset', $data);
    }
}
