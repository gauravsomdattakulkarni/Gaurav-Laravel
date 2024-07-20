<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EncryptionModel;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Session;
use App\Models\Investment;
use App\Models\InvestmentPremimums;
use App\Models\InvestmentDocuments;
use Illuminate\Support\Facades\Storage;
date_default_timezone_set('Asia/Kolkata');

class UserController extends Controller
{
    protected $EncryptionModel;

    public function __construct(EncryptionModel $EncryptionModel)
    {
        $this->EncryptionModel = $EncryptionModel;
    }

    public function user_login(Request $request)
    {
        return view("user.auth.login");
    }

    public function user_login_success(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $username = $request->username;
        $password = $this->EncryptionModel->encrypt($request->password);
        $user_details = User::where('username','=',$username)->where('password','=',$password)->get();
        if($user_details->count()>0)
        {
            if($user_details[0]->two_fa_status=="active")
            {
                return redirect()->route('two_factor_auth', ['username' => $this->EncryptionModel->encrypt($username)]);   
            }
            else 
            {
                Session::put('username',$this->EncryptionModel->encrypt($username));
                Session::put('user_login',true);

                return redirect('user_dashboard');
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Invalid Username Or Password');
            return redirect('user_login');
        }
    }

    public function two_factor_auth(Request $request , $username)
    {
        $dec_username = $this->EncryptionModel->decrypt($username);
        $user_details = User::where('username','=',$dec_username)->get();
        if($user_details->count()>0)
        {
            $data['username'] = $dec_username;
            return view('user.auth.two_factor_auth',$data);
        }
        else 
        {
            $request->session()->flash('errormessage','User Details Not Found');
            return redirect('user_login');
        }
    }

    public function two_Step_auth_verification(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'verification_code' => 'required'
        ]);
        $username = $request->username;
        $verification_code = $request->verification_code;
        $user_details = User::where('username','=',$username)->get();
        $user_secret = $user_details[0]->sec_key;

        $google2fa = new Google2FA();
        $google_auth_validation = $google2fa->verifyKey($user_secret, $verification_code);
        if($google_auth_validation)
        {
            Session::put('username',$this->EncryptionModel->encrypt($username));
            Session::put('user_login',true);

            return redirect('user_dashboard');
        }
        else 
        {
            return redirect()->back()->with('errormessage', 'Invalid Verification Code');
        }
    }
    
    public function register(Request $request)
    {
        $google2fa = new Google2FA();
        $secretKey = "SAMKHJRCC2DL5YAF";
        $companyName = "Investment management";
        $companyEmail = "gaurav.somdatta.kulkarni@gmail.com";

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secretKey
        );

        // dd($qrCodeUrl);
        $data['qrCodeUrl'] = $qrCodeUrl;

        $link = $qrCodeUrl;
        
        
        return view('user.auth.two_factor_auth', [
            'link' => $link
        ]);       
    }

    public function manage_investment(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            $investment_details = Investment::where('username','=',$username)->paginate(10);
            
            $total_investments = Investment::where('username','=',$username)->count();
            $data['total_investments'] = $total_investments;
            $data['investment_details'] = $investment_details;
            return view('user.investment.manage_investment',$data);
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function delete_investment_success(Request $request)
    {
        $investment_id = $request->element_id;
        $investment_details = Investment::where('id','=',$investment_id)->get();
        if($investment_details->count()>0)
        {
            $delete_investment = Investment::where('id','=',$investment_id)->delete();
            if( $delete_investment)
            {
                $request->session()->flash('successmessage', 'Investment Deleted Successfully');
                $request->session()->flash('successtitle', 'Success');
                return redirect("manage_investment");
            }
            else 
            {
                $request->session()->flash('errormessage', 'Something Went Wrong');
                $request->session()->flash('errortitle', 'Error');
                return redirect("manage_investment");
            }
        }
        else 
        {
            $request->session()->flash('errormessage', 'Investment Details Not Found');
            $request->session()->flash('errortitle', 'Error');
            return redirect("manage_investment");
        }
    }

    public function add_investment(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            return view('user.investment.add_investment');
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }

    }

    public function add_investment_success(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $request->validate([
                'investment_plan_name' => 'required|string',
                'amc_name' => 'required|string',
                'account_number' => 'required|numeric',
                'premimum_frequency' => 'required|in:monthly,quarterly,half_yearly,yearly',
                'scheme_type' => 'required|string',
                'advisior' => 'required|string',
                'start_date' => 'required|date',
                'premimum_amount' => 'required|numeric|min:100',
            ]);
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            $investment_id = "INVEST-".rand(1111111111,9999999999).time();

            $investment = new Investment();
            $investment->investment_id = $investment_id;
            $investment->username = $username;
            $investment->investment_name = $this->EncryptionModel->encrypt($request->input('investment_plan_name'));
            $investment->amc_name = $this->EncryptionModel->encrypt($request->input('amc_name'));
            $investment->account_number = $this->EncryptionModel->encrypt($request->input('account_number'));
            $investment->premimum_frequency = $this->EncryptionModel->encrypt($request->input('premimum_frequency'));
            $investment->scheme_type = $this->EncryptionModel->encrypt($request->input('scheme_type'));
            $investment->advisior = $this->EncryptionModel->encrypt($request->input('advisior'));
            $investment->start_date = $this->EncryptionModel->encrypt($request->input('start_date'));
            $investment->premimum_amount = $this->EncryptionModel->encrypt($request->input('premimum_amount'));
        
            if($investment->save())
            {
                $request->session()->flash('successmessage', 'Investment Details Added Successfully');
                $request->session()->flash('successtitle', 'Success');
                return redirect("manage_investment");
            }
            else 
            {
                $request->session()->flash('errormessage', 'Something Went Wrong , Please Try After Sometime');
                $request->session()->flash('errortitle', 'Error');
                return redirect("manage_investment");
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function edit_investment(Request $request , $investment_id = null)
    {
        if($request->session()->has('user_login'))
        {
            if($investment_id==null)
            {
                $request->session()->flash('errormessage', 'Invalid Details');
                $request->session()->flash('errortitle', 'Error');
                return redirect("manage_investment");
            }
            else 
            {
                $investment_details = Investment::where('investment_id' , '=' , $investment_id)->get();
                if($investment_details->count()>0)
                {
                    $data['investment_details'] = $investment_details;
                    $data['investment_id'] = $investment_id;

                    return view('user.investment.edit_investment',$data);
                }
                else 
                {
                    $request->session()->flash('errormessage', 'Medicine Details Not Found');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect("manage_investment");
                }
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function update_investment_details_success(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $request->validate([
                'investment_id' => 'required',
                'investment_plan_name' => 'required|string',
                'amc_name' => 'required|string',
                'account_number' => 'required|numeric',
                'premimum_frequency' => 'required|in:monthly,quarterly,half_yearly,yearly',
                'scheme_type' => 'required|string',
                'advisior' => 'required|string',
                'start_date' => 'required|date',
                'premimum_amount' => 'required|numeric|min:100',
            ]);

            $investment_id = $request->input('investment_id');
            $investment = Investment::where('investment_id', $investment_id)->first();

            if ($investment) {
                $investment->investment_name = $this->EncryptionModel->encrypt($request->input('investment_plan_name'));
                $investment->amc_name = $this->EncryptionModel->encrypt($request->input('amc_name'));
                $investment->account_number = $this->EncryptionModel->encrypt($request->input('account_number'));
                $investment->premimum_frequency = $this->EncryptionModel->encrypt($request->input('premimum_frequency'));
                $investment->scheme_type = $this->EncryptionModel->encrypt($request->input('scheme_type'));
                $investment->advisior = $this->EncryptionModel->encrypt($request->input('advisior'));
                $investment->start_date = $this->EncryptionModel->encrypt($request->input('start_date'));
                $investment->premimum_amount = $this->EncryptionModel->encrypt($request->input('premimum_amount'));

                if ($investment->save()) {
                    $request->session()->flash('successmessage', 'Investment Details Updated Successfully');
                    $request->session()->flash('successtitle', 'Success');
                    return redirect("manage_investment");
                } else {
                    $request->session()->flash('errormessage', 'Something Went Wrong, Please Try After Sometime');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect("manage_investment");
                }
            } else {
                $request->session()->flash('errormessage', 'Investment Details Not Found');
                $request->session()->flash('errortitle', 'Error');
                return redirect("manage_investment");
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function get_investment_more_details(Request $request , $investment_id = null)
    {
        if($request->session()->has('user_login'))
        {
            if($investment_id==null)
            {
                $request->session()->flash('errormessage', 'Invalid Details');
                $request->session()->flash('errortitle', 'Error');
                return redirect("manage_investment");
            }
            else 
            {
                $username = $this->EncryptionModel->decrypt(Session::get('username'));
                $investment_details = Investment::where('investment_id','=', $investment_id)->where('username','=',$username)->get();
                $data['investment_details'] = $investment_details;
                if($investment_details->count()==0)
                {
                    $request->session()->flash('errormessage', 'Investment Details Not Found');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect("manage_investment");
                }
                else 
                {
                    $investment_premimum_details = InvestmentPremimums::where('investment_id', '=', $investment_id)
                    ->where('username', '=', $username)
                    ->orderBy('premimum_date', 'DESC')
                    ->paginate(10);
                    
                    $data['investment_premimum_details'] = $investment_premimum_details;

                    $investment_premimum_details_full = InvestmentPremimums::where('investment_id','=',$investment_id)->where('username','=',$username)->orderBy('premimum_date')->get();
                    
                    $total_amount_invested = 0;
                    foreach($investment_premimum_details_full as $premimum)
                    {
                        $total_amount_invested  += $this->EncryptionModel->decrypt($premimum->amount);
                    }
                    
                    $data['total_amount_invested'] = $total_amount_invested;
                    $total_premimum = InvestmentPremimums::where('investment_id','=',$investment_id)->where('username','=',$username)->count();
                    $data['total_premimum'] = $total_premimum;
                    $data['investment_id'] = $investment_id;
                    $investment_documents = InvestmentDocuments::where('investment_id','=',$investment_id)->where('username','=',$username)->orderBy('created_at','DESC')->get();
                    $data['investment_documents'] = $investment_documents;

                    return view('user.investment.investment_details',$data);
                }
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');   
        }
    }

    public function add_investment_premimum(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $request->validate([
                'investment_id' => 'required',
                'premimum_date' => 'required|date',
                'premimum_amount' => 'required|numeric',
                'premimum_mode' => 'required',
                'description' => 'required',
            ]);
            $username = $this->EncryptionModel->decrypt(Session::get('username'));

            $new_investment_premimum = new InvestmentPremimums();
            $new_investment_premimum->investment_id = $request->investment_id;
            $new_investment_premimum->premimum_date = $request->premimum_date;
            $new_investment_premimum->amount = $this->EncryptionModel->encrypt($request->premimum_amount);
            $new_investment_premimum->payment_mode = $this->EncryptionModel->encrypt($request->premimum_mode);
            $new_investment_premimum->description = $this->EncryptionModel->encrypt($request->description);
            $new_investment_premimum->username = $username;

            if($new_investment_premimum->save())
            {
                return redirect()->back()
                    ->with('successtitle', 'Success')
                    ->with('successmessage', 'Investment Installment Added Successfully');
            }
            else 
            {
                return redirect()->back()->withErrors(['errormessage' => 'Please Try After Sometime'])->with('errortitle', 'Something Went Wrong');
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');    
        }
    }
    public function add_investment_document(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $request->validate([
                'document_name' => 'required|string|max:255',
                'investment_document' => 'required|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:999999',
                'investment_id' => 'required',
            ]);
        
            $document = $request->file('investment_document');
            $ext = $document->extension();
            $random = rand('111111111', '999999999');
            $image_name = time() . $random . '.' . $ext;
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            
            $investment_document = $request->file('investment_document');
            $document_imageName = $investment_document->getClientOriginalName();
            $destinationPath = '../public/assets/investment_documents/';
            $investment_document->move($destinationPath,$investment_document->getClientOriginalName());
            $document_full_path = asset('assets/investment_documents/') . '/' . $document_imageName;

            $investment_document = new InvestmentDocuments();
            $investment_document->investment_id = $request->investment_id;
            $investment_document->document_name = $request->document_name;
            $investment_document->document = $document_full_path;
            $investment_document->document_type = $ext;
            $investment_document->username = $username;

            if($investment_document->save())
            {
                return redirect()->back()
                    ->with('successtitle', 'Success')
                    ->with('successmessage', 'Investment Document Added');
            }
            else 
            {
                return redirect()->back()->withErrors(['errormessage' => 'Document Cannot Be Uploaded Right Now , Please Try After Sometime'])->with('errortitle', 'Something Went Wrong');
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login'); 
        }
    }

    public function user_dashboard(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            $total_investments = Investment::where('username','=',$username)->count();
            $data['total_investments'] = $total_investments;
            $total_installents_paid = InvestmentPremimums::where('username','=',$username)->count();
            $data['total_installents_paid'] = $total_installents_paid;
            $total_installents_details = InvestmentPremimums::where('username','=',$username)->get();
            $total_installents_amount_paid = 0;
            foreach($total_installents_details as $investment_details)
            {
                $total_installents_amount_paid  = $total_installents_amount_paid  + $this->EncryptionModel->decrypt($investment_details->amount);
            }
            $data['total_installents_amount_paid'] = $total_installents_amount_paid;
            $total_uploaded_documents = InvestmentDocuments::where('username','=',$username)->count();
            $data['total_uploaded_documents'] = $total_uploaded_documents;
            return view('user.dashboard',$data);
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function logout(Request $request)
    {
        $username = $this->EncryptionModel->decrypt(Session::get('username'));
        Session::forget('username');
        Session::forget('user_login');
        $request->session()->flash('successmessage','Logout Successfull');
        return redirect('user_login');
    }

    public function account_settings(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            $username = $this->EncryptionModel->decrypt(Session::get('username'));
            $user_details = User::where('username','=',$username)->get();
            $data['user_details'] = $user_details;

            $google2fa = new Google2FA();
            $secretKey = $user_details[0]->sec_key;
            $companyName = "Investment management";
            $companyEmail = $this->EncryptionModel->decrypt($user_details[0]->email);

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                $companyName,
                $companyEmail,
                $secretKey
            );

            $data['qrCodeUrl'] = $qrCodeUrl;

            $link = $qrCodeUrl;

           
            return view('user.account_settings.settings',$data);
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function change_password_success(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            if($request->has('change_password_btn'))
            {
                $request->validate([
                    'current_password' => 'required|max:255',
                    'new_password' => 'required|max:255',
                    'confirm_password' => 'required|same:new_password|max:255',
                ],[
                    'confirm_password.same' => 'The new password and confirm password must be the same.',
                ]);

                $username = $this->EncryptionModel->decrypt(Session::get('username'));
                $user_details = User::where('username','=',$username)->get();
                if($user_details->count()>0)
                {
                    $current_password = $this->EncryptionModel->encrypt($request->current_password);
                    $password = $user_details[0]->password;
                    if($current_password == $password)
                    {
                        $new_password = $this->EncryptionModel->encrypt($request->new_password);
                        $update_user_password_data = [
                            'password' => $new_password
                        ];
                        $update_user_password = User::where('username','=',$username)->update($update_user_password_data);
                        if($update_user_password)
                        {
                            $request->session()->flash('successmessage', 'Password Changed Successfully');
                            $request->session()->flash('successtitle', 'Success');
                            return redirect('account_settings'); 
                        }
                        else 
                        {
                            $request->session()->flash('errormessage', 'Something Went Wrong , Please Try After Somtime');
                            $request->session()->flash('errortitle', 'Cannot Change Password');
                            return redirect('account_settings'); 
                        }
                    }
                    else 
                    {
                        $request->session()->flash('errormessage', 'Invalid Current Password');
                        $request->session()->flash('errortitle', 'Cannot Change Password');
                        return redirect('account_settings');   
                    }
                }
                else 
                {
                    $request->session()->flash('errormessage', 'Details Not Found');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect('account_settings');
                }
            }
            else 
            {
                $request->session()->flash('errormessage', 'Invalid Details');
                $request->session()->flash('errortitle', 'Error');
                return redirect('account_settings');
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function change_two_factor_status(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            if($request->has('change_two_step_verification_btn'))
            {
                $username = $this->EncryptionModel->decrypt(Session::get('username'));
                $user_details = User::where('username','=',$username)->get();
                if($user_details->count()>0)
                {
                    $current_status = $user_details[0]->two_fa_status;
                    if($current_status=="inactive")
                    {
                        $new_status="active";
                    }
                    else 
                    {
                        $new_status="inactive";
                    }

                    $update_user_twqo_step_verification_data = [
                            'two_fa_status' => $new_status
                        ];
                    $update_user_twqo_step_verification = User::where('username','=',$username)->update($update_user_twqo_step_verification_data);
                    if($update_user_twqo_step_verification)
                    {
                        $request->session()->flash('successmessage', 'Two Step Auth Status Changed Successfully');
                        $request->session()->flash('successtitle', 'Success');
                        return redirect('account_settings'); 
                    }
                    else 
                    {
                        $request->session()->flash('errormessage', 'Something Went Wrong , Please Try After Somtime');
                        $request->session()->flash('errortitle', 'Cannot Change Two Step Auth Status');
                        return redirect('account_settings'); 
                    }
                    
                }
                else 
                {
                    $request->session()->flash('errormessage', 'Details Not Found');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect('account_settings');
                }
            }
            else 
            {
                $request->session()->flash('errormessage', 'Invalid Details');
                $request->session()->flash('errortitle', 'Error');
                return redirect('account_settings');
            }
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }

    public function regenerate_qr_code(Request $request)
    {
        if($request->session()->has('user_login'))
        {
            
                $username = $this->EncryptionModel->decrypt(Session::get('username'));
                $user_details = User::where('username','=',$username)->get();
                if($user_details->count()>0)
                {
                    $google2fa = new Google2FA();
                    $secreat_key = $google2fa->generateSecretKey();

                    $update_user_twqo_step_verification_data = [
                            'sec_key' => $secreat_key
                        ];
                    $update_user_twqo_step_verification = User::where('username','=',$username)->update($update_user_twqo_step_verification_data);
                    if($update_user_twqo_step_verification)
                    {
                        $request->session()->flash('successmessage', 'QR Changed Successfully');
                        $request->session()->flash('successtitle', 'Success');
                        return redirect('account_settings'); 
                    }
                    else 
                    {
                        $request->session()->flash('errormessage', 'Something Went Wrong , Please Try After Somtime');
                        $request->session()->flash('errortitle', 'Cannot Change Google Authrnticator QR');
                        return redirect('account_settings'); 
                    }
                    
                }
                else 
                {
                    $request->session()->flash('errormessage', 'Details Not Found');
                    $request->session()->flash('errortitle', 'Error');
                    return redirect('account_settings');
                }
            
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('user_login');
        }
    }
}
