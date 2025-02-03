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
use App\Models\Quiz;
use App\Models\QuizCategory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Throwable;

date_default_timezone_set('Asia/kolkata');

class QuizController extends Controller
{
    protected $EncryptionModel;

    public function __construct(EncryptionModel $EncryptionModel)
    {
        $this->EncryptionModel = $EncryptionModel;
    }

    public function manage_quiz(Request $request){
        $quizDetails = Quiz::All();
        $data['quizDetails'] = $quizDetails;
        return view("admin.quiz.manage_quiz",$data);
    }

    public function add_quiz(Request $request)
    {
        $quiz_categories = QuizCategory::where('category_status','=','Active')->get();
        $data['quiz_categories'] = $quiz_categories;
        return view("admin.quiz.add_quiz",$data);
    }

    public function add_quiz_success(Request $request)
    {
        $request->validate([
            'quiz_title' => 'required',
            'quiz_description' => 'required',
            'difficulty_level' => 'required',
            'programming_language' => 'required',
            'quiz_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quiz_category' => 'required',
            'negative_marking' => 'required'
        ]);

        $quiz_title = $request->input('quiz_title');
        $quiz_description = $request->input('quiz_description');
        $difficulty_level = $request->input('difficulty_level');
        $programming_language = $request->input('programming_language');

        $quiz_details = Quiz::where('quiz_title', '=', $quiz_title)->get();
        if ($quiz_details->count() == 0) {

            $quiz_image = $request->file('quiz_image');
            $extension = $quiz_image->extension();
            $rand = rand(1111, 9999);
            $quiz_image_name = "quiz_" . $quiz_title . '.' . $extension;
            $path = './public/assets/quizzes';
            $quiz_image->move($path, $quiz_image_name);
            $full_path = asset('public/assets/quizzes/' . $quiz_image_name);

            $quiz = new Quiz();
            $quiz->quiz_title = $quiz_title;
            $quiz->quiz_description = $quiz_description;
            $quiz->difficulty_level = $difficulty_level;
            $quiz->programming_language = $programming_language;
            $quiz->quiz_image = $full_path;
            $quiz->quiz_category = $request->input('quiz_category');
            $quiz->negative_marking = $request->input('negative_marking');

            if ($quiz->save()) {
                $request->session()->flash('successtitle', "Success !");
                $request->session()->flash('successmessage', "Quiz details added successfully");
                return redirect('manage_quiz');
            } else {
                $request->session()->flash('errortitle', "Error !");
                $request->session()->flash('errormessage', "Something went wrong, please try again later");
                return redirect('manage_quiz');
            }
        } else {
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz with the title '$quiz_title' already exists. Please choose a different title.");
            return redirect('manage_quiz');
        }
    }

    public function change_quiz_status(Request $request , $quiz_id){
        $quizDetails = Quiz::where('quiz_id','=',$quiz_id)->get();
        if($quizDetails[0]->quiz_status=="Active"){
            $updatedQuizStatus = "Inactive";
        }else{
            $updatedQuizStatus = "Active";
        }

        $updateQuizStatus = [
            'quiz_status' => $updatedQuizStatus
        ];
        $updateQuizDetails = Quiz::where('quiz_id','=',$quiz_id)->update($updateQuizStatus);

        if($updateQuizDetails){
            $request->session()->flash('successtitle', "Succeess !");
            $request->session()->flash('successmessage', "Quiz status updated successfully");
            return redirect('manage_quiz');
        }else{
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Something went wrong, please try again later");
            return redirect('manage_quiz');
        }
    }

    public function delete_quiz_success(Request $request)
    {
        $quiz_id = $request->input('quiz_id_delete');
        $quizDetails = Quiz::where('quiz_id','=',$quiz_id)->get();
        if($quizDetails->count()>0){
            $delete_quiz = Quiz::where('quiz_id','=',$quiz_id)->delete();
            if($delete_quiz){
                $request->session()->flash('successtitle', "Succeess !");
                $request->session()->flash('successmessage', "Quiz status deleted+ successfully");
                return redirect('manage_quiz');
            }else{
                $request->session()->flash('errortitle', "Error !");
                $request->session()->flash('errormessage', "Something went wrong, please try again later");
                return redirect('manage_quiz');
            }
        }else{
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz Details Not Found");
            return redirect('manage_quiz');
        }
    }

    public function edit_quiz(Request $request , $quiz_id)
    {
        $dec_quiz_id =  $this->EncryptionModel->decrypt($quiz_id);

        $quizDetails = Quiz::where('quiz_id','=',$dec_quiz_id)->get();
        if ($quizDetails->count()==0) {
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz Details Not Found");
            return redirect('manage_quiz');
        }

        $data['quizDetails'] = $quizDetails[0];
        $quiz_categories = QuizCategory::where('category_status','=','Active')->get();
        $data['quiz_categories'] = $quiz_categories;

        return view('admin.quiz.edit_quiz', $data);
    }

    public function update_quiz(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,quiz_id', // Ensure the quiz_id column exists
            'quiz_title' => 'required|string|max:255',
            'difficulty_level' => 'required|in:Easy,Medium,Difficult',
            'programming_language' => 'required|string|max:255',
            'quiz_description' => 'nullable|string|max:1000',
            'quiz_status' => 'required|in:Active,Inactive',
            'quiz_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quizDetails = Quiz::where('quiz_id', '=', $request->quiz_id)->get();

        if ($quizDetails->count() == 0) {
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz Details Not Found");
            return redirect('manage_quiz');
        }

        $quizDetails = $quizDetails->first(); // Get the first record since we expect only one result
        $quiz_update_data = [
            'quiz_title' => $request->quiz_title,
            'difficulty_level' => $request->difficulty_level,
            'programming_language' => $request->programming_language,
            'quiz_description' => $request->quiz_description,
            'quiz_status' => $request->quiz_status,
            'quiz_category' => $request->input('quiz_category'),
            'negative_marking' => $request->input('negative_marking')
        ];


        if ($request->hasFile('quiz_image')) {
            try {
                $imageName = time() . '.' . $request->quiz_image->extension();
                $path = $request->quiz_image->storeAs('uploads/quizzes', $imageName, 'public');
                $quiz_update_data['image_path'] = $path;
            } catch (\Exception $e) {
                $request->session()->flash('errortitle', "Error !");
                $request->session()->flash('errormessage', "Failed to upload the image.");
                return redirect('manage_quiz');
            }
        }

        Quiz::where('quiz_id', '=', $request->quiz_id)->update($quiz_update_data);

        $request->session()->flash('successtitle', "Success !");
        $request->session()->flash('successmessage', "Quiz updated successfully.");
        return redirect('manage_quiz');
    }

    public function quizes(Request $request)
    {
        $quizDetails = Quiz::where('quiz_status','=','Active')->get();
        $data['quizDetails'] = $quizDetails;
        return view("edu_quiz_hub.quizes",$data);
    }
}
