<?php

namespace App\Http\Controllers\Auth;

use App\Models\Penjahit;
use App\Models\PenjahitVerify;
use Lintas\helpers\utils;
use App\Mail\Verification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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

    public function showRegistrationForm() {
        return view('auth.register');
     }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penjahit',
            'password' => 'required|min:6|string|required_with:password_confirmation',
            'password_confirmation' => 'min:6|same:password',
            'agreement' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //create penjahit
        $kode = utils::generatePenjahit($data['username']);
        //dd($kode);
        $dataPenjahit = array(
            'name' => $data['name'],
            'code' => $kode,
            'name_display' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'address' => $data['address'],
        );
        $penjahit = Penjahit::create($dataPenjahit);


        //sent email
        $verify = PenjahitVerify::create([
            'type' => 'email',
            'penjahit_id' => $penjahit->id,
            'verify_code' => utils::generateOtpCode(),
            'email' => $penjahit->email,
            'token' => str_random(40)
        ]);
        Mail::to($penjahit->email)->send(new Verification($penjahit));
        return $penjahit;
    }


    public function register(Request $request) {
        $this->validator($request->all())->validate();
        event(new Registered($penjahit = $this->create($request->all())));
        return redirect(url('auth/register_success?email='.$penjahit->email));
    }

    function registerSuccess() {
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $email = $request['email'];
        }

        $data = array();
        $data['email'] = $email;
        return view('auth.register_success', $data);
    }

}
