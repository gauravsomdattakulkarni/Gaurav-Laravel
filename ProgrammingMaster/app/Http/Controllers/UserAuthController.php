<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OtpVerification;
use App\Models\EncryptionModel;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserAccountVerification;

date_default_timezone_set('Asia/kolkata');


class UserAuthController extends Controller
{
    protected $EncryptionModel;

    public function __construct(EncryptionModel $EncryptionModel )
    {
        $this->EncryptionModel = $EncryptionModel;
    }

    public function user_authentication()
    {
        return view('user.auth.user_auth');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'mobile' => 'required|string',
            'country' => 'required|string|max:255',
        ]);


        try {
            $enc_email = $this->EncryptionModel->encrypt($request->input('email'));
            $enc_mobile = $this->EncryptionModel->encrypt($request->input('mobile'));

            $user = User::where('email', $enc_email)->first();
            $user_details_with_mobile = User::where('mobile', $enc_mobile)->first();
            if ($user ||$user_details_with_mobile ){
                $request->session()->flash('errortitle', "Registration Failed!");
                $request->session()->flash('errormessage', "User with this mobile or email already exist , please login to continue");
                return redirect('user_authentication');
            }

            $enc_password =$this->EncryptionModel->encrypt($request->input('password'));
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $enc_email;
            $user->password = $enc_password;
            $user->mobile = $enc_mobile;
            $user->country = $request->country;
            $user->account_status = 'Inactive';
            $user->web_login_status = 'Logged Out';

            $user->save();
            $user_id = $user->id;
            $enc_user_id = $this->EncryptionModel->encrypt($user_id);
            $base64_user_id = base64_encode($enc_user_id);

            Mail::to($request->input('email'))->send(new UserAccountVerification($request->first_name, $request->last_name, $request->email, $base64_user_id));


            $request->session()->flash('successtitle', "Registration Successful!");
            $request->session()->flash('successmessage', "Registration Successfull. Please verify your email.");
            return redirect('user_authentication');
        } catch (\Exception $e) {
            $request->session()->flash('errortitle', "Registration Failed!");
            $request->session()->flash('errormessage', $e->getMessage());
            return redirect('user_authentication');
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $enc_email = $this->EncryptionModel->encrypt($request->input('email'));
            $enc_password = $this->EncryptionModel->encrypt($request->input('password'));

            $user = User::where('email', $enc_email)->first();

            if (!$user) {
                $request->session()->flash('errortitle', "Login Failed!");
                $request->session()->flash('errormessage', "Invalid credentials.");
                return redirect('user_authentication');
            }

            if (is_null($user->email_verified_at)) {
                $request->session()->flash('errortitle', "Email Not Verified!");
                $request->session()->flash('errormessage', "Please verify your email before logging in.");
                return redirect('user_authentication');
            }

            if ($user->account_status !== 'Active') {
                $request->session()->flash('errortitle', "Account Inactive!");
                $request->session()->flash('errormessage', "Your account is inactive. Please contact support.");
                return redirect('user_authentication');
            }

            if ($user->password !== $enc_password) {
                $request->session()->flash('errortitle', "Login Failed!");
                $request->session()->flash('errormessage', "Invalid credentials.");
                return redirect('user_authentication');
            }

            $enc_user_id =$this->EncryptionModel->encrypt($user->id);

            Session::put('user_login',true);
            Session::put('logged_in_user_id',$enc_user_id);
            Session::put('logged_in_user_email',$enc_email);

            $user->web_login_status = 'Logged In';
            $user->save();

            $request->session()->flash('successtitle', "Success");
            $request->session()->flash('successmessage', "Login Successful!");
            return redirect('/');
        } catch (\Exception $e) {
            $request->session()->flash('errortitle', "Login Failed!");
            $request->session()->flash('errormessage', $e->getMessage());
            return redirect('user_authentication');
        }
    }


    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function account_verification($base64_user_id, Request $request)
    {
        try {
            $enc_user_id = base64_decode($base64_user_id);
            $user_id = $this->EncryptionModel->decrypt($enc_user_id);

            $user = User::find($user_id);
            if (!$user) {
                return view('user.account_verification')->with(['status' => 'error', 'message' => 'User not found.']);
            }

            if ($user->email_verified_at !== null) {
                return view('user.account_verification')->with(['status' => 'already_verified', 'message' => 'Your account is already verified.']);
            }

            $user->email_verified_at = now();
            $user->account_status = 'Active';
            $user->save();

            return view('user.account_verification')->with(['status' => 'success', 'message' => 'Your account has been successfully verified.']);
        } catch (\Exception $e) {
            Log::error('Account verification error: ' . $e->getMessage());
            return view('user.account_verification')->with(['status' => 'error', 'message' => "$e An error occurred during verification. Please try again later."]);
        }
    }
}
