<?php
namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, Password, DB, Hash;
use Illuminate\Support\Facades\Mail;
use Lintas\helpers\cdbutils;
use App\Mail\ForgotPassword;

class ResetPasswordController extends Controller
{
    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function requestChangePassword($token = null) {
        $err_code = 0;
        $err_message = "";
        $email = "";
        $content = "";
        $path = "";
        $data = array();
        $org_name = env('APP_NAME');

        DB::beginTransaction();
        $data_request_password = cdbutils::get_row("SELECT * FROM users_password_resets WHERE token = '{$token}' AND status > 0");
        if ($data_request_password) {
            $data_user = cdbutils::get_row("SELECT * FROM users WHERE id = '{$data_request_password->user_id}' AND status > 0");
            if (strtotime(date('Y-m-d H:i:s')) < $data_request_password->expired_date) {
                $err_code++;
                $err_message = "Masa berlaku token Anda telah habis. Lakukan reset password kembali!";
            }
            if ($data_request_password->is_done > 0) {
                $err_code++;
                $err_message = "Link sudah pernah digunakan";
            }
            if (empty($data_user)) {
                $err_code++;
                $err_message = "Data User tidak ditemukan";
            }
            if ($err_code == 0) {
                $user_id = $data_user->id;
                $username = $data_user->username;
                $email = $data_user->email;
                $password = __generate_password();
                $content = '<b style="font-size:22px">Hi ' .$username. ',</b>
                            <div style="margin-top:40px;">
                                <p>Password baru Anda.</p>
                                <table>
                                    <tr>
                                        <td>Username</td>
                                        <td> : </td>
                                        <td>'.$username.'</td>
                                    </tr>
                                    <tr>
                                        <td>Password Baru</td>
                                        <td> : </td>
                                        <td>'.$password.'</td>
                                    </tr>
                                </table>
                            </div> ';
                try {
                    $this->send_email($email, array(
                            'logo' => asset('public/img/logo.png'),
                            'subject' => $org_name . ' - New Password',
                            'content' => $content,
                        )
                    );
                } catch(\Exception $e) {
                    $err_code++;
                    $err_message = $e->getMessage();
                }
                
                DB::table("users")
                    ->where('id', $user_id)
                    ->update(array('password' => bcrypt($password)));
                DB::table("users_password_resets")
                    ->where('id', $data_request_password->id)
                    ->update(array('is_done' => 1));
            }
        } else {
            $err_code++;
            $err_message = "Token tidak ditemukan!";
        }

        $html = '';
        if ($err_code == 0) {
            DB::commit();
            $html = $this->success();
        } else {
            DB::rollback();
            $html = $this->fail();
        }
        $data['html'] = $html;
        return view('admin.auth.verify', $data);
    }
    
    public function success() {
        $html = '
            <div class="pb-3">
                <div>UBAH PASSWORD BAPAK / IBU <span style="color:red;">' . strtoupper(env('APP_NAME')) . '</span> BERHASIL</div>
                <div>Periksa kembali email Bpk/Ibu untuk melihat password baru.</div>
            </div>
            <div style="margin-bottom:5px">
                <a href="'.route('admin.login').'" style="font-size:18px;margin-top:20px;background:#df3f49;padding:10px 20px;color:white;text-decoration:none;">
                    Login Now
                </a>
            </div>
        ';
        return $html;
    }

    public function fail() {
        $html = '
            <div class="pb-3">
                <div>UBAH PASSWORD BAPAK / IBU <span style="color:red;">' . strtoupper(env('APP_NAME')) . '</span> GAGAL</div>
                <div>Silahkan ulangi kembali reset password Bpk/Ibu.</div>
            </div>
            <div style="margin-bottom:5px">
                <a href="#" style="font-size:18px;margin-top:20px;background:#df3f49;padding:10px 20px;color:white;text-decoration:none;">
                    Request New Password
                </a><br>
                <a href="'.route('admin.login').'" style="font-size:18px;margin-top:20px;background:#df3f49;padding:10px 20px;color:white;text-decoration:none;">
                    Take to Login
                </a>
            </div>
        ';
        return $html;
    }

    private function send_email($recipient, $data) {
        Mail::to($recipient)->send(new ForgotPassword($data));
    }
}