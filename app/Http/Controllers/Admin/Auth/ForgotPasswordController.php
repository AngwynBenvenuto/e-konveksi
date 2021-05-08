<?php
namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, Password, DB, Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Lintas\helpers\cdbutils;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     * 
     * @return void
     */
    public function __construct(){
        $this->middleware('guest:admin');
    }

    /**
     * Show the reset email form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(){
        return view('admin.auth.passwords.email',[
            'title' => 'Admin Password Reset',
            'passwordEmailRoute' => 'admin.password.email'
        ]);
    }

    /**
     * password broker for admin guard.
     * 
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('admins');
    }

    public function requestForget() {
        $err_code = 0;
        $err_message = "";
        $email = '';
        $content = "";
        $org_name = env('APP_NAME');
        
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $username = $request['username'];
        }

        if($err_code == 0) {
            if(strlen($username) == 0) {
                $err_code++;
                $err_message = "Username tidak boleh kosong";
            }
        }

        if($err_code == 0) {
            $data_user = cdbutils::get_row("SELECT * FROM users WHERE username = '{$username}' AND status > 0");
            if ($data_user != null) {
                $user_id = $data_user->id;
                $username = $data_user->username;
                $email = $data_user->email;
                $token = __generate_token($data_user->email);
                $tommorow_time = strtotime(date('Y-m-d H:i:s') . "+1 days");
                $expired_date = date('Y-m-d H:i:s', $tommorow_time);
                
                if (strlen($email) == 0) {
                    $err_code++;
                    $err_message = "Harap kontak administrator... Email dari user anda belum ada..";
                }

                try {
                    if ($err_code == 0) {
                        $content = '
                            <b style="font-size:22px">Hi ' . $data_user->username . ',</b>
                            <div style="margin-top:30px;font-size:18px;">
                            Siap mengganti passsword anda?
                            <br><br>
                            <a href="'.route('admin.forgot.password', $token).'" style="font-size:18px;margin-top:20px;background:#df3f49;padding:10px 20px;color:white;text-decoration:none;">
                                Ganti Sekarang
                            </a>
                            </div>
                            <div style="margin-top:20px;font-size:18px">
                                Anda mempunyai 24 jam untuk mengganti password Anda.<br>
                                Setelah lewat dari jangka waktu, Anda dapat meminta link yang baru.
                            </div>
                        ';
                        $this->send_email($email, array(
                                'logo' => asset('public/img/logo.png'),
                                'subject' => $org_name . ' - Forgot Password',
                                'content' => $content,
                            )
                        );
                    }
                } catch (\Exception $e) {
                    $err_code++;
                    $err_message = $e->getMessage();
                }

                if ($err_code == 0) {
                    $data_request_forgot_password = array(
                        'user_id' => $user_id,
                        'token' => $token,
                        'expired_date' => $expired_date,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => 1,
                    );
                    $insert = DB::table('users_password_resets')
                                ->insert($data_request_forgot_password);
                }  
            } else {
                $err_code++;
                $err_message = "Data tidak ditemukan!";
            }
        }

        $response = array();
        if($err_code == 0) {
            $response['errCode'] = $err_code;
            $response['errMsg'] = $err_message;
            $response['email'] = $email;
        } else {
            $response['errCode'] = $err_code;
            $response['errMsg'] = $err_message;
        }
        return response()->json($response);
    }

    private function send_email($recipient, $data) {
        Mail::to($recipient)->send(new ForgotPassword($data));
    }

    
    /**
     * Get the guard to be used during authentication
     * after password reset.
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(){
        return Auth::guard('admin');
    }
}