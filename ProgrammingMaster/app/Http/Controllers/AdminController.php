<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EncryptionModel;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Throwable;

date_default_timezone_set('Asia/kolkata');

class AdminController extends Controller
{
    protected $EncryptionModel;

    public function __construct(EncryptionModel $EncryptionModel)
    {
        $this->EncryptionModel = $EncryptionModel;
    }

    public function loginadmin(Request $request)
    {
        if($request->session()->has('admin_login'))
        {
            return redirect('dashboard');
        }
        else
        {
            return view("admin.auth.login");
        }
    }

    public function login_admin_success(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($request->has('login_admin_btn')){
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

                $email = $request->input('email');
                $password = $request->input('password');
                $enc_email = $this->EncryptionModel->encrypt($email);
                $enc_password = $this->EncryptionModel->encrypt($password);

                $admin_details = Admin::where('email','=',$enc_email)->get();
                if($admin_details->count()>0){
                    $admin_crr_password = $admin_details[0]->password;
                    if($enc_password==$admin_crr_password){
                        $two_step_verification = $this->send_otp($this->EncryptionModel->encrypt($email));
                        if($two_step_verification==true){
                            return redirect()->route('otp_verification', ['email' => $this->EncryptionModel->encrypt($email)]);
                        }
                        else{
                            $request->session()->flash('errortitle','Error');
                            $request->session()->flash('errormessage','Something went wrong! please try after sometime');
                            return redirect('loginadmin');
                        }
                    }else{
                        $request->session()->flash('errortitle','Error');
                        $request->session()->flash('errormessage','Invalid username or password 1');
                        return redirect('loginadmin');
                    }
                }else{
                    $request->session()->flash('errortitle','Error');
                    $request->session()->flash('errormessage','Invalid username or password 2');
                    return redirect('loginadmin');
                }
            }else{
                $request->session()->flash('errortitle','Error');
                $request->session()->flash('errormessage','Invalid details 3');
                return redirect('loginadmin');
            }
        }
        else{
            return redirect('loginadmin');
        }

    }

    private function send_otp($email)
    {
        $enc_email = $email;
        $email = $this->EncryptionModel->decrypt($email);
        $otp = rand(111111,999999);
        $subject = 'Programming Master || OTP Verification Code';
        try {
            Mail::to($email)->send(new OtpVerification($otp, $email, $subject));
            $enc_otp = $this->EncryptionModel->encrypt($otp);
            $update_admin_data = [
                'email_otp' => $enc_otp
            ];

            $update_admin = Admin::where('email','=',$enc_email)->update($update_admin_data);

            return true;

        }
        catch (Throwable $e) {
            return false;
        }
    }
    public function otp_verification(Request $request , $email)
    {
        $data['email'] = $email;
        return view("admin.auth.otp_verification",$data);
    }

    public function verify_otp_success(Request $request)
    {
        $request->validate([
            'admin_otp' => 'required|bail',
            'email' => 'required|bail',
            'ip_address' => 'required|bail'
        ], [
            'admin_otp.required' => 'Please enter a valid OTP.',
            'email.required' => 'Something went wrong, please refresh the page or try again later 1.',
            'ip_address.required' => 'Something went wrong, please refresh the page or try again later.'
        ]);

        $admin_otp = $request->input('admin_otp');
        $email = $request->input('email');
        $ip_address = $request->input('ip_address');

        $admin_details =  Admin::where('email','=',$email)->get();
        if($admin_details->count()>0){
            $valid_otp = $admin_details[0]->email_otp;
            $admin_otp = $this->EncryptionModel->encrypt($admin_otp);

            if($valid_otp==$admin_otp){
                Session::put('admin_login','true');
                return redirect('dashboard');
            }else{
                $request->session()->flash('errortitle','Error');
                $request->session()->flash('errormessage','Invalid OTP');
                return redirect()->back();
            }
        }else{
            $request->session()->flash('errortitle','Error');
            $request->session()->flash('errormessage','Invalid username or password');
            return redirect('loginadmin');
        }

    }

    public function dashboard(Request $request)
    {
        if($request->session()->has('admin_login'))
        {
            return view("admin.dashboard");
        }
        else
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('loginadmin');
        }
    }

}
