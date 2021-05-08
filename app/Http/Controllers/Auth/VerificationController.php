<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjahit;
use App\Models\PenjahitVerify;
use App\Mail\Verification;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use DB;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function sendVerification() {
        $errCode = 0;
        $errMsg = "";
        $email = "";
        $data = array();

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $email = Arr::get($request, 'email');
        }

        if($errCode == 0) {
            if(strlen($email) == 0) {
                $errCode = 146;
                $errMsg = "Email required";
            }

            if($errCode == 0) {
                $p = PenjahitVerify::where('email', '=', $email)->first();
                if($p != null) {
                    try{
                        $penjahit = $p->penjahit;
                        if($penjahit != null) {
                            $email = $penjahit->email;
                            $this->send_email($email, $penjahit);
                        }
                    } catch(\Exception $e) {
                        $errCode = 14667;
                        $errMsg = $e->getMessage();
                    }
                } else {
                   $modelPenjahit = Penjahit::where('status', '>', 0)->where('email', '=', $email)->first();
                   $this->createVerificationResend($email, $modelPenjahit);
                }
            } 
        }

        $text = 'error';
        $message = $errMsg;
        if($errCode == 0) {
            $text = 'success';
            $message = "Success to resend verification link to ".$email;
        } 
        return redirect()->to(route('login'))->with($text, $message);
    }
   
    public function confirmVerification($token) {
        $data = array();
        $errCode = 0;
        $errMsg = "";
        $email = "";
        $message = "";
        $request = array_merge($_GET, $_POST);

        if($errCode == 0) {
            if(strlen($token) == 0) {
                $errCode = 4141;
                $errMsg = "Token not found.";
            }
        }

        if($errCode == 0) {
            $penjahit_verify = PenjahitVerify::where('token', '=', $token)->first();
            if($penjahit_verify != null) {
                DB::beginTransaction();
                try{
                    $penjahit = $penjahit_verify->penjahit;
                    if($penjahit != null) {
                        $email = $penjahit->email;
                        $v = $penjahit->verified;
                        if($v == 0) {
                            $penjahit->verified = 1;
                            $saved = $penjahit->save();
                            if($saved) {
                               DB::commit();
                            }
                        } else {
                            $errCode = 2156;
                            $errMsg = "Penjahit sudah aktif.";
                        }
                    } else {
                        $errCode = 2222;
                        $errMsg = "Data penjahit tidak ditemukan";
                    }
                } catch(\Exception $e) {
                    $errCode = 156;
                    $errMsg = $e->getMessage();
                }
            } else {
                $errCode = 1356;
                $errMsg = "Data not found";
            }
        }
    
        if($errCode > 0) {
            cmsg::add('error', $errMsg);
        }
        $data['title'] = "Verification Email"; 
        $msg = "Success to verified email ".$email." now, you can login with your email";
        $data['message'] = ($errCode == 0 ? $msg : '');
        return view('auth.verify', $data);
    }

    private function send_email($recipient, $user) {
        Mail::to($recipient)->send(new Verification($user));
    }
    
    private function createVerificationResend($email, $user) {
        PenjahitVerify::create([
            'type' => 'email',
            'penjahit_id' => $user->id,
            'verify_code' => utils::generateOtpCode(),
            'email' => $email,
            'token' => str_random(40)
        ]);
        Mail::to($email)->send(new Verification($user));
    }   

}
