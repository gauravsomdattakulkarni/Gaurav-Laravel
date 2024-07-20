<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\BlogPost;
use App\Models\BlogPostImages;
use App\Models\EncryptionModel;
use App\Models\BlogPostComments;

date_default_timezone_set('Asia/Kolkata');

class BlogsController extends Controller
{
    protected $EncryptionModel;

    public function __construct(EncryptionModel $EncryptionModel)
    {
        $this->EncryptionModel = $EncryptionModel;
    }


    public function main_page(Request $request)
    {
        return redirect('/home');
    }

    public function home(Request $request, $page_no = 1 , $post_title = null)
    {
        $login_status = "not_logged_in";
        if ($request->session()->has('user_email')) {
            $user_email = $request->session()->get('user_email');
            $login_status = "logged_in";
        } else {
            $user_email = null;
        }

        $perPage = 10;
        $page_no = intval($page_no); // Cast $page_no to an integer
        $offset = ($page_no - 1) * $perPage;

        if($post_title!=null)
        {
         
            $post_title = $this->EncryptionModel->encrypt($post_title);

            $blog_posts = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
                ->select('blog_posts.*', 'blog_post_images.*')
                ->where('blog_posts.post_title', 'like', '%' . $post_title . '%')
                ->offset($offset)
                ->limit($perPage)
                ->get();
        }
        else 
        {
            $blog_posts = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
            ->select('blog_posts.*', 'blog_post_images.*')
            ->offset($offset)
            ->limit($perPage)
            ->get();
        }
        

        $total_blog_post_avaliable = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
        ->select('blog_posts.*', 'blog_post_images.*')->count();

        $data['total_blog_post_avaliable'] = $total_blog_post_avaliable;
        $data['user_email'] = $user_email;
        $data['login_status'] = $login_status;
        $data['blog_posts'] = $blog_posts;
        $data['page_no'] = $page_no;

        return view("insight_post.home", $data);
    }


    public function search_post(Request $request , $page_no = 1)
    {
        $post_title = $request->post_title;

        $login_status = "not_logged_in";
        if ($request->session()->has('user_email')) {
            $user_email = $request->session()->get('user_email');
            $login_status = "logged_in";
        } else {
            $user_email = null;
        }

        $perPage = 10;
        $page_no = intval($page_no); // Cast $page_no to an integer
        $offset = ($page_no - 1) * $perPage;

        if($post_title!=null)
        {
         
            $post_title = $this->EncryptionModel->encrypt($post_title);

            $blog_posts = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
                ->select('blog_posts.*', 'blog_post_images.*')
                ->where('blog_posts.post_title', 'like', '%' . $post_title . '%')
                ->offset($offset)
                ->limit($perPage)
                ->get();
        }
        else 
        {
           return redirect("/");
        }
        

        $total_blog_post_avaliable = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
        ->select('blog_posts.*', 'blog_post_images.*')->count();

        $data['total_blog_post_avaliable'] = $total_blog_post_avaliable;
        $data['user_email'] = $user_email;
        $data['login_status'] = $login_status;
        $data['blog_posts'] = $blog_posts;
        $data['page_no'] = $page_no;

        return view("insight_post.home", $data);
    }

    public function author_login(Request $request)
    {
        return view('author_auth.author_login');
    }

     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $token = $user->token;
            $refreshToken = $user->refreshToken;
            $expiresIn = $user->expiresIn;
        
            $token = $user->token;
            $tokenSecret = $user->tokenSecret;
        
            $Id = $user->getId();
            $nick_name = $user->getNickname();
            $name = $user->getName();
            $email = $user->getEmail();
            $avatar = $user->getAvatar();
            
            $existingUser = User::where('google_id', $user->id)->first();

            if ($existingUser) {
                Session::put('user_email', $existingUser->email);
                Session::put('user_login', true);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $this->EncryptionModel->encrypt($user->email),
                    'google_id' => $user->id,
                    'password' =>  encrypt('')
                ]);

                $username = $newUser->name;

                Session::put('user_email', $user->email);
                Session::put('user_login', true);
                return redirect('/home');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function author_logout(Request $request)
    {
        Session::forget('user_email');
        Session::forget('user_login');
        $request->session()->flash('successmessage','Logout Successfull');
        return redirect('/home');
    }

    public function create_post(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            $data['user_email'] = $user_email;
            $login_status = "logged_in";
            $data['login_status'] = $login_status;

            return view('insight_post.blog_post',$data);
        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function blog_post_upload(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            
            $validatedData = $request->validate([
                'post_title' => 'required|string|max:255',
                'post_description' => 'required|string',
                'post_category' => 'required|string',
                'post_image' => 'required',
            ]);

            $post_id = "INSIGHT-".rand(1111111111,9999999999).time();
            $blogPost = new BlogPost();
            $blogPost->post_id = $post_id;
            $blogPost->posted_by =  $this->EncryptionModel->encrypt($user_email);
            $blogPost->post_title =  $this->EncryptionModel->encrypt($request->post_title);
            $blogPost->description =  $this->EncryptionModel->encrypt($request->post_description);
            $blogPost->category = $request->post_category;
            $blogPost->save();

            $post_image = $request->file('post_image');
            $document_imageName = $post_image->getClientOriginalName();
            $destinationPath = '../public/assets/post_images/';
            $post_image->move($destinationPath,$post_image->getClientOriginalName());
            $document_full_path = asset('assets/post_images/') . '/' . $document_imageName;
           
            $blogPostImage = new BlogPostImages();
            $blogPostImage->post_id = $post_id;
            $blogPostImage->image_name = $document_imageName;
            $blogPostImage->image = $document_full_path;
            $blogPostImage->save();

            return redirect("/home");
        } else {
            return redirect("/author_login");
        }
    }

    public function blog_post_details(Request $request , $blog_post_id)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            $user_email = $this->EncryptionModel->encrypt($user_email);
           
            $user_details = User::where('email','=',$user_email)->get();
            $user_name = $user_details[0]->name;

            $data['user_name'] = $user_name;
            $data['user_email'] = $user_email;

            $login_status = "logged_in";
            $data['login_status'] = $login_status;

            $blog_post_details = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
            ->select('blog_posts.*', 'blog_post_images.*' )
            ->where('blog_posts.post_id', '=' ,$blog_post_id)
            ->get();



            $data['blog_post_details'] = $blog_post_details;
            
            $BlogPostComments = BlogPostComments::where("post_id",'=',$blog_post_id)->get();
            $data['BlogPostComments'] = $BlogPostComments;

            return view('insight_post.blog_post_details',$data);
        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function add_comment_success(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            $user_email = $this->EncryptionModel->encrypt($user_email);

            $validatedData = $request->validate([
                'blog_post_comment' => 'required',
                'post_id' => 'required'
            ]);
            
           
            $user_details = User::where('email','=',$user_email)->get();
           

            $BlogPostComments = new BlogPostComments();
            $BlogPostComments->post_id = $request->post_id;
            $BlogPostComments->comment_by = $user_details[0]->name; // Corrected variable name
            $BlogPostComments->comment = $request->blog_post_comment;
            if ($BlogPostComments->save()) {
                return redirect()->back()->with('success_message', 'Comment added successfully')->with('success_title', 'Success');
            } else {
                return redirect()->back()->with('error_message', 'Comment Cannot be Added')->with('error_title', 'Error');
            }

        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function edit_user_comment(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            $user_email = $this->EncryptionModel->encrypt($user_email);
            $edit_user_comment = $request->edit_user_comment;
            $comment_id = $request->comment_id;
            $edit_comment_data = [
                'comment' => $edit_user_comment,
                'edit_status' => 'Edited'
            ];

            $edit_comment = BlogPostComments::where('id','=',$comment_id)->update($edit_comment_data);
            if($edit_comment)
            {
                return redirect()->back()->with('success_message', 'Comment edited successfully')->with('success_title', 'Success');
            }
            else 
            {
                return redirect()->back()->with('error_message', 'Comment Cannot be Edited')->with('error_title', 'Error');
            }

        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function delete_comment_success(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');
            $user_email = $this->EncryptionModel->encrypt($user_email);
            $delete_comment_id = $request->delete_comment_id;
           
            $delete_comment = BlogPostComments::where('id','=',$delete_comment_id)->delete();
            if($delete_comment)
            {
                return redirect()->back()->with('success_message', 'Comment deleted successfully')->with('success_title', 'Success');
            }
            else 
            {
                return redirect()->back()->with('error_message', 'Comment Cannot be deleted')->with('error_title', 'Error');
            }

        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function my_post(Request $request,$page_no = 1)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login'))
        {

            $user_email = $request->session()->get('user_email');
            $user_email = $this->EncryptionModel->encrypt($user_email);

            $login_status = "logged_in";
            
            $perPage = 10;
            $page_no = intval($page_no);
            $offset = ($page_no - 1) * $perPage;

            
            $user_details = User::where('email','=',$user_email)->get();
            
            $name = $this->EncryptionModel->encrypt($user_details[0]->name);

            $blog_posts = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
                ->select('blog_posts.*', 'blog_post_images.*')
                ->where('blog_posts.posted_by', '=', $user_email) // Ensure $name holds the correct encrypted value
                ->offset($offset) // Ensure $offset is correctly defined
                ->limit($perPage) // Ensure $perPage is correctly defined
                ->get();
                
            $total_blog_post_avaliable = BlogPost::join('blog_post_images', 'blog_posts.post_id', '=', 'blog_post_images.post_id')
            ->select('blog_posts.*', 'blog_post_images.*')->count();

            $data['total_blog_post_avaliable'] = $total_blog_post_avaliable;
            $data['user_email'] = $user_email;
            $data['login_status'] = $login_status;
            $data['blog_posts'] = $blog_posts;
            $data['page_no'] = $page_no;

            return view('insight_post.my_posts',$data);
        }
        else 
        {
            return redirect("/author_login");
        }
    }

    public function edit_post(Request $request, $post_id)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login'))
        {
            $user_email = $request->session()->get('user_email');
            $data['user_email'] = $user_email;

            $login_status = "logged_in";
            $data['login_status'] = $login_status;

            $blog_post_details = BlogPost::where('post_id','=',$post_id)->get();
            $data['blog_post_details'] = $blog_post_details;

            $data['post_id'] = $post_id;

            return view('insight_post.edit_post',$data);
        }
        else 
        {
            return redirect("/author_login");
        }

    }

    public function blog_post_update(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $user_email = $request->session()->get('user_email');

            $validatedData = $request->validate([
                'post_title' => 'required|string|max:255',
                'post_description' => 'required|string',
                'post_category' => 'required|string',
            ]);

            $blog_post_details = BlogPost::where('post_id','=' ,$request->post_id)->first();
            
            if (!$blog_post_details) {
                return redirect('my_post')->with('error_title', 'Error')->with('error_message', 'Blog post not found.');
            }

            $blog_post_update_data = [
                'post_title' => $this->EncryptionModel->encrypt($request->post_title),
                'description' => $this->EncryptionModel->encrypt($request->post_description),
                'category' => $request->post_category,
                'edit_status' => "EDITED"
            ];
           
            $blog_post_update = BlogPost::where('post_id','=',$request->post_id)->update($blog_post_update_data);

            if ($request->hasFile('post_image')) {
                $post_image = $request->file('post_image');
                $document_imageName = $post_image->getClientOriginalName();
                $destinationPath = '../public/assets/post_images/';
                $post_image->move($destinationPath, $post_image->getClientOriginalName());
                $document_full_path = asset('assets/post_images/') . '/' . $document_imageName;

                $blogPostImage = new BlogPostImages();
                $blogPostImage->post_id = $request->post_id;
                $blogPostImage->image_name = $document_imageName;
                $blogPostImage->image = $document_full_path;
                $blogPostImage->save();
            }

            return redirect('my_post')->with('success_title', 'Success')->with('success_message', 'Blog post updated successfully.');

        } else {
            return redirect("/author_login");
        }
    }

    public function delete_post_success(Request $request)
    {
        if ($request->session()->has('user_email') && $request->session()->has('user_login')) {
            $request->validate([
                'delete_post_id' => 'required'
            ]);

            $BlogPost = BlogPost::where('post_id','=',$request->delete_post_id)->get();
            if($BlogPost->count()>0)
            {
                $BlogPostDelete = BlogPost::where('post_id','=',$request->delete_post_id)->delete();
                if($BlogPostDelete)
                {
                    return redirect('my_post')->with('success_title','Success')->with('success_message','Blog post  deleted successfully');
                }
                else 
                {
                    return redirect('my_post')->with('error_title','Error')->with('error_message','Could not delete blog post at this momemt , please try again later');
                }
            }
            else 
            {
                return redirect('my_post')->with('error_title', 'Error')->with('error_message', 'Blog post not found.');
            }
        }
        else 
        {
            return redirect("/author_login");
        }
    }
}
