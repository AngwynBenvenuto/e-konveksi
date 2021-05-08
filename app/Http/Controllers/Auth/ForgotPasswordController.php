<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Lintas\helpers\cdbutils;
use Lintas\helpers\cmsg;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Illuminate\Support\Arr;
use Auth, Password, DB, Hash;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPasswordForm() {
        $err_code = 0;
        $err_message = "";
        $penjahit_id = "";
        $email = "";
        $content = "";
        $org_name = env('APP_NAME');

        $request = array_merge($_GET, $_POST);
        
        if($request != null) {
            $email = Arr::get($request, 'email');

            if($err_code == 0) {
                if(strlen($email) == 0) {
                    $err_code = 1345;
                    $err_message = "Email kosong";
                }
            }

            if($err_code == 0) {
                $data_penjahit = cdbutils::get_row("SELECT * FROM penjahit WHERE email = '{$email}' AND status > 0");
                if ($data_penjahit != null) {
                    $penjahit_id = $data_penjahit->id;
                    $username = $data_penjahit->name;
                    $email = $data_penjahit->email;
                    $token = __generate_token($data_penjahit->email);
                    $tommorow_time = strtotime(date('Y-m-d H:i:s') . "+1 days");
                    $expired_date = date('Y-m-d H:i:s', $tommorow_time);
                    
                    if (strlen($email) == 0) {
                        $err_code++;
                        $err_message = "Harap kontak administrator... Email dari user anda belum ada..";
                    }
    
                    try {
                        if ($err_code == 0) {
                            $content = '
                                <b style="font-size:22px">Hi ' . $username . ',</b>
                                <div style="margin-top:30px;font-size:18px;">
                                Siap mengganti password anda?
                                <br><br>
                                <a href="'.route('auth.password.change', $token).'" style="font-size:18px;margin-top:20px;background:#df3f49;padding:10px 20px;color:white;text-decoration:none;">
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
                        $data_request = array(
                            'penjahit_id' => $penjahit_id,
                            'token' => $token,
                            'expired_date' => $expired_date,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'status' => 1,
                        );
                        $insert = DB::table('penjahit_password_resets')
                                    ->insert($data_request);
                    }  
                } else {
                    $err_code++;
                    $err_message = "Data tidak ditemukan!";
                }
    
            }
            
            if($err_code > 0) {
                cmsg::add('error', $err_message);
            } else {
                cmsg::add('success', 'An email has sent to '.$email.' please check on your inbox or spam folder.');
            }

        }
        
        return view('auth.passwords.email');
    }

    private function send_email($recipient, $data) {
        Mail::to($recipient)->send(new ForgotPassword($data));
    }


}
