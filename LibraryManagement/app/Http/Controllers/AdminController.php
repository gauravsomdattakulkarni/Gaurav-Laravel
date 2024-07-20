<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EncryptionModel;
use App\Models\Admin;
use App\Models\Book;
use App\Models\BookQuantity;
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
                        $request->session()->flash('errormessage','Invalid username or password');
                        return redirect('loginadmin');
                    }
                }else{
                    $request->session()->flash('errortitle','Error');
                    $request->session()->flash('errormessage','Invalid username or password');
                    return redirect('loginadmin');
                }
            }else{
                $request->session()->flash('errortitle','Error');
                $request->session()->flash('errormessage','Invalid details');
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
        $subject = 'Vidya Vihar || OTP Verification Code';
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

    public function manage_books(Request $request)
    {
        if($request->session()->has('admin_login'))
        {
            $book_details = Book::All();
            $data['book_details'] = $book_details;

            return view("admin.books.manage_books",$data);
        }
        else 
        {
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('loginadmin');
        }
    }

    public function add_book(Request $request)
    {
        if($request->session()->has('admin_login')){
            return view("admin.books.add_book");
        }else{
            $request->session()->flash('errormessage','Session Time Out , Please Login Again');
            return redirect('loginadmin');
        }
    }

    public function add_book_success(Request $request)
    {

        $request->validate([
            'book_name' => 'required',
            'isbn_number' => 'required',
            'author_name' => 'required',
            'book_category' => 'required',
            'publisher' => 'required',
            'publication_year' => 'required',
            'cover_image' => 'required',
            'description' => 'required'
        ]);

        $book_name = $request->input('book_name');
        $isbn_number = $request->input('isbn_number');
        $author_name = $request->input('author_name');
        $book_category = $request->input('book_category');
        $publisher =  $request->input('publisher');
        $publication_year = $request->input('publication_year');
        $description = $request->input('description');

        $book_details = Book::where('isbn','=',$isbn_number)->get();
        if($book_details->count()==0){
            $cover_image = $request->file('cover_image');
            $extension = $cover_image->extension();
            $rand = rand(1111, 9999);
            $book_cover_image_name = "vidya_vihar_" . $isbn_number . '.' . $extension;
            $path = './public/assets/books';
            $cover_image->move($path, $book_cover_image_name);
            $full_path = asset('public/assets/books/' . $book_cover_image_name);


            $book = new Book();
            $book->isbn = $isbn_number;
            $book->book_name = $book_name;
            $book->author_name = $author_name;
            $book->category = $book_category;
            $book->publisher = $publisher;
            $book->publication_year = $publication_year;
            $book->description = $description;
            $book->cover_image = $full_path;
            $book->total_copies = 0;
            if($book->save()){
                $request->session()->flash('successtitle',"Success !");
                $request->session()->flash('successmessage',"Book details added successfully");
                return redirect('manage_books');
            }else{
                $request->session()->flash('errortitle',"Error !");
                $request->session()->flash('errormessage',"Something went wrong , please try after somtime");
                return redirect('add_book');
            }
        }else{
            $request->session()->flash('errortitle',"Error !");
            $request->session()->flash('errormessage',"Book with ISBN number $isbn_number already exist , please enter different ISBN number");
            return redirect('add_book');
        }
    }

    public function delete_book_success(Request $request)
    {
        $book_id_delete =  $request->input('book_id_delete');
        if($book_id_delete==null || $book_id_delete==0){
            $request->session()->flash('errortitle',"Error !");
            $request->session()->flash('errormessage',"Invalid details");
            return redirect('manage_books');
        }else{
            $book_details = Book::where('id','=',$book_id_delete)->get();
            if($book_details->count()>0){
                $delete_book = Book::where('id','=',$book_id_delete)->delete();
                if($delete_book){
                    $request->session()->flash('successtitle',"Success");
                    $request->session()->flash('successmessage',"Book deleted successfully ...");
                    return redirect('manage_books');
                }else{
                    $request->session()->flash('errortitle',"Error !");
                    $request->session()->flash('errormessage',"Something went wrong , please try after sometime");
                    return redirect('manage_books');
                }
            }else{
                $request->session()->flash('errortitle',"Error !");
                $request->session()->flash('errormessage',"Book details not found");
                return redirect('manage_books');
            }
        }
    }

    public function edit_book(Request $request , $enc_book_id)
    {
        $book_id = $this->EncryptionModel->decrypt($enc_book_id);
        $book_details = Book::where('id','=',$book_id)->get();
        if($book_details->count()>0){
            $data['enc_book_id'] = $enc_book_id;
            $data['book_details'] = $book_details;

            return view("admin.books.edit_book",$data);
        }else{
            $request->session()->flash('errortitle',"Error !");
            $request->session()->flash('errormessage',"Book details not found");
            return redirect('manage_books');
        }
    }

    public function update_book_success(Request $request)
    {
        $request->validate([
            'enc_book_id' => 'required',
            'book_name' => 'required|string|max:255',
            'isbn_number' => 'required|string|max:13',
            'author_name' => 'required|string|max:255',
            'book_category' => 'required|string',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200048',
            'description' => 'nullable|string',
        ]);

        $enc_book_id = $request->input('enc_book_id');
        $book_id = $this->EncryptionModel->decrypt($enc_book_id);
        $book = Book::findOrFail($book_id);

        $book_name = $request->input('book_name');
        $isbn_number = $request->input('isbn_number');
        $author_name = $request->input('author_name');
        $book_category = $request->input('book_category');
        $publisher = $request->input('publisher');
        $publication_year = $request->input('publication_year');
        $description = $request->input('description');

        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $extension = $cover_image->extension();
            $rand = rand(1111, 9999);
            $book_cover_image_name = "vidya_vihar_" . $isbn_number . '.' . $extension;
            $path = './public/assets/books';
            $cover_image->move($path, $book_cover_image_name);
            $full_path = asset('public/assets/books/' . $book_cover_image_name);
            $book->cover_image = $full_path;
        }

        $book->book_name = $book_name;
        $book->isbn = $isbn_number;
        $book->author_name = $author_name;
        $book->category = $book_category;
        $book->publisher = $publisher;
        $book->publication_year = $publication_year;
        $book->description = $description;

        $book->save();

        $request->session()->flash('successtitle',"Success !");
        $request->session()->flash('successmessage',"Book details edited successfully");
        return redirect('manage_books');
    }

    public function add_book_quantity(Request $request)
    {
        $book_details = Book::All();
        $data['book_details'] = $book_details;
        return view("admin.books.add_book_quantity",$data);
    }

    public function add_book_quantity_success(Request $request)
    {
        $request->validate([
            'book' => 'required',
            'book_quantity' => 'required|int|min:1',
            'acquisition_type' => 'required',
            'acquisition_date' => 'required'
        ]);

        $book_id = $request->input('book');
        $book_quantity = $request->input('book_quantity');
        $acquisition_type = $request->input('acquisition_type');
        $acquisition_date = $request->input('acquisition_date');

        $existing_quantity = BookQuantity::where('book_id','=',$book_id)->sum('quantity');
        $new_quantity = $existing_quantity + $book_quantity;
        
        $update_new_book_quantity_data = [
            'total_copies' => $new_quantity
        ];

        $update_new_book_quantity = Book::where('id','=',$book_id)->update($update_new_book_quantity_data );

        $BookQuantity = new BookQuantity();
        $BookQuantity->book_id = $book_id;
        $BookQuantity->quantity = $book_quantity;
        $BookQuantity->acquisition_type = $acquisition_type;
        $BookQuantity->acquisition_date = $acquisition_date;
        if($BookQuantity->save()){
            $request->session()->flash('successtitle',"Success");
            $request->session()->flash('successmessage',"Book Quantity Added Successfully !");
            return redirect('manage_books');
        }else{
            $request->session()->flash('errortitle',"Error !");
            $request->session()->flash('errormessage',"Something went wrong .......");
            return redirect('manage_books');
        }
    }
}
